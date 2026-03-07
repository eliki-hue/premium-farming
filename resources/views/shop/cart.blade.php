@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<div class="container my-4">
    <h3>🛒 Your Cart</h3>

    <div id="notificationAlert" class="alert d-none"></div>

    <div id="cart" class="mt-3">
        <p class="text-muted">Loading cart…</p>
    </div>

    <!-- Checkout Form -->
    <div id="checkoutSection" class="mt-5 d-none">
        <h4>Checkout</h4>

        <form id="checkoutForm">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Full Name *</label>
                    <input type="text" class="form-control" name="name" value="{{ auth()->user()->name ?? '' }}" required>
                </div>
                <div class="col-md-6">
                    <label>Phone Number *</label>
                    <input type="tel" class="form-control" name="phone" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Email Address *</label>
                <input type="email" class="form-control" name="email" value="{{ auth()->user()->email ?? '' }}" required>
            </div>

            <div class="mb-3">
                <label>Delivery Address *</label>
                <textarea class="form-control" name="address" rows="3" required></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>County *</label>
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
                    <label>Town *</label>
                    <input type="text" class="form-control" name="town" required>
                </div>
            </div>

            <div class="mb-4">
                <label>Delivery Type *</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="delivery_type" value="farm_delivery" checked>
                    <label class="form-check-label">Farm Delivery</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="delivery_type" value="pickup_station">
                    <label class="form-check-label">Pickup Station</label>
                </div>
            </div>

            <!-- MPESA ONLY -->
            <input type="hidden" name="payment_method" value="mpesa">

            <div id="mpesaDetails" class="mb-4 border p-3 rounded bg-light">
                <label>M-Pesa Phone Number *</label>
                <input type="tel" class="form-control" name="mpesa_number" placeholder="2547XXXXXXXX" required>
            </div>

            <input type="hidden" name="total" id="checkoutTotal">

            <button type="submit" class="btn btn-success btn-lg w-100">
                Complete Order
            </button>
        </form>
    </div>
</div>

<script>
const API = {
    load:   `/proxy/cart`,
    update: `/proxy/cart/update`,
    remove: `/proxy/cart/remove`,
};

let cart = { items: [], subtotal: 0, total_items: 0 };

function showAlert(message, type='danger') {
    const el = document.getElementById('notificationAlert');
    el.className = `alert alert-${type}`;
    el.textContent = message;
    el.classList.remove('d-none');
    setTimeout(()=>el.classList.add('d-none'),4000);
}

async function loadCart() {
    try {
        const res = await fetch(API.load, {
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });
        cart = await res.json();
        renderCart();
        renderCheckout();
        updateCartBadge();
    } catch (err) {
        console.error(err);
        showAlert("Failed to load cart");
    }
}

function renderCart() {
    const container = document.getElementById('cart');

    if (!cart.items || cart.items.length === 0) {
        container.innerHTML = '<p class="text-muted">Your cart is empty.</p>';
        document.getElementById('checkoutSection').classList.add('d-none');
        return;
    }

    let html = `
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th width="140">Qty</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
    `;

    cart.items.forEach(item => {
        html += `
            <tr>
                <td>${item.product_name}</td>
                <td class="d-flex align-items-center">
                    <button class="btn btn-sm btn-outline-secondary me-1"
                        onclick="changeQuantity(${item.product}, ${item.quantity - 1})">-</button>
                    <input type="number" min="1" value="${item.quantity}"
                        class="form-control text-center"
                        style="width:60px"
                        onchange="changeQuantity(${item.product}, this.value)">
                    <button class="btn btn-sm btn-outline-secondary ms-1"
                        onclick="changeQuantity(${item.product}, ${item.quantity + 1})">+</button>
                </td>
                <td>KES ${item.unit_price}</td>
                <td>KES ${(item.unit_price * item.quantity).toFixed(2)}</td>
                <td>
                    <button class="btn btn-sm btn-danger"
                        onclick="removeItem(${item.product})">Remove</button>
                </td>
            </tr>
        `;
    });

    html += `
            </tbody>
        </table>
        <strong>Subtotal: KES ${cart.subtotal}</strong>
    `;

    container.innerHTML = html;
}

function renderCheckout() {
    if (cart.items.length > 0) {
        document.getElementById('checkoutSection').classList.remove('d-none');
        document.getElementById('checkoutTotal').value = cart.subtotal;
    }
}

async function changeQuantity(productId, quantity) {
    if (quantity <= 0) {
        removeItem(productId);
        return;
    }

    await fetch(API.update, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ product: productId, quantity: Number(quantity) }),
    });

    loadCart();
}

async function removeItem(productId) {
    await fetch(API.remove, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ product: productId }),
    });

    loadCart();
}

function updateCartBadge() {
    const badge = document.querySelector('.cart-badge');
    if (!badge) return;
    badge.textContent = cart.total_items;
    badge.style.display = cart.total_items ? 'flex' : 'none';
}

/* ✅ CHECKOUT VIA LARAVEL → DJANGO */
document.getElementById('checkoutForm').addEventListener('submit', async function(e){
    e.preventDefault();

    const formData = new FormData(this);

    const res = await fetch(`/proxy/checkout/mpesa`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    });

    if(!res.ok){
        alert("Checkout failed");
        return;
    }

    window.location.href = "/orders";
});
document.addEventListener('DOMContentLoaded', loadCart);
</script>
@endsection