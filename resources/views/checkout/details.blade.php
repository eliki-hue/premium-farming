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
                        <input type="hidden" id="csrfToken">

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
let cartDataGlobal = null;
let csrfToken = null;

document.addEventListener('DOMContentLoaded', function() {
    loadCSRFToken();
});

async function init() {
    try {
        await getCSRF();   // 🔥 FIRST GET TOKEN
        await loadCart();  // 🔥 THEN LOAD CART
    } catch (e) {
        console.error(e);
        showError("Initialization failed");
    }
}

/**
 * GET CSRF TOKEN (FROM LARAVEL → DJANGO)
 */
async function getCSRF() {
    const res = await fetch(`${BASE_URL}/api/ecommerce/csrf-token/`, {
        method: 'GET',
        credentials: 'include'
    });

    const text = await res.text();
    console.log("CSRF RAW:", text);

    let data;
    try {
        data = JSON.parse(text);
    } catch {
        throw new Error("Backend not returning JSON (wrong URL or CORS)");
    }

    csrfToken = data.csrf_token;

    if (!csrfToken) {
        throw new Error("CSRF token missing");
    }

    console.log("CSRF OK:", csrfToken);
}

/**
 * LOAD CART
 */
async function loadCart() {
    const res = await fetch(`${BASE_URL}/api/cart/`, {
        credentials: 'include'
    });

    const data = await res.json();

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
 * SUMMARY
 */
function renderSummary(data) {
    let html = "";
    data.items.forEach(item => {
        const total = (item.price || item.unit_price) * item.quantity;
        html += `• ${item.name || item.product_name} x ${item.quantity} = KES ${total}<br>`;
    });
    html += `<hr>Total: KES ${data.subtotal}`;
    document.getElementById('summaryContent').innerHTML = html;
    document.getElementById('orderSummary').classList.remove('d-none');
}


/**
 * SUBMIT ORDER
 */
document.getElementById('orderForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerText = "Processing...";

    const payload = {
        cart_id: document.getElementById('cartId').value,
        customer_name: document.getElementById('customerName').value,
        phone_number: document.getElementById('phoneNumber').value
    };

    try {
        const res = await fetch(`${BASE_URL}/api/ecommerce/place-order/`, {
            method: 'POST',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRFToken': csrfToken
            },
            body: JSON.stringify(payload)
        });

        const text = await res.text();
        console.log("ORDER RAW:", text);

        const data = JSON.parse(text);

        if (data.success) {
            alert("Order created!");
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