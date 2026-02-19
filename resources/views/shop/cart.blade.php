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

<script>
const API = {
    load:   `/proxy/cart`,
    add:    `/proxy/cart/add`,
    update: `/proxy/cart/update`,
    remove: `/proxy/cart/remove`,
};

let cart = { items: [], subtotal: 0, total_items: 0 };

/* ================= ALERT ================= */
function showAlert(message, type = 'danger') {
    const el = document.getElementById('notificationAlert');
    el.className = `alert alert-${type}`;
    el.textContent = message;
    el.classList.remove('d-none');
    setTimeout(() => el.classList.add('d-none'), 4000);
}

/* ================= LOAD CART ================= */
async function loadCart() {
    try {
        const res = await fetch(API.load);

        if (!res.ok) {
            throw new Error(`HTTP ${res.status}`);
        }

        cart = await res.json();
        renderCart();
        updateCartBadge();

    } catch (err) {
        console.error(err);
        showAlert("Failed to load cart");
    }
}

/* ================= RENDER ================= */
function renderCart() {
    const container = document.getElementById('cart');

    if (!cart.items || cart.items.length === 0) {
        container.innerHTML = '<p class="text-muted">Your cart is empty.</p>';
        return;
    }

    let html = `
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th width="120">Qty</th>
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
                <td>
                    <input type="number" min="1" value="${item.quantity}"
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
        <strong>Subtotal: KES ${cart.subtotal}</strong>
    `;

    container.innerHTML = html;
}

/* ================= ADD ================= */
async function addItem(productId, quantity = 1) {
    try {
        const res = await fetch(API.add, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                product: productId,
                quantity: Number(quantity),
            }),
        });

        const data = await res.json();
        if (!res.ok) throw new Error(data.detail || 'Add failed');

        showAlert("Item added", "success");
        loadCart();
    } catch (err) {
        console.error(err);
        showAlert("Add failed");
    }
}

/* ================= UPDATE ================= */
async function updateItem(productId, quantity) {
    await fetch(API.update, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product: productId,
            quantity: Number(quantity),
        }),
    });

    loadCart();
}

/* ================= REMOVE ================= */
async function removeItem(productId) {
    await fetch(API.remove, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product: productId,
        }),
    });

    loadCart();
}

/* ================= BADGE ================= */
function updateCartBadge() {
    const badge = document.querySelector('.cart-badge');
    if (!badge) return;

    badge.textContent = cart.total_items;
    badge.style.display = cart.total_items ? 'flex' : 'none';
}

/* ================= INIT ================= */
document.addEventListener('DOMContentLoaded', loadCart);
</script>

@endsection
