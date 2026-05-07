<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CategoryComposer
{
    public function compose(View $view): void
{
    $apiUrl = rtrim(
        config('services.django_api.url'),
        '/'
    );

    $response = Http::get($apiUrl . '/categories/');

    dd(
        $apiUrl,
        $response->status(),
        $response->json()
    );
}
}