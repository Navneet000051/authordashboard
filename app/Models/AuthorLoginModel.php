<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

/**
 * Ported from the CodeIgniter 3 Author_login_model.
 *
 * This is a plain data/repository class (not an Eloquent model) so the original
 * query-builder logic maps across almost 1:1. Methods return stdClass rows /
 * arrays exactly like CI's ->row() / ->result().
 */
class AuthorLoginModel
{
    /**
     * Authenticate an author against tblleads.
     * NOTE: passwords are compared in plaintext, exactly as the legacy app did.
     */
    public function login_data(string $email, string $pass): ?object
    {
        return DB::table('tblleads')
            ->whereRaw('LOWER(user_email) = ?', [strtolower($email)])
            ->where('user_password', $pass)
            ->first();
    }

    /**
     * Change an author's password.
     *
     * Faithful to the legacy behaviour: it matches ANY row carrying the given
     * old password, then updates the row identified by $id. Returns true on a
     * successful change, false when the old password does not match.
     */
    public function changePassword($id, $newpws, $oldpws): bool
    {
        $qu = DB::table('tblleads')->where('user_password', $oldpws)->first();

        if ($qu) {
            DB::table('tblleads')->where('id', $id)->update(['user_password' => $newpws]);

            return true;
        }

        return false;
    }

    /**
     * Build the author's book list from the three legacy source queries.
     * Reads the logged-in author id and lead_new flag from the session.
     */
    public function book_list(): array
    {
        $login   = session('author_login');
        $userId  = $login['user_id'] ?? null;
        $leadNew = $login['lead_new'] ?? null;

        if (empty($leadNew)) {
            $query2 = DB::table('tblleads')
                ->join('tblleads_create_package', 'tblleads_create_package.leadid', '=', 'tblleads.id')
                ->where('tblleads.id', $userId)
                ->where('tblleads_create_package.asf_send_date', '!=', '0000-00-00')
                ->select(
                    'tblleads_create_package.book_title',
                    'tblleads_create_package.leadid as lead_id',
                    'tblleads.lead_new',
                    'tblleads_create_package.id as id'
                )
                ->get()->all();

            $query1 = DB::table('tblleads')
                ->where('tblleads.id', $userId)
                ->select(
                    'tblleads.lead_booktitle as book_title',
                    'tblleads.id as lead_id',
                    'tblleads.lead_new',
                    'tblleads.id'
                )
                ->get()->all();

            $query3 = DB::table('tblleads')
                ->join('create_package_leads', 'create_package_leads.create_lead_id', '=', 'tblleads.id')
                ->join('chorus_asf', 'chorus_asf.lead_id', '=', 'create_package_leads.id')
                ->where('create_package_leads.asf_send_date', '!=', '0000-00-00')
                ->whereRaw('create_package_leads.asf_pdf_data IS NOT NULL')
                ->where('tblleads.id', $userId)
                ->where('chorus_asf.asf_new', '1')
                ->select(
                    'create_package_leads.booktitle as book_title',
                    'create_package_leads.create_lead_id as lead_id',
                    'chorus_asf.asf_new as lead_new',
                    'create_package_leads.id as id'
                )
                ->get()->all();

            return array_merge(array_merge($query1, $query2), $query3);
        }

        return DB::table('create_package_leads')
            ->join('tblleads', 'create_package_leads.create_lead_id', '=', 'tblleads.id')
            ->join('chorus_asf', 'chorus_asf.lead_id', '=', 'create_package_leads.id')
            ->where('create_package_leads.create_lead_id', $userId)
            ->whereRaw('create_package_leads.asf_pdf_data IS NOT NULL')
            ->select(
                'create_package_leads.booktitle as book_title',
                'create_package_leads.create_lead_id as lead_id',
                'tblleads.lead_new',
                'create_package_leads.id as id'
            )
            ->get()->all();
    }

    /**
     * Look up an author by email for the (legacy, UI-disabled) forgot-password
     * flow. The CI controller referenced Author_login_model->forget_pws() but
     * the method was missing from the model; reconstructed here as a simple
     * email lookup so the route no longer fatals if reached.
     */
    public function forget_pws(string $email): ?object
    {
        return DB::table('tblleads')
            ->whereRaw('LOWER(user_email) = ?', [strtolower($email)])
            ->first();
    }
}
