@extends('layouts.app')

@section('title', 'Our Products | Premium Farming Feeds')

@section('content')

<!-- ================= HERO SECTION ================= -->
<section class="hero-section-products">
    <video autoplay muted loop playsinline class="hero-video">
        <source src="{{ asset('videos/kkk.mp4') }}" type="video/mp4">
    </video>

    <div class="hero-overlay">
        <div class="container">
            <div class="row align-items-center min-vh-50">
                <div class="col-lg-12 text-center">
                    <h1 class="hero-title mb-3">Premium Farming Products</h1>
                    <p class="hero-subtitle mb-4">
                        Quality feeds for all your livestock needs
                    </p>
                    <a href="#products" class="btn btn-success btn-lg px-4">
                        <i class="bi bi-arrow-down me-2"></i> Browse Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= PRODUCTS ================= -->
<div class="container my-5" id="products">
    <h2 class="mb-4 text-center section-title">Our Products</h2>

    @if($products->isNotEmpty())
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm product-card">

                        <!-- Image -->
                        <div class="card-img-top-container">
                            <img
                                class="card-img-top"
                                src="{{ $product['image'] ?? asset('images/no-image.png') }}"
                                alt="{{ $product['name'] }}">
                        </div>

                        <!-- Body -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="fw-bold">{{ $product['name'] }}</h5>

                            <p class="price-tag text-success fw-bold">
                                KES {{ number_format($product['unit_price'], 2) }}
                            </p>

                            @if(!empty($product['sku']))
                                <small class="text-muted mb-2">SKU: {{ $product['sku'] }}</small>
                            @endif

                            <div class="mt-auto">
                                @auth
                                    <button
                                        class="btn btn-success w-100 add-to-cart"
                                        data-id="{{ $product['id'] }}">
                                        <i class="bi bi-cart-plus me-2"></i>
                                        Add to Cart
                                    </button>
                                @else
                                    <button
                                        class="btn btn-outline-success w-100"
                                        data-bs-toggle="modal"
                                        data-bs-target="#signupModal">
                                        <i class="bi bi-cart-plus me-2"></i>
                                        Add to Cart
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-box-seam display-1 text-muted mb-3"></i>
            <h4 class="text-muted">No products available</h4>
        </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.add-to-cart').forEach(button => {

        button.addEventListener('click', async () => {
            button.disabled = true;
            button.innerHTML = 'Adding…';

            try {
                const response = await fetch("{{ route('cart.add') }}", {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: button.dataset.id,
                        quantity: 1
                    })
                });

                if (!response.ok) throw new Error();

                button.innerHTML = '✔ Added';
            } catch (e) {
                button.disabled = false;
                button.innerHTML = 'Add to Cart';
                alert('Add to cart failed');
            }
        });

    });
});
</script>
@endpush


<!-- ================= STYLES ================= -->
<style>
.hero-section-products {
    position: relative;
    min-height: 60vh;
    margin-top: 76px;
    overflow: hidden;
    color: #fff;
}

.hero-video {
    position: absolute;
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(0.45);
}

.hero-overlay {
    position: relative;
    z-index: 2;
    padding: 90px 0;
}

.hero-title {
    font-size: 2.8rem;
    font-weight: 800;
}

.hero-subtitle {
    font-size: 1.2rem;
}

.product-card {
    border-radius: 15px;
    transition: 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
}

.card-img-top-container {
    height: 200px;
    overflow: hidden;
}

.card-img-top {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.price-tag {
    font-size: 1.2rem;
}

.section-title {
    font-weight: 700;
    color: #2a6e3f;
}

.btn-success {
    background: linear-gradient(135deg, #2a6e3f, #3a8e5c);
    border: none;
}
</style>
