@extends('layouts.app')

@section('title', 'Cart')

@section('content')
{{-- <script>
const TOKEN = "{{ session('django_token') }}";
</script> --}}

<div class="container my-4">
    <h3>🛒 Cart</h3>
    <div id="msg" class="fw-bold"></div>
    <div id="cart"></div>
</div>

<!-- Receipt Modal -->
<div id="receiptModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.55); z-index:9999;">
  <div class="card p-3" style="max-width:600px;margin:50px auto;">
    <h4>🧾 Receipt</h4>
    <div id="receiptBody"></div>
    <button onclick="closeReceipt()" class="btn btn-danger">Close</button>
    <button onclick="window.print()" class="btn btn-primary">Print</button>
  </div>
</div>

<script>
const TOKEN = "{{ session('django_token') }}";

let cart = { items: [], subtotal: 0 };

// LOAD CART
// async function loadCart() {
//     try {
//         const res = await fetch('/cart/load');
//         let data = { items: [], subtotal: 0 };
//         try {
//             data = await res.json();
//         } catch(err) {
//             console.error('Invalid JSON from /cart/load', err);
//         }
//         cart = data;
//         renderCart();
//         updateCartBadge();
//     } catch (err) {
//         console.error('Failed to load cart:', err);
//         document.getElementById('msg').innerText = '❌ Failed to load cart';
//     }
// }

// RENDER CART
function renderCart() {
    const items = cart?.items || [];
    const container = document.getElementById('cart');
    if (!items.length) {
        container.innerHTML = '<p class="text-muted">No items in cart</p>';
        return;
    }

    let html = `<table class="table">
        <thead><tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th><th></th></tr></thead><tbody>`;

    items.forEach(i => {
        html += `<tr>
            <td>${i.product_name}</td>
            <td><input type="number" min="1" value="${i.quantity}"
                onchange="updateItem(${i.product},this.value)"
                class="form-control"></td>
            <td>KES ${i.unit_price}</td>
            <td>KES ${(i.unit_price*i.quantity).toFixed(2)}</td>
            <td><button onclick="removeItem(${i.product})" class="btn btn-danger btn-sm">Remove</button></td>
        </tr>`;
    });

    html += `</tbody></table>
        <div class="d-flex justify-content-between">
        <b>Subtotal: KES ${cart.subtotal}</b>
        <button onclick="checkout()" class="btn btn-success">Checkout</button>
    </div>`;

    container.innerHTML = html;
}

// ADD ITEM
async function addItem(productId, quantity = 1) {
    const btn = event.currentTarget;
    const originalHTML = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i>';
    btn.disabled = true;

    try {
        const res = await fetch('/cart/items', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ productId, quantity })
        });

        let data = {};
        try { data = await res.json(); } catch(err) { console.error(err); }

        if (res.ok) {
            showAlert('Success', 'Item added to cart!', 'success');
            loadCart();
        } else {
            showAlert('Error', data.error || 'Failed to add item', 'error');
        }
    } catch (err) {
        console.error('Add to cart failed:', err);
        showAlert('Error', 'Network error. Try again.', 'error');
    } finally {
        btn.innerHTML = originalHTML;
        btn.disabled = false;
    }
}

// UPDATE ITEM
async function updateItem(product, quantity) {
    try {
        await fetch('/cart/update', {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ product, quantity })
        });
        loadCart();
    } catch(err) { console.error(err); }
}

// REMOVE ITEM
async function removeItem(product) {
    try {
        await fetch('/cart/remove', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ product })
        });
        loadCart();
    } catch(err) { console.error(err); }
}

// CHECKOUT
async function checkout() {
    try {
        const res = await fetch('/cart/checkout', { method: 'POST' });
        let data = {};
        try { data = await res.json(); } catch(err) { console.error(err); }

        if (data.receipt) showReceipt(data.receipt);
        loadCart();
    } catch(err) { console.error(err); }
}

// CART BADGE
async function updateCartBadge() {
    const badge = document.querySelector('.cart-badge');
    if (!badge) return;
    badge.style.display = 'none';

    if (!cart.items || !cart.items.length) return;

    badge.textContent = cart.items.length;
    badge.style.display = 'flex';
}

// RECEIPT MODAL
function showReceipt(r){
    let html = `<p><b>Date:</b> ${new Date(r.created_at).toLocaleString()}</p>
        <table class="table"><tr><th>Item</th><th>Qty</th><th>Total</th></tr>`;

    r.items.forEach(i => {
        html += `<tr><td>${i.product_name}</td><td>${i.quantity}</td><td>KES ${i.subtotal}</td></tr>`;
    });

    html += `</table><h5>Total: KES ${r.total}</h5>`;
    document.getElementById('receiptBody').innerHTML = html;
    document.getElementById('receiptModal').style.display='block';
}

function closeReceipt(){
    document.getElementById('receiptModal').style.display='none';
}

// ALERT
function showAlert(title, message, type='success') {
    const alert = document.getElementById('notificationAlert');
    if (!alert) return;
    alert.textContent = `${title}: ${message}`;
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    setTimeout(() => alert.className = 'alert alert-dismissible fade', 4000);
}

// INIT
document.addEventListener('DOMContentLoaded', () => { loadCart(); });
</script>

@endsection
