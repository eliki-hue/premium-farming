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