@php
    // Normalize Django API response (ARRAY or OBJECT)
    $id = $product['id'] ?? $product->id ?? null;
    $name = $product['name'] ?? $product->name ?? 'Product';
    $image = $product['image'] ?? $product->image ?? null;

    // Map API price
    $price = $product['unit_price'] ?? $product->unit_price ?? null;

    // Optional fields
    $sku = $product['sku'] ?? $product->sku ?? null;
@endphp

<div class="border p-4 rounded shadow flex flex-col h-full">
    {{-- IMAGE --}}
    <div class="mb-4 relative">
        <img
            src="{{ $image ?: 'https://via.placeholder.com/400x400?text=No+Image' }}"
            alt="{{ $name }}"
            class="w-full h-48 object-cover rounded"
        >

        @guest
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-center text-white rounded">
            <div>
                <i class="bi bi-lock text-2xl mb-2"></i>
                <p class="text-sm mb-2">Login required</p>
                <button
                    class="btn btn-light btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#signupModal">
                    Sign up to buy
                </button>
            </div>
        </div>
        @endguest
    </div>

    {{-- BODY --}}
    <h5 class="font-bold text-lg mb-1">{{ $name }}</h5>

    @if($sku)
        <small class="text-gray-500 mb-2 block">SKU: {{ $sku }}</small>
    @endif

    @if($price)
        <p class="text-green-600 font-bold text-xl mb-4">
            KSh {{ number_format((float) $price, 2) }}
        </p>
    @else
        <p class="text-gray-400 mb-4">Price on request</p>
    @endif

    {{-- ACTION --}}
    <div class="mt-auto">
        @auth
            <form method="POST" action="{{ route('cart.add') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $id }}">
                <input type="hidden" name="quantity" value="1">

                <button class="btn btn-success w-full flex items-center justify-center gap-2">
                    <i class="bi bi-cart-plus"></i> Add to Cart
                </button>
            </form>
        @else
            <button
                class="btn btn-outline-success w-full flex items-center justify-center gap-2"
                data-bs-toggle="modal"
                data-bs-target="#signupModal">
                <i class="bi bi-lock"></i> Sign in to buy
            </button>
        @endauth
    </div>
</div>
