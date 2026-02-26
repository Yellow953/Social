<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && session()->has('two_factor_pending')) {
            return redirect()->route('verify-2fa');
        }

        return $next($request);
    }
}
