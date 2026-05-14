<?php
// app/Http/Controllers/Auth/ForgotPasswordController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // STEP 1 — Show find account form
    public function showFindForm()
    {
        return view('auth.forgot-password');
    }

    // STEP 1 — Send OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Enter your email address.',
            'email.email'    => 'Enter a valid email address.',
        ]);

        $user = User::where('email', strtolower($request->email))->first();

        if ($user) {
            $otp = rand(100000, 999999);

            DB::table('password_reset_tokens')
                ->where('email', $user->email)
                ->delete();

            DB::table('password_reset_tokens')->insert([
                'email'      => $user->email,
                'token'      => Hash::make((string) $otp),
                'created_at' => Carbon::now(),
            ]);

            Mail::send('emails.otp', ['otp' => $otp, 'user' => $user], function ($m) use ($user) {
                $m->to($user->email)
                  ->subject('Your Amazon Password Reset OTP');
            });
        }

        session(['reset_email' => $request->email]);

        return redirect()->route('password.otp-form')
                         ->with('status', 'If an account exists for that email, we sent an OTP.');
    }

    // STEP 2 — Show OTP form
    public function showVerifyForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.verify-otp');
    }

    // STEP 2 — Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ], [
            'otp.required' => 'Enter the OTP sent to your email.',
            'otp.digits'   => 'OTP must be exactly 6 digits.',
        ]);

        $email = session('reset_email');

        if (!$email) {
            return redirect()->route('password.request')
                             ->withErrors(['email' => 'Session expired. Please start again.']);
        }

        $record = DB::table('password_reset_tokens')
                    ->where('email', strtolower($email))
                    ->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'Invalid OTP. Please request a new one.']);
        }

        if (Carbon::parse($record->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        if (!Hash::check($request->otp, $record->token)) {
            return back()->withErrors(['otp' => 'Incorrect OTP. Please try again.']);
        }

        $resetToken = Str::random(64);

        DB::table('password_reset_tokens')
            ->where('email', $email)
            ->update(['token' => Hash::make($resetToken)]);

        session(['reset_token' => $resetToken]);

        return redirect()->route('password.reset-form');
    }

    // STEP 3 — Show new password form
    public function showResetForm()
    {
        if (!session('reset_email') || !session('reset_token')) {
            return redirect()->route('password.request');
        }
        return view('auth.reset-password');
    }

    // STEP 3 — Save new password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:6'],
        ], [
            'password.required'  => 'Enter your new password.',
            'password.confirmed' => 'Passwords must match.',
            'password.min'       => 'Password must be at least 6 characters.',
        ]);

        $email      = session('reset_email');
        $resetToken = session('reset_token');

        if (!$email || !$resetToken) {
            return redirect()->route('password.request')
                             ->withErrors(['email' => 'Session expired. Please start again.']);
        }

        $record = DB::table('password_reset_tokens')
                    ->where('email', strtolower($email))
                    ->first();

        if (!$record || !Hash::check($resetToken, $record->token)) {
            return redirect()->route('password.request')
                             ->withErrors(['email' => 'Invalid session. Please start again.']);
        }

        User::where('email', strtolower($email))
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where('email', $email)->delete();
        session()->forget(['reset_email', 'reset_token']);

        return redirect()->route('login')
                         ->with('status', 'Password reset successfully! Please sign in.');
    }

    // RESEND OTP
    public function resendOtp(Request $request)
    {
        $email = session('reset_email');

        if (!$email) {
            return redirect()->route('password.request');
        }

        $user = User::where('email', strtolower($email))->first();

        if ($user) {
            $otp = rand(100000, 999999);

            DB::table('password_reset_tokens')->where('email', $user->email)->delete();
            DB::table('password_reset_tokens')->insert([
                'email'      => $user->email,
                'token'      => Hash::make((string) $otp),
                'created_at' => Carbon::now(),
            ]);

            Mail::send('emails.otp', ['otp' => $otp, 'user' => $user], function ($m) use ($user) {
                $m->to($user->email)->subject('Your Amazon Password Reset OTP');
            });
        }

        return back()->with('status', 'A new OTP has been sent to your email.');
    }
}