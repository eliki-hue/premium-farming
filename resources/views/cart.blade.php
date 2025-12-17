@extends('layouts.app')

@section('title', 'Shopping Cart - Premium Farming Feeds')

@push('styles')
<style>
    .cart-section {
        padding: 4rem 0;
        background-color: var(--light-bg);
        min-height: calc(100vh - 80px);
    }

    .cart-header {
        margin-bottom: 3rem;
    }

    .cart-header h1 {
        font-size: 3rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .cart-header p {
        color: var(--text-muted);
        font-size: 1.1rem;
    }

    .cart-container {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 2rem;
        align-items: start;
    }

    .cart-items {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .cart-item {
        display: grid;
        grid-template-columns: 120px 1fr auto;
        gap: 1.5rem;
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        align-items: center;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .item-image {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        overflow: hidden;
        background-color: #f5f5f5;
    }

    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-details {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .item-category {
        color: var(--text-muted);
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .item-name {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
    }

    .item-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary-green);
    }

    .item-unit {
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .item-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 1rem;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background-color: var(--light-bg);
        border-radius: 8px;
        padding: 0.3rem;
    }

    .quantity-btn {
        width: 35px;
        height: 35px;
        border: none;
        background-color: white;
        color: var(--primary-green);
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .quantity-btn:hover {
        background-color: var(--primary-green);
        color: white;
    }

    .quantity-input {
        width: 50px;
        text-align: center;
        border: none;
        background: transparent;
        font-weight: 600;
        font-size: 1rem;
    }

    .remove-btn {
        background: none;
        border: none;
        color: #ef4444;
        cursor: pointer;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .remove-btn:hover {
        color: #dc2626;
    }

    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-cart i {
        font-size: 5rem;
        color: var(--text-muted);
        margin-bottom: 1.5rem;
    }

    .empty-cart h2 {
        font-size: 2rem;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .empty-cart p {
        color: var(--text-muted);
        margin-bottom: 2rem;
        font-size: 1.1rem;
    }

    .btn-shop {
        background-color: var(--primary-green);
        color: white;
        padding: 1rem 2.5rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-shop:hover {
        background-color: var(--primary-green-dark);
        transform: translateY(-2px);
        color: white;
    }

    .cart-summary {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        position: sticky;
        top: 100px;
    }

    .summary-header {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.8rem 0;
        color: var(--text-dark);
    }

    .summary-row.total {
        border-top: 2px solid #e5e7eb;
        margin-top: 1rem;
        padding-top: 1.5rem;
        font-size: 1.3rem;
        font-weight: 700;
    }

    .summary-row.total .amount {
        color: var(--primary-green);
        font-size: 1.8rem;
    }

    .discount-code {
        margin: 1.5rem 0;
    }

    .discount-input {
        display: flex;
        gap: 0.5rem;
    }

    .discount-input input {
        flex: 1;
        padding: 0.8rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
    }

    .discount-input input:focus {
        outline: none;
        border-color: var(--primary-green);
    }

    .discount-input button {
        padding: 0.8rem 1.5rem;
        background-color: var(--accent-orange);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .discount-input button:hover {
        background-color: var(--accent-orange-dark);
    }

    .btn-checkout {
        width: 100%;
        padding: 1.2rem;
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        margin-top: 1.5rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(45, 95, 78, 0.3);
    }

    .security-badges {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
    }

    .security-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    .security-badge i {
        color: var(--primary-green);
    }

    @media (max-width: 992px) {
        .cart-container {
            grid-template-columns: 1fr;
        }

        .cart-summary {
            position: static;
        }
    }

    @media (max-width: 576px) {
        .cart-header h1 {
            font-size: 2rem;
        }

        .cart-item {
            grid-template-columns: 80px 1fr;
            gap: 1rem;
        }

        .item-image {
            width: 80px;
            height: 80px;
        }

        .item-actions {
            grid-column: 1 / -1;
            flex-direction: row;
            justify-content: space-between;
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<section class="cart-section">
    <div class="container">
        <div class="cart-header">
            <h1>Shopping Cart</h1>
            <p>Review your items and proceed to checkout</p>
        </div>

        @php
            // Sample cart data - Replace with actual cart data from session/database
            $cartItems = [
                [
                    'id' => 1,
                    'name' => 'Kienyeji Premium Mash',
                    'category' => 'POULTRY',
                    'price' => 3200,
                    'quantity' => 2,
                    'unit' => 'per 70kg bag',
                    'image' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=400',
                ],
                [
                    'id' => 2,
                    'name' => 'Sow & Weaner Premium',
                    'category' => 'PIGS',
                    'price' => 3800,
                    'quantity' => 1,
                    'unit' => 'per 70kg bag',
                    'image' => 'https://images.unsplash.com/photo-1516467508483-a7212febe31a?q=80&w=400',
                ],
                [
                    'id' => 3,
                    'name' => 'Dairy Meal Concentrate',
                    'category' => 'CATTLE',
                    'price' => 3600,
                    'quantity' => 3,
                    'unit' => 'per 70kg bag',
                    'image' => 'https://images.unsplash.com/photo-1560493676-04071c5f467b?q=80&w=400',
                ],
            ];

            $subtotal = array_sum(array_map(function($item) {
                return $item['price'] * $item['quantity'];
            }, $cartItems));

            $delivery = 500;
            $discount = 0;
            $total = $subtotal + $delivery - $discount;
        @endphp

        @if(count($cartItems) > 0)
        <div class="cart-container">
            <!-- Cart Items -->
            <div class="cart-items">
                @foreach($cartItems as $item)
                <div class="cart-item" data-item-id="{{ $item['id'] }}">
                    <div class="item-image">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                    </div>

                    <div class="item-details">
                        <div class="item-category">{{ $item['category'] }}</div>
                        <h3 class="item-name">{{ $item['name'] }}</h3>
                        <div>
                            <span class="item-price">KES {{ number_format($item['price']) }}</span>
                            <span class="item-unit">{{ $item['unit'] }}</span>
                        </div>
                    </div>

                    <div class="item-actions">
                        <div class="quantity-control">
                            <button class="quantity-btn" onclick="updateQuantity({{ $item['id'] }}, -1)">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input type="text" class="quantity-input" value="{{ $item['quantity'] }}" readonly>
                            <button class="quantity-btn" onclick="updateQuantity({{ $item['id'] }}, 1)">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                        <button class="remove-btn" onclick="removeItem({{ $item['id'] }})">
                            <i class="bi bi-trash"></i>
                            Remove
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Cart Summary -->
            <div class="cart-summary">
                <h2 class="summary-header">Order Summary</h2>

                <div class="summary-row">
                    <span>Subtotal ({{ count($cartItems) }} items)</span>
                    <span class="amount">KES {{ number_format($subtotal) }}</span>
                </div>

                <div class="summary-row">
                    <span>Delivery Fee</span>
                    <span class="amount">KES {{ number_format($delivery) }}</span>
                </div>

                @if($discount > 0)
                <div class="summary-row" style="color: #10b981;">
                    <span>Discount</span>
                    <span class="amount">-KES {{ number_format($discount) }}</span>
                </div>
                @endif

                <div class="discount-code">
                    <label style="font-size: 0.9rem; color: var(--text-muted); display: block; margin-bottom: 0.5rem;">
                        Have a discount code?
                    </label>
                    <div class="discount-input">
                        <input type="text" placeholder="Enter code" id="discountCode">
                        <button onclick="applyDiscount()">Apply</button>
                    </div>
                </div>

                <div class="summary-row total">
                    <span>Total</span>
                    <span class="amount">KES {{ number_format($total) }}</span>
                </div>

                <button class="btn-checkout" onclick="proceedToCheckout()">
                    <i class="bi bi-lock-fill"></i>
                    Proceed to Checkout
                </button>

                <div class="security-badges">
                    <div class="security-badge">
                        <i class="bi bi-shield-check"></i>
                        <span>Secure Payment</span>
                    </div>
                    <div class="security-badge">
                        <i class="bi bi-truck"></i>
                        <span>Fast Delivery</span>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Empty Cart -->
        <div class="cart-items">
            <div class="empty-cart">
                <i class="bi bi-cart-x"></i>
                <h2>Your Cart is Empty</h2>
                <p>Start adding quality livestock feeds to your cart</p>
                <a href="{{ url('/products') }}" class="btn-shop">
                    <i class="bi bi-arrow-left"></i>
                    Continue Shopping
                </a>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Load cart from localStorage
    function loadCart() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        if (cart.length === 0) {
            // Show empty cart
            document.querySelector('.cart-items').innerHTML = `
                <div class="empty-cart">
                    <i class="bi bi-cart-x"></i>
                    <h2>Your Cart is Empty</h2>
                    <p>Start adding quality livestock feeds to your cart</p>
                    <a href="{{ url('/products') }}" class="btn-shop">
                        <i class="bi bi-arrow-left"></i>
                        Continue Shopping
                    </a>
                </div>
            `;
            document.querySelector('.cart-summary')?.remove();
            return;
        }

        // Calculate totals
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const delivery = 500;
        const total = subtotal + delivery;

        // Render cart items
        const cartItemsHTML = cart.map((item, index) => `
            <div class="cart-item" data-index="${index}">
                <div class="item-image">
                    <img src="${item.image}" alt="${item.name}">
                </div>

                <div class="item-details">
                    <div class="item-category">${item.category}</div>
                    <h3 class="item-name">${item.name}</h3>
                    <div>
                        <span class="item-price">KES ${item.price.toLocaleString()}</span>
                        <span class="item-unit">${item.unit}</span>
                    </div>
                </div>

                <div class="item-actions">
                    <div class="quantity-control">
                        <button class="quantity-btn" onclick="updateCartQuantity(${index}, -1)">
                            <i class="bi bi-dash"></i>
                        </button>
                        <input type="text" class="quantity-input" value="${item.quantity}" readonly>
                        <button class="quantity-btn" onclick="updateCartQuantity(${index}, 1)">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                    <button class="remove-btn" onclick="removeFromCart(${index})">
                        <i class="bi bi-trash"></i>
                        Remove
                    </button>
                </div>
            </div>
        `).join('');

        document.querySelector('.cart-items').innerHTML = cartItemsHTML;

        // Update summary
        document.querySelector('.summary-row .amount').textContent = `KES ${subtotal.toLocaleString()}`;
        document.querySelectorAll('.summary-row')[1].querySelector('.amount').textContent = `KES ${delivery.toLocaleString()}`;
        document.querySelector('.summary-row.total .amount').textContent = `KES ${total.toLocaleString()}`;
        document.querySelector('.products-count strong').textContent = cart.length;
    }

    function updateCartQuantity(index, change) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        if (cart[index]) {
            cart[index].quantity += change;
            
            if (cart[index].quantity < 1) {
                if (confirm('Remove this item from cart?')) {
                    cart.splice(index, 1);
                } else {
                    cart[index].quantity = 1;
                }
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }
    }

    function removeFromCart(index) {
        if (confirm('Are you sure you want to remove this item?')) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }
    }

    function applyDiscount() {
        const discountCode = document.getElementById('discountCode').value.trim();
        
        if (!discountCode) {
            alert('Please enter a discount code');
            return;
        }

        // Example discount codes (you can expand this)
        const validCodes = {
            'SAVE10': 10,
            'WELCOME': 15,
            'BULK20': 20
        };

        if (validCodes[discountCode.toUpperCase()]) {
            const discount = validCodes[discountCode.toUpperCase()];
            alert(`Discount code applied! You saved ${discount}%`);
            // Apply discount logic here
        } else {
            alert('Invalid discount code');
        }
    }

    function proceedToCheckout() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        if (cart.length === 0) {
            alert('Your cart is empty!');
            return;
        }

        // Redirect to checkout page
        window.location.href = '{{ url("/checkout") }}';
    }

    // Load cart on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadCart();
    });
</script>
@endpush