<?php
// app/Http/Controllers/Admin/AdminAuthController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // ── Show Admin Login Form ──────────────────────────────────
    // Route: GET /admin/login
    public function showLogin()
    {
        // Already logged in as admin → go to dashboard
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        // Logged in but not admin → show access denied
        if (Auth::check() && !Auth::user()->is_admin) {
            return redirect()->route('home')
                ->with('error', 'Access denied. You do not have admin privileges.');
        }
        return view('admin.auth.login');
    }

    // ── Handle Admin Login ─────────────────────────────────────
    // Route: POST /admin/login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Enter your email address.',
            'password.required' => 'Enter your password.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt([
            'email'    => strtolower($request->email),
            'password' => $request->password,
        ], $remember)) {

            $request->session()->regenerate();

            // Check admin privilege
            if (!Auth::user()->is_admin) {
                Auth::logout();
                $request->session()->invalidate();
                return back()
                    ->withErrors(['email' => 'Access denied. This account does not have admin privileges.'])
                    ->withInput($request->only('email'));
            }

            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        return back()
            ->withErrors(['email' => 'These credentials do not match our records.'])
            ->withInput($request->only('email'));
    }

    // ── Admin Logout ───────────────────────────────────────────
    // Route: POST /admin/logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.form')
            ->with('success', 'You have been signed out of the admin panel.');
    }
}