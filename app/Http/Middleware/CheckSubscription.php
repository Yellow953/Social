<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Admins can always access
        if ($user && $user->isAdmin()) {
            return $next($request);
        }

        // Check if accessing a locked session
        if ($request->route('session') || $request->route('videoSession')) {
            $session = $request->route('session') ?? $request->route('videoSession');

            if ($session && $session->is_locked) {
                if (!$user || !$user->hasActiveSubscription()) {
                    return redirect()->route('sessions')
                        ->with('error', 'You need an active SOCIALPLUS subscription to access this session. Please subscribe and wait for admin approval.');
                }
            }
        }

        return $next($request);
    }
}
