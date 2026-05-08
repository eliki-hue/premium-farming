@extends('layouts.app')

@section('title', ucfirst($slug) . ' Feeds | Premium Farming Feeds')

@section('content')

<div class="container mx-auto py-8">

    {{-- Page Title --}}
    <h1 class="text-3xl font-bold mb-8 capitalize">
        {{ str_replace('-', ' ', $slug) }} Feeds
    </h1>


    {{-- Products Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @forelse ($products as $product)

            <div class="border rounded shadow p-4 bg-white">

                {{-- Product Image --}}
                <img
                    src="{{ $product['image'] ?? 'https://via.placeholder.com/400x300?text=No+Image' }}"
                    alt="{{ $product['name'] }}"
                    class="w-full h-56 object-cover rounded"
                >

                {{-- Product Name --}}
                <h3 class="text-xl font-semibold mt-4">
                    {{ $product['name'] }}
                </h3>

                {{-- Description --}}
                <p class="text-gray-600 mt-2">
                    {{ $product['description'] ?? '' }}
                </p>

                {{-- Price --}}
                <p class="font-bold text-green-700 mt-3">
                    Ksh {{ number_format($product['unit_price'], 2) }}
                </p>

                {{-- View Product --}}
                <a
                    href="{{ isset($product['slug']) ? '/product/' . $product['slug'] : '#' }}"
                    class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                >
                    View Product
                </a>

            </div>

        @empty

            <div class="col-span-3 text-center py-16">

                <h2 class="text-2xl font-semibold text-gray-600">
                    No products found in this category
                </h2>

            </div>

        @endforelse

    </div>

</div>

@endsection