@extends('layouts.shop')

@section('title', 'Shopping Cart | Premium Farming Feeds')

@section('content')

<div class="container py-5">
    <!-- Page Header -->
    <div class="mb-5">
        <h1 class="fw-bold mb-3" style="font-size: 2.5rem; color: var(--primary-dark);">
            <i class="bi bi-cart3 me-2"></i>
            Your Shopping Cart
        </h1>
        <p class="text-muted">Review your items and proceed to checkout</p>
    </div>

    @if(count($cart) > 0)
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 py-4">
                        <h5 class="mb-0 fw-bold">Cart Items ({{ count($cart) }})</h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach ($cart as $item)
                        <div class="cart-item p-4 border-bottom">
                            <div class="row align-items-center">
                                <!-- Product Image -->
                                <div class="col-md-2">
                                    <div class="cart-image-container">
                                        <img src="{{ asset($item['image']) }}" 
                                             alt="{{ $item['name'] }}"
                                             class="cart-product-image">
                                    </div>
                                </div>
                                
                                <!-- Product Details -->
                                <div class="col-md-4">
                                    <h6 class="fw-bold mb-1">{{ $item['name'] }}</h6>
                                    <p class="text-muted small mb-2">Premium Quality Feed</p>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-light text-dark me-2">
                                            <i class="bi bi-check-circle text-success me-1"></i>
                                            In Stock
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Price -->
                                <div class="col-md-2">
                                    <div class="cart-price">
                                        <span class="fw-bold" style="color: var(--primary-color);">
                                            Ksh {{ number_format($item['price']) }}
                                        </span>
                                        <small class="text-muted d-block">per bag</small>
                                    </div>
                                </div>
                                
                                <!-- Quantity -->
                                <div class="col-md-2">
                                    <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="quantity-form">
                                        @csrf
                                        <div class="input-group input-group-sm">
                                            <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity(this)">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="number" 
                                                   name="quantity"
                                                   value="{{ $item['quantity'] }}"
                                                   min="1" 
                                                   max="100"
                                                   class="form-control text-center quantity-input">
                                            <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity(this)">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                        <button type="submit" class="btn btn-link btn-sm text-primary mt-1">
                                            <small>Update</small>
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- Total & Remove -->
                                <div class="col-md-2 text-end">
                                    <div class="mb-2">
                                        <strong class="cart-item-total">
                                            Ksh {{ number_format($item['price'] * $item['quantity']) }}
                                        </strong>
                                    </div>
                                    <form action="{{ route('cart.remove', $item['id']) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-link text-danger p-0">
                                            <small><i class="bi bi-trash me-1"></i> Remove</small>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Continue Shopping -->
                <div class="mt-4">
                    <a href="{{ route('shop.products') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Continue Shopping
                    </a>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 100px;">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <!-- Subtotal -->
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>Ksh {{ number_format($subtotal ?? 0) }}</span>
                        </div>
                        
                        <!-- Delivery -->
                        <div class="d-flex justify-content-between mb-2">
                            <span>Delivery</span>
                            <span class="text-success">Free</span>
                        </div>
                        
                        <!-- Tax -->
                        <div class="d-flex justify-content-between mb-3">
                            <span>Tax</span>
                            <span>Included</span>
                        </div>
                        
                        <hr>
                        
                        <!-- Grand Total -->
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Grand Total</span>
                            <span class="fw-bold fs-5" style="color: var(--primary-color);">
                                Ksh {{ number_format($grandTotal) }}
                            </span>
                        </div>
                        
                        <!-- Checkout Button -->
                        <a href="{{ route('checkout') }}" class="btn btn-primary w-100 py-3 fw-bold">
                            <i class="bi bi-lock me-2"></i>
                            Proceed to Checkout
                        </a>
                        
                        <!-- Payment Methods -->
                        <div class="mt-4 text-center">
                            <p class="small text-muted mb-2">We accept:</p>
                            <div class="d-flex justify-content-center gap-3">
                                <span class="badge bg-light text-dark p-2">
                                    <i class="bi bi-phone me-1"></i> M-Pesa
                                </span>
                                <span class="badge bg-light text-dark p-2">
                                    <i class="bi bi-cash-coin me-1"></i> Cash
                                </span>
                                <span class="badge bg-light text-dark p-2">
                                    <i class="bi bi-bank me-1"></i> Bank
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="text-center py-5">
            <div class="empty-cart-icon mb-4">
                <i class="bi bi-cart-x" style="font-size: 4rem; color: #ccc;"></i>
            </div>
            <h4 class="fw-bold mb-3">Your cart is empty</h4>
            <p class="text-muted mb-4">Looks like you haven't added any products to your cart yet.</p>
            <a href="{{ route('shop.products') }}" class="btn btn-primary btn-lg px-5">
                <i class="bi bi-shop me-2"></i>
                Start Shopping
            </a>
        </div>
    @endif
</div>

<style>
    /* Cart Item Styles */
    .cart-item {
        transition: background-color 0.3s ease;
    }
    
    .cart-item:hover {
        background-color: rgba(42, 110, 63, 0.02);
    }
    
    .cart-image-container {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        overflow: hidden;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .cart-product-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 10px;
    }
    
    .quantity-input {
        max-width: 70px;
        border-color: #ddd;
    }
    
    .quantity-input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(42, 110, 63, 0.25);
    }
    
    .cart-item-total {
        font-size: 1.1rem;
        color: var(--primary-color);
    }
    
    /* Empty Cart */
    .empty-cart-icon {
        opacity: 0.5;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .cart-item {
            padding: 1rem !important;
        }
        
        .cart-image-container {
            width: 60px;
            height: 60px;
            margin-bottom: 1rem;
        }
    }
</style>

<script>
    function increaseQuantity(button) {
        const input = button.parentElement.querySelector('.quantity-input');
        input.value = parseInt(input.value) + 1;
    }
    
    function decreaseQuantity(button) {
        const input = button.parentElement.querySelector('.quantity-input');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
    
    // Auto-update quantity when changed
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            if (this.value < 1) this.value = 1;
            if (this.value > 100) this.value = 100;
        });
    });
</script>

@endsection