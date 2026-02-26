<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    /**
     * Display the email verification notice.
     */
    public function notice(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $request->user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('dashboard');
        }
        return view('auth.verify-email');
    }

    /**
     * Handle the verification link click.
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect()->route($request->user()->isAdmin() ? 'admin.dashboard' : 'dashboard')
            ->with('success', 'Email verified successfully! Welcome to ESIB SOCIAL.');
    }

    /**
     * Resend the verification email (authenticated).
     */
    public function send(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $request->user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('dashboard');
        }
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Verification link sent! Please check your email.');
    }

    /**
     * Resend the verification email from the login page (unauthenticated).
     */
    public function resendFromLogin(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && !$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        return back()->with('resend_success', 'If that email exists and is unverified, we\'ve sent a new verification link. Please check your inbox.');
    }
}
