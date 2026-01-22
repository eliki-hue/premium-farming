<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthenticatedSessionController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $response = Http::withOptions(['verify' => false])
            ->asForm()
            ->post(config('services.django.url') . '/api/auth/login/', [
                'username' => $request->username,
                'password' => $request->password,
            ]);

        if (! $response->successful()) {
            return back()->withErrors(['login' => 'Invalid credentials']);
        }

        // Django sets HttpOnly cookies
        return redirect('/');
    }

    public function logout(Request $request)
    {
        $djangoUrl = config('services.django.url');
        $djangoHost = parse_url($djangoUrl, PHP_URL_HOST);

        Http::withOptions(['verify' => false])
            ->withCookies($request->cookies->all(), $djangoHost)
            ->post($djangoUrl . '/api/auth/logout/');

        return redirect('/login');
    }
}
