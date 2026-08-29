<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form
     */
    public function showForgotPasswordForm()
    {
        // Redirect if already authenticated
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('auth.forgot-password');
    }

    /**
     * Handle forgot password request
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );
        } catch (\Throwable $e) {
            // A mail transport failure must not blow up into a 500 page
            Log::error('Password reset email failed: '.$e->getMessage(), [
                'email' => $request->input('email'),
            ]);

            throw ValidationException::withMessages([
                'email' => ['We could not send the reset email right now. Please try again in a few minutes, or contact the admins at support@esibsocial.com.'],
            ]);
        }

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'We have emailed your password reset link. Please check your inbox and your junk/spam folder — it can take a few minutes to arrive.');
        }

        throw ValidationException::withMessages([
            'email' => [$this->messageFor($status)],
        ]);
    }

    /**
     * Turn a broker status into something a student can act on.
     */
    private function messageFor(string $status): string
    {
        return match ($status) {
            Password::RESET_THROTTLED => 'A reset link was already sent. Please check your inbox and junk/spam folder, then wait a minute before requesting another one.',
            Password::INVALID_USER => 'We could not find an account with that email address. Make sure you are using the university email you registered with.',
            default => __($status),
        };
    }
}
