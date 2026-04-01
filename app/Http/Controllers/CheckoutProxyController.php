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
async function getCSRF() {
    const res = await fetch('/api/ecommerce/csrf-token', {
        credentials: 'same-origin'  // same-origin, not include
    });
    const data = await res.json();
    csrfToken = data.csrf_token;
}
        $this->djangoBase = config('services.django_api.url');
    }

    /* ═══════════════════════════════════════════════════════════
       getJwt() — reads JWT from Laravel session
    ═══════════════════════════════════════════════════════════ */
    protected function getJwt(Request $request): string
    {
        $token = $request->session()->get('django_token');
        if (!$token) abort(401, 'Not authenticated');
        return $token;
    }

    /* ═══════════════════════════════════════════════════════════
       refreshAccessToken() — silently refreshes expired JWT
    ═══════════════════════════════════════════════════════════ */
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

    /* ═══════════════════════════════════════════════════════════
       proxyRequest() — auto-retry on 401 with refreshed token
    ═══════════════════════════════════════════════════════════ */
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

    /* ═══════════════════════════════════════════════════════════
       mpesa() — trigger M-Pesa STK Push
       Laravel:  POST /proxy/checkout/mpesa
       Django:   POST /api/ecommerce/checkout/mpesa/
       Returns:  { checkout_request_id, order_id, message }
    ═══════════════════════════════════════════════════════════ */
    public function mpesa(Request $request)
    {
        $validated = $request->validate([
            'mpesa_number'  => 'required|string',
            'name'          => 'nullable|string',
            'email'         => 'nullable|email',
            'phone'         => 'nullable|string',
            'address'       => 'nullable|string',
            'county'        => 'nullable|string',
            'town'          => 'nullable|string',
            'delivery_type' => 'nullable|string',
        ]);

        return $this->proxyRequest($request, function (string $token) use ($validated) {
            return Http::withToken($token)
                ->acceptJson()
                ->post("{$this->djangoBase}/api/ecommerce/checkout/mpesa/", [
                    'phone_number'  => $validated['mpesa_number'],
                    'delivery_type' => $validated['delivery_type'] ?? 'farm_delivery',
                    'address'       => $validated['address'] ?? '',
                    'county'        => $validated['county'] ?? '',
                    'town'          => $validated['town'] ?? '',
                ]);
        });
    }

    /* ═══════════════════════════════════════════════════════════
       paymentStatus() — poll for M-Pesa payment confirmation
       Laravel:  GET /proxy/checkout/status/{checkoutRequestId}
       Django:   GET /api/ecommerce/confirm-payment/
                     ?checkout_request_id={id}
       Django returns: { status: "Paid" | "Pending" | "Failed" }
    ═══════════════════════════════════════════════════════════ */
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

    /* ═══════════════════════════════════════════════════════════
       orders() — fetch all orders for the logged-in user
       Laravel:  GET /proxy/orders
       Django:   GET /api/ecommerce/orders/
       Returns:  [{ id, order_number, customer, branch,
                    status, total, created_at }]
    ═══════════════════════════════════════════════════════════ */
    public function orders(Request $request)
    {
        return $this->proxyRequest($request, function (string $token) {
            return Http::withToken($token)
                ->acceptJson()
                ->get("{$this->djangoBase}/api/ecommerce/orders/");
        });
    }

    /* ═══════════════════════════════════════════════════════════
       orderDetail() — fetch single order with its items
       Laravel:  GET /proxy/orders/{id}        ← numeric Django PK
       Django:   GET /api/ecommerce/orders/<id>/
       Returns:  { id, order_number, customer, branch, status,
                   total, created_at,
                   items: [{ product, quantity, unit_price, subtotal }] }
    ═══════════════════════════════════════════════════════════ */
    public function orderDetail(Request $request, string $id)
    {
        return $this->proxyRequest($request, function (string $token) use ($id) {
            return Http::withToken($token)
                ->acceptJson()
                ->get("{$this->djangoBase}/api/ecommerce/orders/{$id}/");
        });
    }
}