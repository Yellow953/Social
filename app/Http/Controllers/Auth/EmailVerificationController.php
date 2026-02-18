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
     * Resend the verification email.
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
}
