<?php

namespace App\Services;

class DjangoInventoryService extends DjangoBaseService
{
    public function branches()
    {
        return $this->client()
            ->get($this->baseUrl . '/api/branches/')
            ->json();
    }

    public function branchInventory($branchId)
    {
        return $this->client()
            ->get($this->baseUrl . "/api/inventory/{$branchId}/")
            ->json();
    }

    public function inventory()
    {
        return $this->client()
            ->get($this->baseUrl . '/api/inventory/')
            ->json();
    }

    public function purchases()
    {
        return $this->client()
            ->get($this->baseUrl . '/api/purchases/')
            ->json();
    }

    public function sales()
    {
        return $this->client()
            ->get($this->baseUrl . '/api/sales/')
            ->json();
    }
}
