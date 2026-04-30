<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckoutProxyController extends Controller
{
    protected string $djangoBase;

    public function __construct()
    {
        // ✅ ONLY PHP HERE
        $this->djangoBase = config('services.django_api.url');
    }

    protected function getJwt(Request $request): string
    {
        $token = $request->session()->get('django_token');
        if (!$token) abort(401, 'Not authenticated');
        return $token;
    }

    protected function refreshAccessToken(Request $request): ?string
    {
        $refreshToken = $request->session()->get('django_refresh');
        if (!$refreshToken) return null;

        try {
            $response = Http::post("{$this->djangoBase}/api/auth/token/refresh/", [
                'refresh' => $refreshToken,
            ]);

            if ($response->successful()) {
                $newToken = $response->json('access');
                $request->session()->put('django_token', $newToken);
                return $newToken;
            }
        } catch (\Throwable $e) {
            Log::error('[CheckoutProxy] Token refresh failed', ['msg' => $e->getMessage()]);
        }

        return null;
    }

    protected function proxyRequest(Request $request, callable $makeRequest)
    {
        $response = $makeRequest($this->getJwt($request));

        if ($response->status() !== 401) {
            return response()->json($response->json(), $response->status());
        }

        $newToken = $this->refreshAccessToken($request);

        if (!$newToken) {
            $request->session()->forget(['django_token', 'django_refresh', 'django_user']);
            return response()->json([
                'message' => 'Session expired. Please log in again.',
                'expired' => true,
            ], 401);
        }

        $retry = $makeRequest($newToken);
        return response()->json($retry->json(), $retry->status());
    }

    /**
     * ✅ ADD THIS (FOR YOUR WHATSAPP FLOW)
     */
    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'cart_id' => 'required',
            'customer_name' => 'required|string',
            'phone_number' => 'required|string',
        ]);

        return $this->proxyRequest($request, function (string $token) use ($validated) {
            return Http::withToken($token)
                ->acceptJson()
                ->post("{$this->djangoBase}/api/ecommerce/place-order/", [
                    'cart_id' => $validated['cart_id'],
                    'customer_name' => $validated['customer_name'],
                    'phone_number' => $validated['phone_number'],
                ]);
        });
    }

    public function mpesa(Request $request)
    {
        $validated = $request->validate([
            'mpesa_number'  => 'required|string',
        ]);

        return $this->proxyRequest($request, function (string $token) use ($validated) {
            return Http::withToken($token)
                ->acceptJson()
                ->post("{$this->djangoBase}/api/ecommerce/checkout/mpesa/", [
                    'phone_number' => $validated['mpesa_number'],
                ]);
        });
    }

    public function paymentStatus(Request $request, string $checkoutRequestId)
    {
        return $this->proxyRequest($request, function (string $token) use ($checkoutRequestId) {
            return Http::withToken($token)
                ->acceptJson()
                ->get("{$this->djangoBase}/api/ecommerce/confirm-payment/", [
                    'checkout_request_id' => $checkoutRequestId,
                ]);
        });
    }

    public function orders(Request $request)
    {
        return $this->proxyRequest($request, function (string $token) {
            return Http::withToken($token)
                ->acceptJson()
                ->get("{$this->djangoBase}/api/ecommerce/orders/");
        });
    }

    public function orderDetail(Request $request, string $id)
    {
        return $this->proxyRequest($request, function (string $token) use ($id) {
            return Http::withToken($token)
                ->acceptJson()
                ->get("{$this->djangoBase}/api/ecommerce/orders/{$id}/");
        });
    }
}