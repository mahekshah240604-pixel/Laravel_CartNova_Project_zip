<?php
// app/Http/Middleware/AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    // public function handle(Request $request, Closure $next)
    // {
    //     if (!Auth::check() || !Auth::user()->is_admin) {
    //         abort(403, 'Access denied. Admin only.');
    //     }
    //     return $next($request);
    // }
    public function handle(Request $request, Closure $next)
{
    // Not logged in → login page
    if (!Auth::check()) {
        return redirect()->route('admin.login.form');
    }

    // Logged in but not admin → deny
    if (!Auth::user()->is_admin) {
        abort(403, 'Access denied. Admin only.');
    }

    return $next($request);
}
}