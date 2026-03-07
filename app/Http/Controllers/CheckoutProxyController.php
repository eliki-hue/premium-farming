<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutProxyController extends Controller
{
    protected string $djangoBase;

    public function __construct()
    {
        $this->djangoBase = config('services.django_api.url');
    }

    protected function getJwt(Request $request): string
    {
        $token = $request->session()->get('django_token');
        if (!$token) {
            abort(401, 'Not authenticated with Django');
        }
        return $token;
    }

  public function mpesa(Request $request)
{
    $validated = $request->validate([
        'mpesa_number' => 'required|string',
    ]);

    $response = Http::withToken($this->getJwt($request))
        ->acceptJson()
        ->post($this->djangoBase . '/api/ecommerce/checkout/mpesa/', [
            'phone_number' => $validated['mpesa_number'],
        ]);

    return response()->json(
        $response->json(),
        $response->status()
    );
}
}