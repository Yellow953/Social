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
        if (!session()->has('two_factor_user_id')) {
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

        $userId = session()->get('two_factor_user_id');
        $remember = session()->get('two_factor_remember', false);

        if (!$userId) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please login again.');
        }

        $user = User::findOrFail($userId);
        $otp = Otp::verify($user->email, $request->code, 'two_factor');

        if (!$otp) {
            return back()->withErrors([
                'code' => 'Invalid or expired verification code. Please try again.',
            ])->withInput();
        }

        // Mark OTP as used
        $otp->markAsUsed();

        // Log the user in
        Auth::login($user, $remember);
        $request->session()->regenerate();

        // Update device information for single device login
        $deviceIdentifier = User::generateDeviceIdentifier($request);
        
        // Check if trying to login from different device
        if (!empty($user->device_identifier) && !$user->isDeviceAllowed($deviceIdentifier)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors([
                    'email' => 'You cannot be logged in from multiple devices at the same time. Please log out from other devices first.',
                ]);
        }

        // Update device info
        $user->updateDeviceInfo($deviceIdentifier);

        // Clear session
        $request->session()->forget(['two_factor_user_id', 'two_factor_remember']);

        return redirect()->intended('/dashboard')
            ->with('success', 'Login successful! Welcome back.');
    }

    /**
     * Resend 2FA code
     */
    public function resend(Request $request)
    {
        $userId = session()->get('two_factor_user_id');

        if (!$userId) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please login again.');
        }

        $user = User::findOrFail($userId);

        // Generate and send new 2FA code
        $otp = Otp::createForTwoFactor($user);
        \Illuminate\Support\Facades\Notification::route('mail', $user->email)
            ->notify(new \App\Notifications\SendTwoFactorCodeNotification($otp->code));

        return back()->with('success', 'A new verification code has been sent to your email.');
    }
}
