<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPOSAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access POS system');
        }

        $user = Auth::user();

        // Check if user has POS access
        // Method 1: Check pos_access field
        if ($user->pos_access ?? false) {
            return $next($request);
        }

        // Method 2: Check role (if using role system)
        if ($user->role && in_array($user->role, ['admin', 'manager', 'cashier', 'pos_user'])) {
            return $next($request);
        }

        // Method 3: Check is_admin
        if ($user->is_admin ?? false) {
            return $next($request);
        }

        // No POS access - redirect to regular dashboard
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access the POS system');
    }
}