<?php
// app/Http/Controllers/Auth/RegisterController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\RegisterSuccessMail;

class RegisterController extends Controller
{
    public function showForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'min:2', 'max:100'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
        ], [
            'name.required'      => 'Enter your name.',
            'name.min'           => 'Your name must be at least 2 characters.',
            'email.required'     => 'Enter your email or mobile number.',
            'email.email'        => 'Enter a valid email address.',
            'email.unique'       => 'An account already exists for this email address.',
            'password.required'  => 'Enter your password.',
            'password.confirmed' => 'Passwords must match.',
            'password.min'       => 'Passwords must be at least 6 characters.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => strtolower($request->email),
            'password' => Hash::make($request->password),
        ]);
        // MAIL SEND
try {
    Mail::to($user->email)
        ->send(new RegisterSuccessMail($user));
} catch (\Exception $e) {
    Log::error('Register Mail Error: ' . $e->getMessage());
}

        // ✅ Mark email verified immediately — skips verify-email page
        $user->forceFill(['email_verified_at' => now()])->save();

        Auth::login($user, remember: true);

        return redirect()->route('home')
                         ->with('status', 'Welcome, ' . $user->name . '! Your account has been created.');
    }
}