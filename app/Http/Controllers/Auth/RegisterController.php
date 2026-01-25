<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        // Redirect if already authenticated
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'study_year' => 'required|integer|min:1|max:10',
            'major' => 'required|string|max:255',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Create user but don't verify email yet
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'study_year' => $request->study_year,
            'major' => $request->major,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'email_verified' => false,
            'two_factor_enabled' => true,
        ]);

        // Generate and send OTP
        $otp = Otp::createForRegistration($user->email);
        Notification::route('mail', $user->email)
            ->notify(new \App\Notifications\SendOtpNotification($otp->code));

        // Store user email in session for verification
        $request->session()->put('registration_email', $user->email);
        $request->session()->put('registration_user_id', $user->id);

        return redirect()->route('verify-otp')
            ->with('success', 'Registration successful! Please check your email for the verification code.');
    }
}
