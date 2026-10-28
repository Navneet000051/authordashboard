<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Replaces the legacy AuthorDashboard::loginSession() guard.
 * Redirects to the login page when there is no authenticated author session.
 */
class AuthorAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (empty($request->session()->get('author_login'))) {
            return redirect()->to('AuthorDashboard/login');
        }

        return $next($request);
    }
}
