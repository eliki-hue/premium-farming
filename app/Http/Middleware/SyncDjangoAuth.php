<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SyncDjangoAuth
{
    public function handle(Request $request, Closure $next)
    {
        // ✅ Skip auth sync for public pages
        if ($request->is('products') || $request->is('/') || $request->is('shop/*')) {
            return $next($request);
        }

        try {
            $djangoUrl = config('services.django.url');

            if (!$djangoUrl) {
                Auth::logout();
                return $next($request);
            }

            $parsed = parse_url($djangoUrl);
            $domain = $parsed['host'] ?? '127.0.0.1';

            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 5,
            ])->withCookies(
                $request->cookies->all(),
                $domain
            )->get($djangoUrl . '/api/auth/me/');

            if ($response->successful()) {
                // Fake local login so Blade @auth works
                Auth::loginUsingId(1);
            } else {
                Auth::logout();
            }

        } catch (\Throwable $e) {
            Auth::logout();
        }

        return $next($request);
    }
}
