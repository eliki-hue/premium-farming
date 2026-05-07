<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class CategoryComposer
{
    public function compose(View $view)
    {
        try {

            $apiUrl = config('services.django_api.url');

            $response = Http::timeout(10)
                ->get($apiUrl . '/categories/');

            $categories = [];

            if ($response->successful()) {
                $categories = $response->json();
            }

            $view->with('globalCategories', $categories);

        } catch (\Exception $e) {

            $view->with('globalCategories', []);

        }
    }
}