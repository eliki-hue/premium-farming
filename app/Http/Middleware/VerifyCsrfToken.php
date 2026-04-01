<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{       

    protected $except = [
        'api/ecommerce/*',
        'api/ecommerce/csrf-token',
        'api/orders/*',
        // 'api/ecommerce/place-order',
        'proxy/*',
        'proxy/order/place',
        'proxy/cart',
        'api/*',
        'api/ecommerce/*',
        'guest/*',
        'checkout/*',
        'whatsapp/*'     // if you use this route
    ];
}