<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RegisteredUserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'email'    => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $response = Http::post(
            config('services.django_api.url') . '/api/auth/customer/signup/',
            [
                'username' => $request->username,
                'email'    => $request->email,
                'password' => $request->password,
            ]
        );

        if ($response->failed()) {
            return back()->withErrors(['email' => 'Registration failed'])->withInput();
        }

        return redirect()->route('login');
    }

    public function proxySignup(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3',
            'email'    => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $response = Http::post(
            config('services.django_api.url') . '/api/auth/customer/signup/',
            [
                'username' => $request->username,
                'email'    => $request->email,
                'password' => $request->password,
            ]
        );

        if ($response->failed()) {
            $data = $response->json();
            return back()->withErrors([
                'email' => $data['detail'] ?? 'Registration failed',
            ])->withInput();
        }

        return redirect()->route('login')
            ->with('success', 'Account created successfully. Please login.');
    }
}