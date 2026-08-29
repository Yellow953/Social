<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    /**
     * Show the reset password form
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Handle password reset
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Your password has been reset. You can now sign in with your new password.');
        }

        // An expired link is the common case here, and "invalid token" reads
        // like a broken site, so send them back to request a fresh one.
        if ($status === Password::INVALID_TOKEN) {
            return redirect()->route('password.request')->withErrors([
                'email' => 'This reset link is no longer valid — links expire 60 minutes after they are sent, and each one can only be used once. Please request a new link below.',
            ]);
        }

        throw ValidationException::withMessages([
            'email' => [$status === Password::INVALID_USER
                ? 'We could not find an account with that email address. Make sure you are using the university email you registered with.'
                : __($status)],
        ]);
    }
}
