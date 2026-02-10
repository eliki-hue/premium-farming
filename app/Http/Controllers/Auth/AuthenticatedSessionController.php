<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthenticatedSessionController extends Controller
{
    public function create(Request $request): View
    {
        if ($request->has('redirect')) {
            session(['url.intended' => $request->input('redirect')]);
        }

        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $response = Http::post(
            config('services.django_api.url') . '/api/auth/customer/login/',
            [
                'username' => $request->username,
                'email'    => $request->email,
                'password' => $request->password,
            ]
        );

        if ($response->failed()) {
            Log::error('Django login failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return back()->withErrors([
                'api' => $response->body(), // 👈 show real Django error
            ]);
        }

        $data = $response->json();

        // Save token from Django
        session(['django_token' => $data['access'] ?? $data['token'] ?? null]);

        return redirect()->intended('/products');
    }

    public function destroy(Request $request): RedirectResponse
    {
        session()->forget('django_token');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
