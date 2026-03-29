{{-- resources/views/shop/cart.blade.php --}}
@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<div class="container my-5">

    {{-- ─── Page Header ─── --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <h3 class="mb-0 fw-bold" style="color:#2a6e3f;">
            <i class="bi bi-cart3 me-2"></i>Your Cart
        </h3>
        <a href="{{ route('products') }}" class="btn btn-outline-success">
            <i class="bi bi-arrow-left me-2"></i>Continue Shopping
        </a>
    </div>

    {{-- ─── Notification Alert ─── --}}
    <div id="notificationAlert" class="alert d-none"></div>

    {{-- ─── Cart Contents ─── --}}
    <div id="cart" class="mt-3">
        <div class="text-center py-5">
            <div class="spinner-border text-success" role="status">
                <span class="visually-hidden">Loading…</span>
            </div>
            <p class="text-muted mt-2">Loading your cart…</p>
        </div>
    </div>

    {{-- ─── Action Buttons (hidden until cart has items) ─── --}}
    <div id="cartActions" class="mt-4 text-center d-none">
        <button type="button" id="confirmOrderBtn" class="btn btn-success btn-lg px-5" 
                onclick="window.location.href='/checkout/details'">
            <i class="bi bi-whatsapp me-2"></i>Proceed to Checkout
        </button>
    </div>
</div>

<style>
    .table th { background-color: #f8fdf9; color: #2a6e3f; font-weight: 600; }
    .table td { vertical-align: middle; }

    .btn-success {
        background: linear-gradient(135deg, #2a6e3f, #3a8e5c);
        border: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-success:hover:not(:disabled) {
        background: linear-gradient(135deg, #1e5a2f, #2a6e3f);
        transform: translateY(-1px);
    }
    .btn-success:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    .btn-outline-success {
        border-color: #2a6e3f;
        color: #2a6e3f;
        font-weight: 600;
    }
    .btn-outline-success:hover {
        background: #2a6e3f;
        color: white;
    }

    .empty-cart-icon {
        font-size: 4rem;
        color: #c8e6c9;
    }

    .cart-toast {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: white;
        border-left: 5px solid #25D366;
        border-radius: 10px;
        padding: 15px 25px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: slideInRight 0.3s ease;
        max-width: 400px;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        backdrop-filter: blur(3px);
    }
    
    .loading-spinner {
        background: white;
        padding: 30px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }
    
    .loading-spinner .spinner-border {
        width: 3rem;
        height: 3rem;
    }
</style>

<script>
(function () {
    'use strict';

    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    const API = {
        load:   '/proxy/cart',
        update: '/proxy/cart/update',
        remove: '/proxy/cart/remove',
    };

    let cart = { id: null, items: [], subtotal: 0, total_items: 0 };

    function showToast(message, type = 'success', duration = 4000) {
        const existingToast = document.querySelector('.cart-toast');
        if (existingToast) existingToast.remove();

        const toast = document.createElement('div');
        toast.className = 'cart-toast';
        
        const icon = document.createElement('i');
        icon.className = type === 'success' ? 'bi bi-check-circle-fill text-success' : 
                        type === 'error' ? 'bi bi-exclamation-circle-fill text-danger' : 
                        'bi bi-info-circle-fill text-info';
        
        const text = document.createElement('span');
        text.textContent = message;
        
        toast.appendChild(icon);
        toast.appendChild(text);
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideInRight 0.3s reverse';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }

    async function loadCart() {
        try {
            const res = await fetch(API.load, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                },
                credentials: 'same-origin',
            });

            if (res.status === 401 || !res.ok) {
                renderEmpty();
                return;
            }

            cart = await res.json();
            
            // Store cart ID in session storage for checkout page
            if (cart.id) {
                sessionStorage.setItem('cart_id', cart.id);
            }
            
            renderCart();
            updateCartBadge();

        } catch (err) {
            console.error('[loadCart]', err);
            renderEmpty();
        }
    }

    function renderEmpty() {
        document.getElementById('cart').innerHTML = `
            <div class="text-center py-5">
                <i class="bi bi-cart-x empty-cart-icon d-block mb-3"></i>
                <h5 class="text-muted">Your cart is empty</h5>
                <p class="text-muted mb-4">Browse our products and add items to get started.</p>
                <a href="{{ route('products') }}" class="btn btn-success px-4">
                    <i class="bi bi-bag me-2"></i>Shop Now
                </a>
            </div>
        `;
        document.getElementById('cartActions').classList.add('d-none');
    }

    function renderCart() {
        const container = document.getElementById('cart');

        if (!cart.items || cart.items.length === 0) {
            renderEmpty();
            return;
        }

        let rows = '';
        cart.items.forEach(item => {
            rows += `
                <tr>
                    <td class="fw-semibold">${escapeHtml(item.product_name)}</td>
                    <td>
                        <div class="d-flex align-items-center gap-1">
                            <button class="btn btn-sm btn-outline-secondary" onclick="changeQuantity(${item.product}, ${item.quantity - 1})">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input type="number" min="1" value="${item.quantity}" class="form-control text-center" style="width:65px" onchange="changeQuantity(${item.product}, this.value)">
                            <button class="btn btn-sm btn-outline-secondary" onclick="changeQuantity(${item.product}, ${item.quantity + 1})">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </td>
                    <td>KES ${Number(item.unit_price).toLocaleString()}</td>
                    <td class="fw-semibold">KES ${(item.unit_price * item.quantity).toLocaleString()}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-danger" onclick="removeItem(${item.product})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                 </tr>
            `;
        });

        container.innerHTML = `
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th style="min-width:170px">Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                            <th style="width: 50px"></th>
                        </tr>
                    </thead>
                    <tbody>${rows}</tbody>
                </table>
            </div>
            <div class="text-end mt-3">
                <h4 class="fw-bold" style="color:#2a6e3f;">Total: KES ${Number(cart.subtotal).toLocaleString()}</h4>
            </div>
        `;
        
        document.getElementById('cartActions').classList.remove('d-none');
    }

    window.changeQuantity = async function (productId, quantity) {
        if (quantity <= 0) {
            removeItem(productId);
            return;
        }

        await fetch(API.update, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
            credentials: 'same-origin',
            body: JSON.stringify({ product: productId, quantity: Number(quantity) }),
        });

        loadCart();
    };

    window.removeItem = async function (productId) {
        await fetch(API.remove, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
            credentials: 'same-origin',
            body: JSON.stringify({ product: productId }),
        });

        loadCart();
    };

    function updateCartBadge() {
        const badge = document.querySelector('.cart-badge');
        if (!badge) return;
        badge.textContent = cart.total_items;
        badge.style.display = cart.total_items ? 'flex' : 'none';
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadCart();
    });

})();
</script>

@endsection