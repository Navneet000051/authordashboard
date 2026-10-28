<?php

use App\Http\Controllers\AuthorDashboardController;
use App\Http\Middleware\AuthorAuth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Ported from the CodeIgniter 3 routes.php + the AuthorDashboard controller's
| implicit method routing. URLs are kept identical (e.g. /AuthorDashboard/index)
| so existing links, forms and AJAX calls work unchanged.
*/

// default_controller => AuthorDashboard/login
Route::get('/', [AuthorDashboardController::class, 'login']);

// $route['paymentop'] = 'AuthorDashboard/paymentop';
Route::get('paymentop', [AuthorDashboardController::class, 'paymentop']);

Route::prefix('AuthorDashboard')->group(function () {
    // ---- Public (no auth) ----
    Route::get('login', [AuthorDashboardController::class, 'login']);
    Route::match(['get', 'post'], 'author_login', [AuthorDashboardController::class, 'author_login']);
    Route::get('logout', [AuthorDashboardController::class, 'logout']);
    Route::get('paymentop', [AuthorDashboardController::class, 'paymentop']);

    // Legacy forgot-password flow (disabled in the UI, kept for parity)
    Route::get('forget_password', [AuthorDashboardController::class, 'forget_password']);
    Route::get('recover_password', [AuthorDashboardController::class, 'recover_password']);
    Route::post('send_email', [AuthorDashboardController::class, 'send_email']);

    // ---- AJAX JSON endpoints (require a logged-in author) ----
    Route::post('getbookDetails', [AuthorDashboardController::class, 'getbookDetails'])->middleware(AuthorAuth::class);
    Route::post('getbookDetailsFilter', [AuthorDashboardController::class, 'getbookDetailsFilter'])->middleware(AuthorAuth::class);
    Route::post('getprofitDeatils', [AuthorDashboardController::class, 'getprofitDeatils'])->middleware(AuthorAuth::class);

    // ---- Protected pages ----
    Route::middleware(AuthorAuth::class)->group(function () {
        // Bare /AuthorDashboard is the dashboard (CI's default method).
        Route::get('/', [AuthorDashboardController::class, 'index']);
        // Any old /AuthorDashboard/index link redirects to the clean URL.
        Route::get('index', fn () => redirect()->to('AuthorDashboard'));
        Route::get('view_details', [AuthorDashboardController::class, 'view_details']);
        Route::get('payable', [AuthorDashboardController::class, 'payable']);

        // Both casings used across the legacy views
        Route::get('salesReport', [AuthorDashboardController::class, 'salesReport']);
        Route::get('salesreport', [AuthorDashboardController::class, 'salesReport']);

        Route::get('myrecord', [AuthorDashboardController::class, 'myrecord']);
        Route::get('book_publish', [AuthorDashboardController::class, 'book_publish']);
        Route::post('bookPublish', [AuthorDashboardController::class, 'bookPublish']);

        Route::get('refer_friend', [AuthorDashboardController::class, 'refer_friend']);
        Route::post('refer_friend_info', [AuthorDashboardController::class, 'refer_friend_info']);

        Route::get('bank_details', [AuthorDashboardController::class, 'bank_details']);

        Route::get('change_password', [AuthorDashboardController::class, 'change_password']);
        Route::post('updatePass', [AuthorDashboardController::class, 'updatePass']);

        Route::get('myOrder', [AuthorDashboardController::class, 'myOrder']);

        // Optional positional params: id / lead_id / leadnew
        Route::get('myprofile/{id?}/{lead_id?}/{leadnew?}', [AuthorDashboardController::class, 'myprofile']);

        // Optional book id
        Route::get('work_status/{id?}', [AuthorDashboardController::class, 'work_status']);
    });
});
