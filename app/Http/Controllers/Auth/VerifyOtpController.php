<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyOtpController extends Controller
{
    /**
     * Show the OTP verification form
     */
    public function show()
    {
        if (!session()->has('registration_email')) {
            return redirect()->route('register')
                ->with('error', 'Please register first.');
        }

        return view('auth.verify-otp');
    }

    /**
     * Verify OTP code
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $email = session()->get('registration_email');
        $userId = session()->get('registration_user_id');

        if (!$email || !$userId) {
            return redirect()->route('register')
                ->with('error', 'Session expired. Please register again.');
        }

        $otp = Otp::verify($email, $request->code, 'registration');

        if (!$otp) {
            return back()->withErrors([
                'code' => 'Invalid or expired verification code. Please try again.',
            ])->withInput();
        }

        // Mark OTP as used
        $otp->markAsUsed();

        // Verify user's email
        $user = User::findOrFail($userId);
        $user->markEmailAsVerified();

        // Clear session
        $request->session()->forget(['registration_email', 'registration_user_id']);

        // Log the user in
        Auth::login($user);

        // Redirect based on user role (though new registrations are always users)
        if ($user->isAdmin()) {
            return redirect('/admin/dashboard')
                ->with('success', 'Email verified successfully! Welcome to ESIB SOCIAL.');
        }
        return redirect('/dashboard')
            ->with('success', 'Email verified successfully! Welcome to ESIB SOCIAL.');
    }

    /**
     * Resend OTP code
     */
    public function resend(Request $request)
    {
        $email = session()->get('registration_email');
        $userId = session()->get('registration_user_id');

        if (!$email || !$userId) {
            return redirect()->route('register')
                ->with('error', 'Session expired. Please register again.');
        }

        $user = User::findOrFail($userId);

        // Generate and send new OTP
        $otp = Otp::createForRegistration($email);
        \Illuminate\Support\Facades\Notification::route('mail', $email)
            ->notify(new \App\Notifications\SendOtpNotification($otp->code));

        return back()->with('success', 'A new verification code has been sent to your email.');
    }
}
