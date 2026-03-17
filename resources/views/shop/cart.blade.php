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

    {{-- ─── Checkout Form (hidden until cart has items) ─── --}}
    <div id="checkoutSection" class="mt-5 d-none">
        <h4 class="fw-bold mb-4" style="color:#2a6e3f;">
            <i class="bi bi-bag-check me-2"></i>Checkout
        </h4>

        {{-- ─── WhatsApp INQUIRY SECTION ─── --}}
        <div class="mb-5">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #dcf8c6, #e8f5e9);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="fw-bold mb-2" style="color: #075e54;">
                                <i class="bi bi-whatsapp me-2" style="color: #25D366; font-size: 1.5rem;"></i>
                                Order via WhatsApp
                            </h5>
                            <p class="mb-md-0 text-muted">
                                Click the button below to send your order details directly to our WhatsApp.
                                You can review and edit the message before sending.
                            </p>
                            <small class="text-muted d-block mt-1">
                                <i class="bi bi-telephone me-1"></i>WhatsApp: 0700680017
                            </small>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <button type="button" id="whatsappDirectBtn" class="btn btn-lg px-4" 
                                    style="background: #25D366; color: white; border: none; font-weight: 600;">
                                <i class="bi bi-whatsapp me-2"></i>
                                Send to WhatsApp
                                <span id="cartItemCount" class="badge bg-white text-dark ms-2">0</span>
                            </button>
                        </div>
                    </div>
                    
                    {{-- Message Preview Section --}}
                    <div id="messagePreviewSection" class="mt-3 p-3 bg-white rounded-3 d-none">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-success fw-bold">
                                <i class="bi bi-whatsapp me-1"></i>Message Preview:
                            </small>
                            <button type="button" id="copyMessageBtn" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-clipboard"></i> Copy
                            </button>
                        </div>
                        <div id="whatsappMessagePreview" class="p-3 bg-light rounded" style="font-family: 'Courier New', monospace; font-size: 0.9rem; white-space: pre-wrap;">
                            Loading...
                        </div>
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle me-1"></i>
                            Clicking the button will open WhatsApp with this message. You can edit it before sending.
                        </small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Optional Divider --}}
        <div class="text-center mb-4">
            <span class="bg-white px-3 text-muted">OR Pay Directly with M-Pesa</span>
            <hr class="my-3">
        </div>

        <form id="checkoutForm">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Full Name *</label>
                    <input type="text" class="form-control" name="name"
                           value="{{ session('django_user.full_name') ?? session('django_user.username') ?? '' }}"
                           required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Phone Number *</label>
                    <input type="tel" class="form-control" name="phone" placeholder="0700680017" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Email Address *</label>
                <input type="email" class="form-control" name="email"
                       value="{{ session('django_user.email') ?? '' }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Delivery Address *</label>
                <textarea class="form-control" name="address" rows="3" required></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">County *</label>
                    <select class="form-control" name="county" required>
                        <option value="">Select County</option>
                        <option value="Nairobi">Nairobi</option>
                        <option value="Kiambu">Kiambu</option>
                        <option value="Nakuru">Nakuru</option>
                        <option value="Eldoret">Eldoret</option>
                        <option value="Kisumu">Kisumu</option>
                        <option value="Mombasa">Mombasa</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Town *</label>
                    <input type="text" class="form-control" name="town" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Delivery Type *</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="delivery_type" value="farm_delivery" checked>
                    <label class="form-check-label">Farm Delivery</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="delivery_type" value="pickup_station">
                    <label class="form-check-label">Pickup Station</label>
                </div>
            </div>

            {{-- M-Pesa only --}}
            <input type="hidden" name="payment_method" value="mpesa">

            <div id="mpesaDetails" class="mb-4 border p-3 rounded bg-light">
                <label class="form-label fw-semibold">
                    <i class="bi bi-phone me-1 text-success"></i>M-Pesa Phone Number *
                </label>
                <input type="tel" class="form-control" name="mpesa_number"
                       placeholder="0700680017" required>
                <small class="text-muted">Enter the number that will receive the STK push prompt.</small>
            </div>

            <input type="hidden" name="total" id="checkoutTotal">

            <div class="d-flex gap-3 flex-wrap">
                <button type="submit" class="btn btn-success btn-lg flex-grow-1">
                    <i class="bi bi-phone me-2"></i>Pay with M-Pesa
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .table th { background-color: #f8fdf9; color: #2a6e3f; font-weight: 600; }
    .table td { vertical-align: middle; }

    .btn-success {
        background: linear-gradient(135deg, #2a6e3f, #3a8e5c);
        border: none;
        font-weight: 600;
    }
    .btn-success:hover {
        background: linear-gradient(135deg, #1e5a2f, #2a6e3f);
        transform: translateY(-1px);
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

    /* WhatsApp button styles */
    #whatsappDirectBtn {
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
    }
    #whatsappDirectBtn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
        background: #20b859 !important;
    }

    /* Message preview styles */
    #whatsappMessagePreview {
        border-left: 4px solid #25D366;
        max-height: 300px;
        overflow-y: auto;
    }

    /* Copy button styles */
    #copyMessageBtn {
        transition: all 0.2s ease;
    }
    #copyMessageBtn:hover {
        background: #25D366;
        color: white;
        border-color: #25D366;
    }

    /* Empty cart state */
    .empty-cart-icon {
        font-size: 4rem;
        color: #c8e6c9;
    }

    /* Toast notification */
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

    // WhatsApp configuration
    const WHATSAPP_NUMBER = '0700680017'; // Your specific WhatsApp number
    const WHATSAPP_COUNTRY_CODE = '254'; // Kenya country code

    let cart = { items: [], subtotal: 0, total_items: 0 };
    let currentWhatsAppMessage = '';

    /* ─── Format phone number for WhatsApp ─── */
    function formatWhatsAppNumber(phone) {
        // Remove any non-digit characters
        let clean = phone.replace(/\D/g, '');
        
        // If starts with 0, replace with country code
        if (clean.startsWith('0')) {
            clean = WHATSAPP_COUNTRY_CODE + clean.substring(1);
        }
        
        return clean;
    }

    /* ─── Generate Order Reference ─── */
    function generateOrderRef() {
        const prefix = 'ORD';
        const random = Math.floor(1000 + Math.random() * 9000); // 4-digit random
        return `${prefix}-${random}`;
    }

    /* ─── Format WhatsApp Message exactly as requested ─── */
    function formatWhatsAppMessage(cartItems, subtotal, customerName = '') {
        const orderRef = generateOrderRef();
        
        // Start with the greeting
        let message = "Hello, I would like to order the following items:\n\n";
        
        // Add order reference
        message += `Order Ref: ${orderRef}\n\n`;
        
        // Add items - format: 1. Dell Laptop – 1 pcs – KES 65,000
        cartItems.forEach((item, index) => {
            const itemNumber = index + 1;
            const itemName = item.product_name;
            const quantity = item.quantity;
            const unitPrice = Number(item.unit_price);
            const itemTotal = unitPrice * quantity;
            
            message += `${itemNumber}. ${itemName} – ${quantity} pcs – KES ${itemTotal.toLocaleString()}\n`;
        });
        
        // Add total
        message += `\nTotal: KES ${Number(subtotal).toLocaleString()}\n\n`;
        
        // Add customer name if provided
        if (customerName) {
            message += `Customer: ${customerName}\n\n`;
        }
        
        // Add delivery inquiry
        message += "Please advise on delivery and transport options.";
        
        return message;
    }

    /* ─── Generate WhatsApp URL with pre-filled message ─── */
    function generateWhatsAppUrl(message) {
        const formattedNumber = formatWhatsAppNumber(WHATSAPP_NUMBER);
        const encodedMessage = encodeURIComponent(message);
        return `https://wa.me/${formattedNumber}?text=${encodedMessage}`;
    }

    /* ─── Notification ─── */
    function showAlert(message, type = 'danger') {
        const el = document.getElementById('notificationAlert');
        el.className = `alert alert-${type}`;
        el.textContent = message;
        el.classList.remove('d-none');
        setTimeout(() => el.classList.add('d-none'), 4000);
    }

    /* ─── Custom Toast Notification ─── */
    function showToast(message, type = 'success', duration = 4000) {
        // Remove existing toast
        const existingToast = document.querySelector('.cart-toast');
        if (existingToast) existingToast.remove();

        // Create toast
        const toast = document.createElement('div');
        toast.className = 'cart-toast';
        
        const icon = document.createElement('i');
        icon.className = type === 'success' ? 'bi bi-check-circle-fill text-success' : 'bi bi-exclamation-circle-fill text-danger';
        
        const text = document.createElement('span');
        text.textContent = message;
        
        toast.appendChild(icon);
        toast.appendChild(text);
        
        document.body.appendChild(toast);
        
        // Auto remove
        setTimeout(() => {
            toast.style.animation = 'slideInRight 0.3s reverse';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }

    /* ─── Update Message Preview ─── */
    function updateMessagePreview() {
        const previewSection = document.getElementById('messagePreviewSection');
        const previewDiv = document.getElementById('whatsappMessagePreview');
        const itemCount = document.getElementById('cartItemCount');
        
        if (!cart.items || cart.items.length === 0) {
            previewSection.classList.add('d-none');
            itemCount.textContent = '0';
            return;
        }
        
        // Get customer name from form if available
        const customerName = document.querySelector('input[name="name"]')?.value || '';
        
        // Generate message
        currentWhatsAppMessage = formatWhatsAppMessage(cart.items, cart.subtotal, customerName);
        
        // Update preview
        previewDiv.textContent = currentWhatsAppMessage;
        previewSection.classList.remove('d-none');
        itemCount.textContent = cart.items.length;
    }

    /* ─── Copy message to clipboard ─── */
    function copyMessageToClipboard() {
        if (!currentWhatsAppMessage) return;
        
        navigator.clipboard.writeText(currentWhatsAppMessage).then(() => {
            showToast('✅ Message copied to clipboard!', 'success');
        }).catch(err => {
            console.error('Failed to copy:', err);
            showToast('Failed to copy message', 'error');
        });
    }

    /* ─── Load Cart ─── */
    async function loadCart() {
        try {
            const res = await fetch(API.load, {
                headers: {
                    'Accept':       'application/json',
                    'X-CSRF-TOKEN': CSRF,
                },
                credentials: 'same-origin',
            });

            if (res.status === 401) {
                renderEmpty();
                return;
            }

            if (!res.ok) {
                showAlert('Could not load cart. Please try again.');
                renderEmpty();
                return;
            }

            cart = await res.json();
            renderCart();
            renderCheckout();
            updateCartBadge();
            updateMessagePreview();

        } catch (err) {
            console.error('[loadCart]', err);
            showAlert('Network error loading cart.');
            renderEmpty();
        }
    }

    /* ─── Render: Empty State ─── */
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
        document.getElementById('checkoutSection').classList.add('d-none');
    }

    /* ─── Render: Cart Table ─── */
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
                    <td>${item.product_name}</td>
                    <td>
                        <div class="d-flex align-items-center gap-1">
                            <button class="btn btn-sm btn-outline-secondary"
                                onclick="changeQuantity(${item.product}, ${item.quantity - 1})">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input type="number" min="1" value="${item.quantity}"
                                class="form-control text-center"
                                style="width:65px"
                                onchange="changeQuantity(${item.product}, this.value)">
                            <button class="btn btn-sm btn-outline-secondary"
                                onclick="changeQuantity(${item.product}, ${item.quantity + 1})">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </td>
                    <td>KES ${Number(item.unit_price).toLocaleString()}</td>
                    <td class="fw-semibold">KES ${(item.unit_price * item.quantity).toLocaleString(undefined, {minimumFractionDigits:2})}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-danger"
                            onclick="removeItem(${item.product})">
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
                            <th style="min-width:170px">Qty</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>${rows}</tbody>
                </table>
            </div>
            <div class="text-end mt-2">
                <span class="fs-5 fw-bold" style="color:#2a6e3f;">
                    Subtotal: KES ${Number(cart.subtotal).toLocaleString(undefined, {minimumFractionDigits:2})}
                </span>
            </div>
        `;
    }

    /* ─── Render: Show Checkout Section ─── */
    function renderCheckout() {
        if (cart.items && cart.items.length > 0) {
            document.getElementById('checkoutSection').classList.remove('d-none');
            document.getElementById('checkoutTotal').value = cart.subtotal;
        } else {
            document.getElementById('checkoutSection').classList.add('d-none');
        }
    }

    /* ─── Change Quantity ─── */
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
                'Accept':       'application/json',
            },
            credentials: 'same-origin',
            body: JSON.stringify({ product: productId, quantity: Number(quantity) }),
        });

        loadCart();
    };

    /* ─── Remove Item ─── */
    window.removeItem = async function (productId) {
        await fetch(API.remove, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
            },
            credentials: 'same-origin',
            body: JSON.stringify({ product: productId }),
        });

        loadCart();
    };

    /* ─── Cart Badge in Navbar ─── */
    function updateCartBadge() {
        const badge = document.querySelector('.cart-badge');
        if (!badge) return;
        badge.textContent   = cart.total_items;
        badge.style.display = cart.total_items ? 'flex' : 'none';
    }

    /* ─── WhatsApp Direct Handler ─── */
    document.getElementById('whatsappDirectBtn')?.addEventListener('click', function() {
        const btn = this;
        
        // Check if cart has items
        if (!cart.items || cart.items.length === 0) {
            showToast('Your cart is empty. Add items first.', 'error');
            return;
        }
        
        // Check if we have a message
        if (!currentWhatsAppMessage) {
            // Regenerate message with current customer name
            const customerName = document.querySelector('input[name="name"]')?.value || '';
            currentWhatsAppMessage = formatWhatsAppMessage(cart.items, cart.subtotal, customerName);
        }
        
        // Generate WhatsApp URL
        const whatsappUrl = generateWhatsAppUrl(currentWhatsAppMessage);
        
        // Open WhatsApp in new tab - this will open with the message pre-filled
        // User can edit before sending
        window.open(whatsappUrl, '_blank');
        
        // Show success message
        showToast(
            `✅ WhatsApp opened with your order! You can review and edit the message before sending.`, 
            'success',
            5000
        );
        
        // Store order info in session storage
        const orderRef = currentWhatsAppMessage.match(/Order Ref: (ORD-\d+)/)?.[1] || 'Unknown';
        const orderInfo = {
            orderRef: orderRef,
            items: cart.items.length,
            total: cart.subtotal,
            timestamp: new Date().toISOString(),
            message: currentWhatsAppMessage
        };
        sessionStorage.setItem('last_whatsapp_order', JSON.stringify(orderInfo));
    });

    /* ─── Copy Message Button ─── */
    document.getElementById('copyMessageBtn')?.addEventListener('click', copyMessageToClipboard);

    /* ─── Checkout Submit ─── */
    document.getElementById('checkoutForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const btn = this.querySelector('button[type="submit"]');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing…';
        btn.disabled  = true;

        try {
            const res = await fetch('/proxy/checkout/mpesa', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF },
                credentials: 'same-origin',
                body: new FormData(this),
            });

            if (!res.ok) {
                const err = await res.json().catch(() => ({}));
                showAlert(err.message || 'Checkout failed. Please try again.', 'danger');
                btn.innerHTML = '<i class="bi bi-phone me-2"></i>Pay with M-Pesa';
                btn.disabled  = false;
                return;
            }

            window.location.href = '/orders';

        } catch (err) {
            console.error('[checkout]', err);
            showAlert('Network error during checkout.', 'danger');
            btn.innerHTML = '<i class="bi bi-phone me-2"></i>Pay with M-Pesa';
            btn.disabled  = false;
        }
    });

    /* ─── Check for last order on page load ─── */
    function checkLastOrder() {
        const lastOrder = sessionStorage.getItem('last_whatsapp_order');
        if (lastOrder) {
            try {
                const order = JSON.parse(lastOrder);
                const timeDiff = (new Date() - new Date(order.timestamp)) / 1000 / 60; // minutes
                
                // Show reminder if less than 5 minutes ago
                if (timeDiff < 5) {
                    setTimeout(() => {
                        showToast(`📱 Your order ${order.orderRef} is ready to send to WhatsApp`, 'info', 6000);
                    }, 1000);
                }
            } catch (e) {
                console.error('Error parsing last order', e);
            }
        }
    }

    /* ─── Update preview when name changes ─── */
    document.querySelector('input[name="name"]')?.addEventListener('input', function() {
        if (cart.items && cart.items.length > 0) {
            currentWhatsAppMessage = formatWhatsAppMessage(cart.items, cart.subtotal, this.value);
            document.getElementById('whatsappMessagePreview').textContent = currentWhatsAppMessage;
        }
    });

    /* ─── Boot ─── */
    document.addEventListener('DOMContentLoaded', () => {
        loadCart();
        checkLastOrder();
    });

})();
</script>

@endsection