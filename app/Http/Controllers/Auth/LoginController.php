<?php
// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginSuccessMail;

class LoginController extends Controller
{
    public function showForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required'    => 'Enter your email address.',
            'email.email'       => 'Enter a valid email address.',
            'password.required' => 'Enter your password.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt([
            'email'    => strtolower($request->email),
            'password' => $request->password,
        ], $remember)) {    
            $request->session()->regenerate();
             $user = Auth::user();
             // ✅ EMAIL SEND karo
            Mail::to($user->email)->send(new LoginSuccessMail($user));
            return redirect()->intended(route('home'));

            return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Your password is incorrect or this account doesn\'t exist.',
            ]);
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Your password is incorrect or this account doesn\'t exist.',
            ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}