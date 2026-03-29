<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login page
     */public function create(Request $request): View
{
    if ($request->has('product_id')) {
        session(['cart_product_id' => $request->input('product_id')]);
    }
    return view('auth.login');
}


    /**
     * Handle login and save Django JWT token in session
     */
  public function store(Request $request): RedirectResponse
{
    $request->validate([
        'username' => 'required|string',
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

    // 1️⃣ Login to Django
    $response = Http::post(
        config('services.django_api.url') . '/api/auth/customer/login/',
        [
            'username' => $request->username,
            'email'    => $request->email,
            'password' => $request->password,
        ]
    );

    if ($response->failed()) {
        return back()->withErrors(['email' => 'Invalid credentials or login failed']);
    }

    $data = $response->json();

    $accessToken = $data['access'] ?? null;
    $refreshToken = $data['refresh'] ?? null;

    if (!$accessToken) {
        return back()->withErrors(['email' => 'Login succeeded but access token not returned']);
    }

    session([
        'django_token'   => $accessToken,
        'django_refresh' => $refreshToken,
        'django_user'    => $data['user'] ?? null,
    ]);

    // 2️⃣ Add product directly to Django via API (do NOT call your own Laravel proxy)
    $productId = session()->pull('cart_product_id');
    if ($productId) {
        $addResponse = Http::withHeaders([
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken,
        ])->post(
            config('services.django_api.url') . '/api/ecommerce/cart/items/',
            [
                'product'  => $productId,
                'quantity' => 1,
            ]
        );

        if ($addResponse->failed()) {
            // Optional: handle failure but don't block login
            \Log::error('Failed to add product to cart after login', [
                'product_id' => $productId,
                'response'   => $addResponse->body(),
            ]);
        }
    }

    // 3️⃣ Redirect to cart page
    return redirect('/cart');
}




    /**
     * Logout and remove token
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Forget Django token and user
        session()->forget(['django_token', 'django_user']);

        // Invalidate Laravel session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}