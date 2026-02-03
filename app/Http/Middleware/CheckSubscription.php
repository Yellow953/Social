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

        // Check if accessing a locked material (route param may be 'session' or 'material')
        $material = $request->route('session') ?? $request->route('material');
        if ($material && $material->is_locked) {
            if (!$user || !$user->hasActiveSubscription()) {
                return redirect()->route('materials')
                    ->with('error', 'You need an active SOCIALPLUS subscription to access this material. Please subscribe and wait for admin approval.');
            }
        }

        return $next($request);
    }
}
