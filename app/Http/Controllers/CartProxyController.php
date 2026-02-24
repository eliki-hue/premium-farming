<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class CartProxyController extends Controller
{
    protected string $djangoBase;

    public function __construct()
    {
        $this->djangoBase = config('services.django_api.url');
    }

    protected function getJwt(Request $request): string
    {
        $token = $request->session()->get('django_token');
        if (!$token) abort(401, 'Unauthorized');
        return $token;
    }

    protected function djangoHeaders(Request $request): array
    {
        return [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getJwt($request),
        ];
    }

    public function load(Request $request): JsonResponse
    {
        $response = Http::withHeaders($this->djangoHeaders($request))
            ->get("{$this->djangoBase}/api/ecommerce/cart/");

        return response()->json($response->json(), $response->status());
    }

    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product' => 'required|integer',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $response = Http::withHeaders($this->djangoHeaders($request))
            ->post("{$this->djangoBase}/api/ecommerce/cart/items/", $validated);

        return response()->json($response->json(), $response->status());
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product' => 'required|integer',
            'quantity' => 'required|integer|min:0',
        ]);

        // Forward as PATCH to Django
        $response = Http::withHeaders($this->djangoHeaders($request))
            ->patch("{$this->djangoBase}/api/ecommerce/cart/items/update/", $validated);

        return response()->json($response->json(), $response->status());
    }

    public function remove(Request $request): JsonResponse
    {
        $request->validate([
            'product' => 'required|integer',
        ]);

        $response = Http::delete(config('services.django_api.url') . '/api/ecommerce/cart/items/remove/', [
            'product' => $request->product,
        ]);

        return response()->json($response->json(), $response->status());
    }
}
