# CodeIgniter 3 → Laravel 12 Conversion Notes

This app is a port of the **BFC Author Dashboard** from CodeIgniter 3
(`D:\xampp\htdocs\authorDB-backup`) to **Laravel Framework 12.70.1**.

The goal was a **faithful 1:1 behavioural port** — existing URLs, the remote
database, and the look & feel are preserved. Legacy quirks were kept rather than
"fixed", and security concerns are flagged below instead of being silently
changed.

---

## How to run

```bash
cd D:\xampp\htdocs\authorDB-laravel
php artisan serve --host=127.0.0.1 --port=8000
```

Then open <http://127.0.0.1:8000/> (the login page). Requires PHP 8.2+ (8.2.12
confirmed) and network access to the remote MySQL host.

- `APP_KEY` is already generated.
- DB, session, cache and queue settings are in `.env`.

---

## What was converted (scope: primary app only)

| CI 3 | Laravel 12 |
|------|-----------|
| `application/controllers/AuthorDashboard.php` | `app/Http/Controllers/AuthorDashboardController.php` |
| `application/models/Author_login_model.php` | `app/Models/AuthorLoginModel.php` (plain repository, uses `DB`) |
| `loginSession()` guard | `app/Http/Middleware/AuthorAuth.php` |
| `application/config/routes.php` + implicit routing | `routes/web.php` (same URLs, e.g. `/AuthorDashboard/index`) |
| `application/views/authordashboard/*.php` | `resources/views/authordashboard/*.blade.php` + `layouts/app.blade.php` |
| `authordashboard/assets/` | `public/authordashboard/assets/` (copied verbatim) |
| `base_url()` / `form_error()` | shims in `app/helpers.php` so view markup ports unchanged |

**Skipped** (per request): the `AuthorDashboard1` / `authordashboard1` backup
duplicates and the default `Welcome` controller.

---

## Key conversion decisions

- **Database reused as-is.** Points at the same remote MySQL (`bfcgroup`); no
  migrations were created or run. Session/cache/queue use file/sync drivers so
  Laravel never creates tables in that remote DB.
- **`strict => false`** on the MySQL connection (`config/database.php`). The
  legacy app ran without `ONLY_FULL_GROUP_BY`; several dashboard queries use a
  loose `GROUP BY` (selecting non-grouped columns) that fails under Laravel's
  default strict mode. Disabling strict restores the original behaviour.
- **CSRF kept on** (an improvement over the legacy app). Forms carry `@csrf` and
  AJAX calls send the token via `$.ajaxSetup` `X-CSRF-TOKEN` header.
- **`base_url()` shim** returns the app root URL with a trailing slash, so the
  hundreds of asset/link references in the views work with no edits.
- **`myprofile` city/state/country lookups** were moved out of the view (the CI
  view ran `$this->db` queries inline) into the controller and passed in.
- **`updatePass`** consolidates the password-change flow (validate → external
  API sync → update → flash/redirect) in the controller; the legacy model mixed
  redirects into the data layer.
- **`Author_login_model::forget_pws()`** was referenced by the CI controller but
  missing from the model. Reconstructed as a simple email lookup so the route no
  longer fatals (the forgot-password UI is disabled anyway).
- **`forget-password` / `forget_password` views** did not exist in the CI app
  (dead routes). Minimal standalone stubs were added.
- **`paymentop`** was already half-Blade in the legacy code and posts to a
  `paymentRequestnn` endpoint that does not exist in this app — kept as a
  non-functional placeholder, matching the original.
- External calls (`appChangePassword`, `myOrder` transaction API) were ported
  from raw cURL to Laravel's `Http` client.

---

## ⚠️ Security issues carried over from the legacy app (NOT fixed)

These were preserved to keep behaviour identical. Recommend addressing them
separately:

1. **Plaintext passwords.** `tblleads.user_password` is stored and compared in
   plaintext (`login_data`, `changePassword`). Logins and the external
   password-sync API all assume plaintext. Hashing would require a coordinated
   data migration across the shared DB and the bookstore admin API.
2. **Hardcoded credentials in source.** The legacy `smtp_mailer` / `send_email`
   held Gmail and SMTP passwords in code. The dead SMTP sender was **not**
   ported; the DB credentials now live in `.env` (keep it out of version
   control).
3. **`error_reporting(0)`** in the legacy controller hid all PHP warnings, and
   the views depend on it (undefined properties / array keys / variables render
   as empty rather than erroring). Laravel promotes those to fatal
   `ErrorException`s, so `AppServiceProvider::boot()` drops
   `E_WARNING`/`E_NOTICE`/`E_DEPRECATED` from `error_reporting()` to restore the
   original behaviour (genuine `E_ERROR`-class faults still surface). Controller
   accumulators were also initialised to 0. If you prefer strictness over
   fidelity, remove that line and guard the individual view accesses instead.
4. **Raw date interpolation** in a few `whereRaw(... BETWEEN "...")` clauses was
   kept 1:1. Values are server-generated dates, not user input, but parameter
   binding would be safer.

---

## Verified during the port

- App boots on Laravel 12.70.1; login page renders with all assets.
- Remote MySQL connects; `tblleads` and every referenced column/table exist.
- All ported queries execute (incl. the GROUP BY, financial-year, and multi-join
  `book_list` queries).
- All 28 routes resolve; every Blade view compiles (`view:cache`).

## Not yet verified

- The **authenticated UI flow with real data** (dashboard, profit, sales report,
  my-profile, work status) was not exercised end-to-end, because that requires
  logging in as a real author. Recommend a manual login with a known test
  account to confirm the dashboard charts and profit figures render as expected.
