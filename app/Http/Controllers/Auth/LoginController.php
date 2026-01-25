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

            // Check if email is verified
            if (!$user->hasVerifiedEmail()) {
                throw ValidationException::withMessages([
                    'email' => ['Please verify your email address before logging in.'],
                ]);
            }

            // Check if 2FA is enabled
            if ($user->two_factor_enabled) {
                // Generate and send 2FA code
                $otp = Otp::createForTwoFactor($user);
                Notification::route('mail', $user->email)
                    ->notify(new \App\Notifications\SendTwoFactorCodeNotification($otp->code));

                // Store user ID in session for 2FA verification
                $request->session()->put('two_factor_user_id', $user->id);
                $request->session()->put('two_factor_remember', $remember);

                return redirect()->route('verify-2fa')
                    ->with('success', 'Please check your email for the two-factor authentication code.');
            }

            // If 2FA is disabled, proceed with normal login
            Auth::login($user, $remember);
            $request->session()->regenerate();

            // Update device information for single device login
            $deviceIdentifier = User::generateDeviceIdentifier($request);
            
            // Check if trying to login from different device
            if (!empty($user->device_identifier) && !$user->isDeviceAllowed($deviceIdentifier)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                throw ValidationException::withMessages([
                    'email' => ['You cannot be logged in from multiple devices at the same time. Please log out from other devices first.'],
                ]);
            }

            // Update device info
            $user->updateDeviceInfo($deviceIdentifier);

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

        return redirect('/');
    }
}
