{{-- resources/views/checkout/details.blade.php --}}
@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Complete Your Order</h4>
                </div>
                <div class="card-body">

                    <!-- LOADING -->
                    <div id="loadingCart" class="text-center py-3">
                        <div class="spinner-border text-success"></div>
                        <p class="mt-2 text-muted">Loading your cart...</p>
                    </div>

                    <!-- EMPTY -->
                    <div id="cartEmpty" class="alert alert-warning d-none">
                        Your cart is empty. <a href="/products">Add items</a>.
                    </div>

                    <!-- ERROR -->
                    <div id="cartError" class="alert alert-danger d-none">
                        Something went wrong. Refresh page.
                    </div>

                    <!-- FORM -->
                    <form id="orderForm" class="d-none">
                        <input type="hidden" id="cartId">

                        <div id="orderSummary" class="alert alert-info d-none">
                            <div id="summaryContent"></div>
                        </div>

                        <div class="mb-3">
                            <label>Full Name</label>
                            <input type="text" id="customerName" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Phone</label>
                            <input type="text" id="phoneNumber" class="form-control" required>
                        </div>

                        <button class="btn btn-success w-100" id="submitBtn">
                            Place Order
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
// ✅ No BASE_URL — all calls go to Laravel which proxies to Django server-side
// ✅ No CORS issues — browser only ever talks to http://127.0.0.1:8000
const LARAVEL_CSRF = "{{ csrf_token() }}";
let djangoCsrfToken = null;

document.addEventListener('DOMContentLoaded', function () {
    init();
});

async function init() {
    try {
        await getDjangoCsrf();  // GET /ecommerce/csrf-token/  → OrderController
        await loadCart();       // GET /cart/load              → CartController
    } catch (e) {
        console.error(e);
        showError("Initialization failed: " + e.message);
    }
}

/**
 * GET DJANGO CSRF TOKEN via Laravel proxy
 * Route: GET /ecommerce/csrf-token/ → OrderController@getCsrfToken
 */
async function getDjangoCsrf() {
    const res = await fetch('/ecommerce/csrf-token/', {
        method: 'GET',
        credentials: 'same-origin',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': LARAVEL_CSRF
        }
    });

    const text = await res.text();
    console.log("Django CSRF RAW:", text);

    let data;
    try {
        data = JSON.parse(text);
    } catch {
        throw new Error("CSRF endpoint not returning JSON");
    }

    djangoCsrfToken = data.csrfToken;


    if (!djangoCsrfToken) {
        throw new Error("Django CSRF token missing from response");
    }

    console.log("Django CSRF OK:", djangoCsrfToken);
}

/**
 * LOAD CART via Laravel proxy
 * Route: GET /cart/load → CartController@load
 */
async function loadCart() {
    const res = await fetch('/cart/load', {
        credentials: 'same-origin',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': LARAVEL_CSRF
        }
    });

    if (!res.ok) {
        throw new Error(`Cart load failed: ${res.status}`);
    }

    const data = await res.json();
    console.log("Cart data:", data);

    if (!data.items || data.items.length === 0) {
        hideLoading();
        document.getElementById('cartEmpty').classList.remove('d-none');
        return;
    }

    document.getElementById('cartId').value = data.id;
    renderSummary(data);
    hideLoading();
    document.getElementById('orderForm').classList.remove('d-none');
}

/**
 * RENDER ORDER SUMMARY
 */
function renderSummary(data) {
    let html = "";
    data.items.forEach(item => {
        const unitPrice = item.price || item.unit_price || 0;
        const total = unitPrice * item.quantity;
        const name = item.name || item.product_name || 'Item';
        html += `• ${name} x ${item.quantity} = KES ${total}<br>`;
    });
    html += `<hr><strong>Total: KES ${data.subtotal}</strong>`;
    document.getElementById('summaryContent').innerHTML = html;
    document.getElementById('orderSummary').classList.remove('d-none');
}


document.getElementById('orderForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerText = "Processing...";

    const payload = {
        cart_id:       document.getElementById('cartId').value,
        customer_name: document.getElementById('customerName').value,
        phone_number:  document.getElementById('phoneNumber').value,
        django_csrf:   djangoCsrfToken  
    };

    try {
        const res = await fetch('/api/ecommerce/place-order/', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': LARAVEL_CSRF  
            },
            body: JSON.stringify(payload)
        });

        const text = await res.text();
        console.log("Order response RAW:", text);

        const data = JSON.parse(text);

        if (data.success) {
            window.location.href = '/order/confirmation/' + data.order_id;
        } else {
            throw new Error(data.message || "Order failed");
        }

    } catch (err) {
        console.error(err);
        alert(err.message);
        btn.disabled = false;
        btn.innerText = "Place Order";
    }
});

/**
 * HELPERS
 */
function hideLoading() {
    document.getElementById('loadingCart').classList.add('d-none');
}

function showError(msg) {
    hideLoading();
    const el = document.getElementById('cartError');
    el.innerText = msg;
    el.classList.remove('d-none');
}
</script>
@endsection