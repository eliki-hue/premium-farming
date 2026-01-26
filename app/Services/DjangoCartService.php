<?php

namespace App\Services;

class DjangoCartService extends DjangoBaseService
{
    public function cart()
    {
        return $this->client()
            ->get($this->baseUrl . '/api/ecommerce/cart/')
            ->json();
    }

    public function add($productId, $qty)
    {
        return $this->client()
            ->post($this->baseUrl . '/api/ecommerce/cart/items/', [
                'product' => $productId,
                'quantity' => $qty,
            ])
            ->json();
    }

    public function update($itemId, $qty)
    {
        return $this->client()
            ->patch($this->baseUrl . "/api/ecommerce/cart/items/{$itemId}/", [
                'quantity' => $qty,
            ])
            ->json();
    }

    public function remove($itemId)
    {
        return $this->client()
            ->delete($this->baseUrl . "/api/ecommerce/cart/items/{$itemId}/")
            ->json();
    }
}
