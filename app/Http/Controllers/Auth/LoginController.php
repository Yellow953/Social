<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        // Redirect if already authenticated
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect('/admin/dashboard');
            }
            return redirect('/dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // First verify credentials
        if (Auth::validate($credentials)) {
            $user = User::where('email', $request->email)->first();

            // Block disabled accounts
            if (!$user->is_active) {
                throw ValidationException::withMessages([
                    'email' => ['Your account has been disabled. Please contact an administrator.'],
                ]);
            }

            // Log the user in immediately
            Auth::login($user, $remember);
            $request->session()->regenerate();

            // If email not verified, redirect to verification page
            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }

            // If 2FA is enabled, send code and hold behind 2FA gate
            if ($user->two_factor_enabled) {
                $otp = Otp::createForTwoFactor($user);
                Notification::route('mail', $user->email)
                    ->notify(new \App\Notifications\SendTwoFactorCodeNotification($otp->code));

                $request->session()->put('two_factor_pending', true);

                return redirect()->route('verify-2fa')
                    ->with('success', 'Please check your email for the two-factor authentication code.');
            }

            // No 2FA — update device and redirect
            $deviceIdentifier = User::generateDeviceIdentifier($request);
            $user->updateDeviceInfo($deviceIdentifier);

            if ($user->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            }
            return redirect()->intended('/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        // Clear device info on logout
        if ($user) {
            $user->device_identifier = null;
            $user->device_token = null;
            $user->save();
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
