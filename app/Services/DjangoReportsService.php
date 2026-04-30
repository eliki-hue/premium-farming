<?php

namespace App\Services;

class DjangoReportsService extends DjangoBaseService
{
    public function all()
    {
        return $this->client()
            ->get($this->baseUrl . '/api/reports/')
            ->json();
    }

    public function branchSalesSummary()
    {
        return $this->client()
            ->get($this->baseUrl . '/api/reports/branch-sales-summary/')
            ->json();
    }

    public function companySummary()
    {
        return $this->client()
            ->get($this->baseUrl . '/api/reports/company-summary/')
            ->json();
    }

    public function topProducts()
    {
        return $this->client()
            ->get($this->baseUrl . '/api/reports/top-products/')
            ->json();
    }
}
