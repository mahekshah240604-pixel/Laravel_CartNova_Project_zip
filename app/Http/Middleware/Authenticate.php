<?php
// app/Http/Middleware/Authenticate.php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * ✅ Redirect unauthenticated users to login page
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // ✅ ADMIN routes → admin login
        if ($request->is('admin/*')) {
            return route('admin.login.form');
        }

        // ✅ NORMAL users → normal login
        return route('login');
    }
}