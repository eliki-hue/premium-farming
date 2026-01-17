@php
    // Normalize Django API response (ARRAY or OBJECT)
    $id = $product['id'] ?? $product->id ?? null;
    $name = $product['name'] ?? $product->name ?? 'Product';
    $image = $product['image'] ?? $product->image ?? null;

    // Map your API's unit_price to price
    $price = $product['unit_price'] ?? $product->unit_price ?? null;

    // Optional fields
    $sku = $product['sku'] ?? $product->sku ?? null;
@endphp

<div class="col-xl-3 col-lg-4 col-md-6">
    <div class="product-card h-100">

        <!-- IMAGE -->
        <div class="product-image-container">
            <img
                src="{{ $image ?: 'https://via.placeholder.com/400x400?text=No+Image' }}"
                alt="{{ $name }}"
                class="product-image-full"
            >

            @guest
            <div class="signup-overlay">
                <div class="overlay-content">
                    <i class="bi bi-lock"></i>
                    <h6>Login required</h6>
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

        <!-- BODY -->
        <div class="card-body p-4 d-flex flex-column">
            <h5 class="fw-bold mb-1">{{ $name }}</h5>

            @if($sku)
                <small class="text-muted mb-2">SKU: {{ $sku }}</small>
            @endif

            @if($price)
                <p class="text-success fw-bold fs-5 mb-3">
                    KSh {{ number_format((float) $price, 2) }}
                </p>
            @else
                <p class="text-muted mb-3">Price on request</p>
            @endif

            <!-- ACTION -->
            <div class="mt-auto">
                @auth
                    <form method="POST" action="{{ route('cart.add') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $id }}">
                        <input type="hidden" name="quantity" value="1">

                        <button class="btn btn-success w-100">
                            <i class="bi bi-cart-plus me-2"></i>Add to Cart
                        </button>
                    </form>
                @else
                    <button
                        class="btn btn-outline-success w-100"
                        data-bs-toggle="modal"
                        data-bs-target="#signupModal">
                        <i class="bi bi-lock me-2"></i>Sign in to buy
                    </button>
                @endauth
            </div>
        </div>
    </div>
</div>