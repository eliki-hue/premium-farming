<?php

namespace App\Services;

class DjangoPublicService extends DjangoBaseService
{
    public function categories()
    {
        return $this->client()
            ->get($this->baseUrl . '/api/public/categories/')
            ->json();
    }

    public function products()
    {
        return $this->client()
            ->get($this->baseUrl . '/api/public/products/')
            ->json();
    }

    public function productDetail($slug)
    {
        return $this->client()
            ->get($this->baseUrl . "/api/public/products/{$slug}/")
            ->json();
    }
}
