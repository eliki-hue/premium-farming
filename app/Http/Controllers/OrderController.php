<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected string $djangoBase;

    public function __construct()
    {
        // Reads DJANGO_API_URL from .env via config/services.php
        $this->djangoBase = rtrim(config('services.django_api.url'), '/');
    }

    /**
     * GET CSRF TOKEN FROM DJANGO
     * Laravel route: GET /ecommerce/csrf-token/
     * Proxies to:    GET {DJANGO_API_URL}/api/ecommerce/csrf-token/
     *
     * Also extracts and stores Django's csrftoken + sessionid cookies
     * into the Laravel session so they can be forwarded on place-order.
     */
    public function getCsrfToken()
    {
        try {
            $response = Http::withHeaders([
                'ngrok-skip-browser-warning' => '1',
            ])->withOptions([
                'verify' => false,
            ])->get($this->djangoBase . '/api/ecommerce/csrf-token/');

            if (!$response->successful()) {
                Log::error('[OrderController] CSRF fetch failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return response()->json(['error' => 'Failed to fetch CSRF token'], 500);
            }

            // ✅ Parse and store Django cookies in Laravel session
            // Django needs both the X-CSRFToken header AND the csrftoken cookie
            // to match on any POST — so we save the cookie here for later use.
            $setCookie = $response->header('Set-Cookie');
            if ($setCookie) {
                preg_match('/csrftoken=([^;]+)/', $setCookie, $csrfMatches);
                if (!empty($csrfMatches[1])) {
                    Session::put('django_csrftoken_cookie', $csrfMatches[1]);
                    Log::info('[OrderController] Stored django_csrftoken_cookie');
                }

                preg_match('/sessionid=([^;]+)/', $setCookie, $sessionMatches);
                if (!empty($sessionMatches[1])) {
                    Session::put('django_sessionid_cookie', $sessionMatches[1]);
                    Log::info('[OrderController] Stored django_sessionid_cookie');
                }
            }

            return response()->json($response->json());

        } catch (\Exception $e) {
            Log::error('[OrderController] getCsrfToken exception: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * CREATE ORDER — proxy to Django
     * Laravel route: POST /api/ecommerce/place-order
     * Proxies to:    POST {DJANGO_API_URL}/api/ecommerce/place-order/
     *
     * Forwards:
     *  - X-CSRFToken header  (the token value from getDjangoCsrf())
     *  - Cookie header       (csrftoken + sessionid saved during getCsrfToken())
     *  - Authorization       (JWT bearer token if user is logged in)
     */
    public function createOrder(Request $request)
    {
        try {
            $data = $request->validate([
                'cart_id'       => 'required|string',
                'customer_name' => 'required|string',
                'phone_number'  => 'required|string',
                'django_csrf'   => 'required|string',
            ]);

            // Pull out django_csrf — it's routing metadata, not order data
            $djangoCsrf = $data['django_csrf'];
            unset($data['django_csrf']);

            // ✅ Rebuild Django cookie string from Laravel session
            $cookieParts = [];

            $csrftokenCookie = Session::get('django_csrftoken_cookie');
            if ($csrftokenCookie) {
                $cookieParts[] = "csrftoken={$csrftokenCookie}";
            }

            $sessionidCookie = Session::get('django_sessionid_cookie');
            if ($sessionidCookie) {
                $cookieParts[] = "sessionid={$sessionidCookie}";
            }

            // Build headers
            $headers = [
                'Content-Type'               => 'application/json',
                'X-CSRFToken'                => $djangoCsrf,
                'ngrok-skip-browser-warning' => '1',
            ];

            if (!empty($cookieParts)) {
                $headers['Cookie'] = implode('; ', $cookieParts);
            }

            // Forward JWT if customer is authenticated via Django session
            $jwtToken = Session::get('django_token');
            if ($jwtToken) {
                $headers['Authorization'] = "Bearer {$jwtToken}";
            }

            $response = Http::withHeaders($headers)
                ->withOptions(['verify' => false])
                ->post($this->djangoBase . '/api/ecommerce/place-order/', $data);


            Log::info('[OrderController] place-order response', [
                'url'     => $this->djangoBase . '/api/ecommerce/place-order/',
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return response()->json($response->json(), $response->status());

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            Log::error('[OrderController] createOrder exception: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * SHOW ORDER CONFIRMATION PAGE
     * Laravel route: GET /order/confirmation/{orderId}
     */
    public function showConfirmation(Request $request, string $orderId)
    {
        return view('checkout.confirmation', ['orderId' => $orderId]);
    }
}