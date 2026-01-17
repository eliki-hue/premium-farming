<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
      public function login(Request $request)
    {
        $response = Http::post(
            'http://127.0.0.1:8000/api/auth/token/',
            [
                'username' => $request->username,
                'password' => $request->password,
            ]
        );

        if ($response->failed()) {
            return back()->withErrors(['login' => 'Invalid credentials']);
        }

        $data = $response->json();

        // Store tokens
        session([
            'access_token' => $data['access'],
            'refresh_token' => $data['refresh'],
        ]);

        return redirect('/home');
    }
    public function create(): View
    {
        return view('auth.login');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
