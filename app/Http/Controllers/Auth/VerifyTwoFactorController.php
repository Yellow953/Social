<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyTwoFactorController extends Controller
{
    /**
     * Show the 2FA verification form
     */
    public function show()
    {
        if (!Auth::check() || !session()->has('two_factor_pending')) {
            return redirect()->route('login')
                ->with('error', 'Please login first.');
        }

        return view('auth.verify-2fa');
    }

    /**
     * Verify 2FA code
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = Auth::user();

        if (!$user || !session()->has('two_factor_pending')) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please login again.');
        }

        $otp = Otp::verify($user->email, $request->code, 'two_factor');

        if (!$otp) {
            return back()->withErrors([
                'code' => 'Invalid or expired verification code. Please try again.',
            ])->withInput();
        }

        $otp->markAsUsed();

        $request->session()->forget('two_factor_pending');

        // Update device information
        $deviceIdentifier = User::generateDeviceIdentifier($request);
        $user->updateDeviceInfo($deviceIdentifier);

        if ($user->isAdmin()) {
            return redirect()->intended('/admin/dashboard')
                ->with('success', 'Login successful! Welcome back.');
        }
        return redirect()->intended('/dashboard')
            ->with('success', 'Login successful! Welcome back.');
    }

    /**
     * Resend 2FA code
     */
    public function resend(Request $request)
    {
        $user = Auth::user();

        if (!$user || !session()->has('two_factor_pending')) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please login again.');
        }

        $otp = Otp::createForTwoFactor($user);
        \Illuminate\Support\Facades\Notification::route('mail', $user->email)
            ->notify(new \App\Notifications\SendTwoFactorCodeNotification($otp->code));

        return back()->with('success', 'A new verification code has been sent to your email.');
    }
}
