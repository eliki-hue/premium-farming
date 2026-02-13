@extends('layouts.app')

@section('title', 'Cart')

@section('content')

<div class="container my-4">
    <h3>🛒 Your Cart</h3>

    <div id="notificationAlert" class="alert d-none"></div>

    <div id="cart" class="mt-3">
        <p class="text-muted">Loading cart…</p>
    </div>
</div>

<!-- ================= RECEIPT MODAL ================= -->
<div id="receiptModal"
     style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.55); z-index:9999;">
    <div class="card p-3" style="max-width:600px;margin:60px auto;">
        <h4>🧾 Receipt</h4>
        <div id="receiptBody" class="mt-2"></div>
        <div class="d-flex justify-content-end gap-2 mt-3">
            <button onclick="closeReceipt()" class="btn btn-danger">Close</button>
            <button onclick="window.print()" class="btn btn-primary">Print</button>
        </div>
    </div>
</div>

<script>
/* =====================================================
   CONFIG
===================================================== */
const DJANGO_TOKEN = "{{ session('django_token') }}";
const DJANGO_BASE = "{{ config('services.django_api.url') }}";

const API = {
    load:     `${DJANGO_BASE}/api/ecommerce/cart/`,
    add:      `${DJANGO_BASE}/api/ecommerce/cart/items/`,
    update:   `${DJANGO_BASE}/api/ecommerce/cart/items/update/`,
    remove:   `${DJANGO_BASE}/api/ecommerce/cart/items/remove/`,
    checkout: `${DJANGO_BASE}/api/ecommerce/cart/checkout/`,
};


let cart = { items: [], subtotal: 0 };

/* =====================================================
   HELPERS
===================================================== */
function authHeaders() {
    return {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${DJANGO_TOKEN}`
    };
}

function showAlert(title, message, type = 'success') {
    const el = document.getElementById('notificationAlert');
    el.className = `alert alert-${type}`;
    el.textContent = `${title}: ${message}`;
    el.classList.remove('d-none');
    setTimeout(() => el.classList.add('d-none'), 4000);
}


/* =====================================================
   LOAD CART
===================================================== */
async function loadCart() {
    try {
        const res = await fetch(API.load, {
            headers: authHeaders()
        });

        if (!res.ok) throw new Error('Failed to load cart');

        cart = await res.json();
        renderCart();
        updateCartBadge();

    } catch (err) {
        console.error(err);
        showAlert('Error', err.message, 'danger');
    }
}

/* =====================================================
   RENDER CART
===================================================== */
function renderCart() {
    const container = document.getElementById('cart');

    if (!cart.items || cart.items.length === 0) {
        container.innerHTML = '<p class="text-muted">Your cart is empty.</p>';
        return;
    }

    let html = `
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Product</th>
                    <th width="120">Qty</th>
                    <th>Unit</th>
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
                <td>
                    <input type="number"
                           min="1"
                           value="${item.quantity}"
                           class="form-control"
                           onchange="updateItem(${item.product}, this.value)">
                </td>
                <td>KES ${item.unit_price}</td>
                <td>KES ${(item.unit_price * item.quantity).toFixed(2)}</td>
                <td>
                    <button class="btn btn-sm btn-danger"
                            onclick="removeItem(${item.product})">
                        Remove
                    </button>
                </td>
            </tr>
        `;
    });

    html += `
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <strong>Subtotal: KES ${cart.subtotal}</strong>
            <button class="btn btn-success" onclick="checkout()">
                Checkout
            </button>
        </div>
    `;

    container.innerHTML = html;
}

/* =====================================================
   ADD ITEM (DJANGO-COMPATIBLE)
===================================================== */
async function addItem(e, productId, quantity = 1) {
    const btn = e.currentTarget;
    const original = btn.innerHTML;

    btn.disabled = true;
    btn.innerHTML = 'Adding…';

    try {
        const res = await fetch(API.add, {
            method: 'POST',
            headers: authHeaders(),
            body: JSON.stringify({
                product: productId,   // 👈 MUST be "product"
                quantity: Number(quantity)
            })
        });

        const data = await res.json();
        if (!res.ok) throw new Error(data.detail || 'Add failed');

        showAlert('Success', 'Item added to cart');
        loadCart();

    } catch (err) {
        console.error(err);
        showAlert('Error', err.message, 'danger');
    } finally {
        btn.disabled = false;
        btn.innerHTML = original;
    }
}

/* =====================================================
   UPDATE ITEM
===================================================== */
async function updateItem(product, quantity) {
    try {
        await fetch(API.update, {
            method: 'PATCH',
            headers: authHeaders(),
            body: JSON.stringify({
                product,
                quantity: Number(quantity)
            })
        });

        loadCart();
    } catch (err) {
        console.error(err);
    }
}

/* =====================================================
   REMOVE ITEM
===================================================== */
async function removeItem(product) {
    try {
        await fetch(API.remove, {
            method: 'DELETE',
            headers: authHeaders(),
            body: JSON.stringify({ product })
        });

        loadCart();
    } catch (err) {
        console.error(err);
    }
}

/* =====================================================
   CHECKOUT
===================================================== */
async function checkout() {
    try {
        const res = await fetch(API.checkout, {
            method: 'POST',
            headers: authHeaders()
        });

        const data = await res.json();

        if (data.receipt) {
            showReceipt(data.receipt);
        }

        loadCart();
    } catch (err) {
        console.error(err);
    }
}

/* =====================================================
   RECEIPT
===================================================== */
function showReceipt(r) {
    let html = `
        <p><strong>Date:</strong> ${new Date(r.created_at).toLocaleString()}</p>
        <table class="table">
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
    `;

    r.items.forEach(i => {
        html += `
            <tr>
                <td>${i.product_name}</td>
                <td>${i.quantity}</td>
                <td>KES ${i.subtotal}</td>
            </tr>
        `;
    });

    html += `
        </table>
        <h5>Total: KES ${r.total}</h5>
    `;

    document.getElementById('receiptBody').innerHTML = html;
    document.getElementById('receiptModal').style.display = 'block';
}

function closeReceipt() {
    document.getElementById('receiptModal').style.display = 'none';
}

/* =====================================================
   CART BADGE
===================================================== */
function updateCartBadge() {
    const badge = document.querySelector('.cart-badge');
    if (!badge) return;

    badge.textContent = cart.items.length;
    badge.style.display = cart.items.length ? 'flex' : 'none';
}

/* =====================================================
   INIT
===================================================== */
document.addEventListener('DOMContentLoaded', loadCart);
</script>

@endsection