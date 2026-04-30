<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProxyController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = env('DJANGO_API_URL');
    }

    public function login(Request $request)
    {
        $res = Http::post($this->api.'/api/auth/customer/login/', $request->all());

        return response($res->body(), $res->status());
    }

    public function signup(Request $request)
    {
        $res = Http::post($this->api.'/api/auth/customer/signup/', $request->all());

        return response($res->body(), $res->status());
    }

    public function cart(Request $request)
    {
        $res = Http::get($this->api.'/api/cart/');

        return response($res->body(), $res->status());
    }

    public function updateCart(Request $request)
    {
        $res = Http::patch($this->api.'/api/cart/update/', [
            'product' => $request->product,
            'quantity' => $request->quantity,
        ]);

        return response($res->body(), $res->status());
    }
}