<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        // Redirect if already authenticated
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect('/admin/dashboard');
            }
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
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                function ($attribute, $value, $fail) {
                    $domain = strtolower(substr(strrchr($value, '@'), 1) ?: '');
                    if ($domain === '' || !preg_match('/^outlook\./i', $domain)) {
                        $fail('Registration is only allowed with an Outlook email address (e.g. name@outlook.com).');
                    }
                },
            ],
            'phone' => 'required|string|max:20',
            'study_year' => 'required|string|in:Sup,Spé,1e,2e,3e',
            'major' => ['required', 'string', Rule::in(config('majors'))],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Create user (email not verified yet)
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

        Auth::login($user);

        event(new Registered($user));

        return redirect()->route('verification.notice')
            ->with('success', 'Registration successful! Please check your email for the verification link.');
    }
}
