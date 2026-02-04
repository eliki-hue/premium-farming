<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        if ($request->has('redirect')) {
            session(['url.intended' => $request->input('redirect')]);
        }
        
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $djangoResponse = $this->authenticateWithDjango($request);

        $redirectResponse = redirect()->intended(route('products', absolute: false));

        if ($djangoResponse && $djangoResponse->successful()) {
            $redirectResponse = $this->attachDjangoCookies($djangoResponse, $redirectResponse);
        }

        return $redirectResponse;
    }

    
    private function authenticateWithDjango(Request $request)
    {
        try {
            $djangoUrl = config('services.django.url');
            $djangoDomain = config('services.django.domain');
            
            $user = Auth::user();
            
            Log::info('Attempting Django authentication', [
                'email' => $user->email,
                'url' => $djangoUrl . '/api/auth/login/',
            ]);
            
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 15,
            ])->post($djangoUrl . '/api/auth/login/', [
                'email' => $user->email,
                'password' => $request->password,
            ]);

            if ($response->successful()) {
                Log::info('Django authentication successful', [
                    'user' => $user->email,
                    'cookies_count' => count($response->cookies()),
                ]);
                return $response;
            } else {
                Log::warning('Django authentication failed', [
                    'user' => $user->email,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return null;
            }
        } catch (\Throwable $e) {
            Log::error('Error authenticating with Django', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }

   
    private function attachDjangoCookies($djangoResponse, $laravelResponse)
    {
        $cookies = $djangoResponse->cookies();
        
        foreach ($cookies as $cookie) {
            Log::info('Attaching Django cookie', [
                'name' => $cookie->getName(),
                'value' => substr($cookie->getValue(), 0, 20) . '...',
                'domain' => $cookie->getDomain(),
                'path' => $cookie->getPath(),
                'expires' => $cookie->getExpiresTime(),
            ]);
            
            $laravelResponse->withCookie(cookie(
                $cookie->getName(),
                $cookie->getValue(),
                $cookie->getExpiresTime() ? ($cookie->getExpiresTime() - time()) / 60 : 525600,
                $cookie->getPath() ?: '/',
                $cookie->getDomain(),
                $cookie->getSecure(),
                $cookie->getHttpOnly(),
                false,
                $cookie->getSameSite() ?: 'Lax'
            ));
        }
        
        return $laravelResponse;
    }

    
    public function destroy(Request $request): RedirectResponse
    {
        $this->logoutFromDjango($request);
        
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    
    private function logoutFromDjango(Request $request)
    {
        try {
            $djangoUrl = config('services.django.url');
            $djangoDomain = config('services.django.domain');
            
            Http::withOptions([
                'verify' => false,
                'timeout' => 15,
            ])
            ->withCookies($request->cookies->all(), $djangoDomain)
            ->post($djangoUrl . '/api/auth/logout/');
            
            Log::info('Django logout successful');
        } catch (\Throwable $e) {
            Log::error('Error logging out from Django', [
                'message' => $e->getMessage(),
            ]);
        }
    }
}