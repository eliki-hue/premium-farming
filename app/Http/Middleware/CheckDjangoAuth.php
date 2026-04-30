<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class CheckDjangoAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = Session::get('django_token') ?? Cookie::get('django_token');
        
        $django_user = null;
        
        if ($token) {
            try {
                $response = Http::withToken($token)
                    ->timeout(5)
                    ->get(config('services.django_api.url') . '/api/auth/me/');
                
                if ($response->successful()) {
                    $django_user = $response->json();
                } else {
                    // Token invalid, clear it
                    Session::forget('django_token');
                    Cookie::queue(Cookie::forget('django_token'));
                }
            } catch (\Exception $e) {
                // API not reachable, continue anyway
            }
        }
        
        // Share with all views
        view()->share('django_user', $django_user);
        view()->share('django_token', $token);
        
        return $next($request);
    }
}