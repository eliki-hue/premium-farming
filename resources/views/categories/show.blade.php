@extends('layouts.app')

@section('title', ucfirst($slug) . ' Feeds | Premium Farming Feeds')

@section('content')

<section class="products-section py-5" id="products">

    <div class="container">

        {{-- Category Title --}}
        <div class="text-center mb-5">

            <h2 class="section-title capitalize">
                {{ str_replace('-', ' ', $slug) }} Feeds
            </h2>

            <p class="section-subtitle">
                Premium quality feeds for your farming needs
            </p>

        </div>

        @if(!empty($products) && count($products) > 0)

            <div class="row g-4">

                @foreach($products as $product)

                    <div class="col-md-3 col-sm-6">

                        <div class="product-card">

                            <div class="product-image-wrapper">

                                <div class="product-badge">
                                    New
                                </div>

                                <img
                                    src="{{ $product['image'] ?? $product['image_url'] ?? asset('images/no-image.png') }}"
                                    alt="{{ $product['name'] ?? 'Product' }}"
                                    class="product-image"
                                    loading="lazy"
                                >

                                <div class="product-overlay">

                                    <a
                                        href="/products/{{ $product['slug'] ?? $product['id'] }}"
                                        class="quick-view-btn text-decoration-none"
                                    >
                                        <i class="bi bi-eye"></i>
                                        View Product
                                    </a>

                                </div>

                            </div>

                            <div class="product-content">

                                <h3 class="product-title">
                                    {{ $product['name'] ?? 'Unknown Product' }}
                                </h3>

                                <div class="product-price">

                                    <span class="currency">
                                        KES
                                    </span>

                                    <span class="amount">
                                        {{ number_format($product['unit_price'] ?? 0, 2) }}
                                    </span>

                                </div>

                                <div class="product-actions">

                                    <button
                                        class="btn-add-to-cart"
                                        data-product-id="{{ $product['id'] }}"
                                        data-product-name="{{ $product['name'] }}"
                                        onclick="addItem(event, {{ $product['id'] }}, 1)"
                                    >

                                        <i class="bi bi-cart-plus"></i>

                                        <span>
                                            Add to Cart
                                        </span>

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

            {{-- View Cart --}}
            <div class="text-center mt-5">

                <a
                    href="{{ route('cart.view') }}"
                    class="btn-view-cart"
                >

                    <i class="bi bi-cart3 me-2"></i>

                    View Cart

                    <i class="bi bi-arrow-right ms-2"></i>

                </a>

            </div>

        @else

            <div class="empty-state">

                <div class="empty-state-icon">
                    <i class="bi bi-box-seam"></i>
                </div>

                <h4>
                    No products available
                </h4>

                <p>
                    Please check back later or contact us for assistance.
                </p>

            </div>

        @endif

    </div>

</section>

@endsection