<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DjangoBaseService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.django_api.url'), '/');
    }

    protected function client()
    {
        return Http::withOptions([
            'verify' => false, // ngrok https
            'cookies' => true,
            'timeout' => 15,
        ]);
    }
}
