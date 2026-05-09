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

        @if(!empty($products) && count($products) > 0)
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-md-3 col-sm-6">
                        <div class="product-card">
                            <div class="product-image-wrapper">
                                <div class="product-badge">New</div>
                                <img
                                    src="{{ $product['image'] ?? $product['image_url'] ?? asset('images/no-image.png') }}"
                                    alt="{{ $product['name'] ?? $product['product_name'] ?? 'Product' }}"
                                    class="product-image"
                                    loading="lazy">
                                
                            </div>
                            
                            <div class="product-content">
                                <h3 class="product-title">
                                    {{ $product['name'] ?? $product['product_name'] ?? 'Unknown Product' }}
                                </h3>
                                
                                <!-- <div class="product-meta">
                                    @if(!empty($product['sku'] ?? $product['sku_code'] ?? null))
                                        <span class="product-sku">
                                            <i class="bi bi-upc-scan"></i> SKU: {{ $product['sku'] ?? $product['sku_code'] }}
                                        </span>
                                    @endif
                                </div> -->
                                
                                <div class="product-price">
                                    <span class="currency">KES</span>
                                    <span class="amount">{{ number_format($product['unit_price'] ?? $product['price'] ?? $product['selling_price'] ?? 0, 2) }}</span>
                                </div>
                                
                                {{-- ── Add to Cart: available to ALL users (guests + logged-in) ── --}}
                                <div class="product-actions">
                                    <button
                                        class="btn-add-to-cart"
                                        data-product-id="{{ $product['id'] }}"
                                        data-product-name="{{ $product['name'] ?? $product['product_name'] }}"
                                        onclick="addItem(event, {{ $product['id'] }}, 1)">
                                        <i class="bi bi-cart-plus"></i>
                                        <span>Add to Cart</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- View Cart button — visible to all users --}}
            <div class="text-center mt-5">
                <a href="{{ route('cart.view') }}" class="btn-view-cart">
                    <i class="bi bi-cart3 me-2"></i> View Cart
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
                <h4>No products available</h4>
                <p>Please check back later or contact us for assistance.</p>
            </div>
        @endif
    

    </div>

</div>

@endsection