<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle registration using Django ONLY
     */
    public function store(Request $request)
{
    $request->validate([
        'username' => 'required|string',
        'email' => 'required|email',
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
        return back()->withErrors(['email' => 'Registration failed']);
    }

    return redirect()->route('/login');
}

}
