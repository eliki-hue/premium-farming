<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VerifyDjangoSession
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $djangoToken = session('django_token');
        
        if (!$djangoToken) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active session',
                    'redirect' => route('login')
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        // Optional: Verify token with Django
        // You might want to make this configurable via env variable
        if (env('VERIFY_DJANGO_SESSION', true)) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $djangoToken,
                    'Accept' => 'application/json',
                ])->timeout(5) // Add timeout to prevent hanging
                  ->get(env('DJANGO_API_URL') . '/api/auth/verify/');

                if (!$response->successful()) {
                    // Clear invalid session
                    session()->forget(['django_token', 'django_user']);
                    
                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Session expired or invalid',
                            'redirect' => route('login')
                        ], 401);
                    }
                    return redirect()->route('login')->with('error', 'Your session has expired. Please login again.');
                }
                
                // Optional: Store or update user data from response
                if ($response->json('user')) {
                    session(['django_user' => $response->json('user')]);
                }
                
            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                // Handle connection errors gracefully
                Log::warning('Django connection failed: ' . $e->getMessage());
                
                // Option 1: Allow access anyway (degraded mode)
                // return $next($request);
                
                // Option 2: Show error but allow retry
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unable to verify session. Please try again.',
                        'retry' => true
                    ], 503);
                }
                
                return back()->with('warning', 'Unable to verify session. Please try again.');
                
            } catch (\Exception $e) {
                Log::error('Django session verification failed: ' . $e->getMessage());
                
                // For other errors, you might want to allow access to prevent lockouts
                // But log the error for investigation
            }
        }

        return $next($request);
    }
}