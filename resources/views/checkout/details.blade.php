@extends('layouts.app')

@section('title', 'Complete Your Order | Premium Farming Feeds')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            {{-- ─── Back link ─── --}}
            <a href="{{ route('cart.view') }}" class="d-inline-flex align-items-center gap-2 text-success mb-4 text-decoration-none fw-semibold">
                <i class="bi bi-arrow-left"></i> Back to Cart
            </a>

            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header py-3" style="background: linear-gradient(135deg, #2a6e3f, #3a8e5c);">
                    <h4 class="mb-0 text-white fw-semibold">
                        <i class="bi bi-bag-check me-2"></i>Complete Your Order
                    </h4>
                </div>

                <div class="card-body p-4">

                    {{-- ─── Loading ─── --}}
                    <div id="loadingCart" class="text-center py-4">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Loading…</span>
                        </div>
                        <p class="mt-2 text-muted small">Loading your cart…</p>
                    </div>

                    {{-- ─── Empty ─── --}}
                    <div id="cartEmpty" class="alert alert-warning d-none rounded-3">
                        <i class="bi bi-cart-x me-2"></i>
                        Your cart is empty. <a href="{{ route('products') }}" class="alert-link">Browse products</a>.
                    </div>

                    {{-- ─── Error ─── --}}
                    <div id="cartError" class="alert alert-danger d-none rounded-3">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <span id="cartErrorMsg">Something went wrong. Please refresh and try again.</span>
                    </div>

                    {{-- ─── Order Form ─── --}}
                    <div id="orderForm" class="d-none">

                        {{-- Cart summary --}}
                        <div class="mb-4 p-3 rounded-3" style="background:#f8fdf9; border:1px solid #c8e6c9;">
                            <h6 class="fw-semibold mb-3" style="color:#2a6e3f;">
                                <i class="bi bi-receipt me-2"></i>Order Summary
                            </h6>
                            <div id="summaryContent" class="small text-muted"></div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total</span>
                                <span id="summaryTotal" style="color:#2a6e3f;"></span>
                            </div>
                        </div>

                        {{-- Customer details --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" id="customerName" class="form-control rounded-3"
                                placeholder="e.g. Jane Wanjiku" required>
                            <div class="invalid-feedback">Please enter your full name.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text rounded-start-3 bg-light text-muted">
                                    <i class="bi bi-phone me-1"></i>+254
                                </span>
                                <input type="tel" id="phoneNumber" class="form-control rounded-end-3"
                                    placeholder="7XX XXX XXX" required>
                            </div>
                            <div class="form-text">We'll contact you on this number to confirm your order.</div>
                        </div>

                        <button class="btn btn-success w-100 py-3 rounded-3 fw-semibold fs-5"
                            id="submitBtn" onclick="submitOrder()">
                            <i class="bi bi-whatsapp me-2"></i>Place Order via WhatsApp
                        </button>

                        <p class="text-center text-muted small mt-3 mb-0">
                            <i class="bi bi-lock-fill me-1"></i>Your details are only used to process this order.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- ─── Full-screen redirect overlay ─── --}}
<div id="redirectOverlay" style="
    display: none;
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.65);
    z-index: 9999;
    align-items: center;
    justify-content: center;
">
    <div style="background:#fff; border-radius:20px; padding:36px 32px; text-align:center; max-width:380px; margin:0 16px;">
        <div style="font-size:3.5rem; margin-bottom:12px;">✅</div>
        <h5 style="color:#2a6e3f; font-weight:700; margin-bottom:8px;">Order Placed!</h5>
        <p style="color:#555; font-size:0.95rem; margin-bottom:6px;">
            Opening WhatsApp to confirm your order…
        </p>
        <p style="color:#888; font-size:0.85rem; margin-bottom:24px;">
            If it doesn't open, <a id="waFallbackLink" href="#" target="_blank"
                style="color:#2a6e3f; font-weight:600;">tap here</a>.
        </p>
        <a href="{{ route('products') }}"
            style="display:inline-block; background:linear-gradient(135deg,#2a6e3f,#3a8e5c);
                   color:#fff; padding:11px 30px; border-radius:10px;
                   text-decoration:none; font-weight:600; font-size:0.95rem;">
            Continue Shopping
        </a>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #2a6e3f;
        box-shadow: 0 0 0 0.2rem rgba(42, 110, 63, 0.15);
    }
    .input-group-text { border-color: #dee2e6; }
    .btn-success {
        background: linear-gradient(135deg, #2a6e3f, #3a8e5c);
        border: none;
        transition: all 0.3s ease;
        letter-spacing: 0.3px;
    }
    .btn-success:hover:not(:disabled) {
        background: linear-gradient(135deg, #1e5a2f, #2a6e3f);
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(42, 110, 63, 0.3);
    }
    .btn-success:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }
    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding: 5px 0;
        border-bottom: 1px dashed #e0f2e9;
    }
    .summary-item:last-child { border-bottom: none; }
</style>

<script>
(function () {
    'use strict';

    const WHATSAPP_NUMBER = '254741243693';

    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    let cartData        = null;
    let djangoCsrfToken = null;

    document.addEventListener('DOMContentLoaded', async () => {
        const [, cartResult] = await Promise.allSettled([
            loadDjangoCsrf(),
            loadCart(),
        ]);
        if (cartResult.status === 'rejected') {
            showError(cartResult.reason?.message || 'Could not load your cart. Please refresh.');
        }
    });

    async function loadDjangoCsrf() {
        try {
            const res = await fetch('/ecommerce/csrf-token/', {
                credentials: 'same-origin',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
            });
            if (!res.ok) return;
            const data      = await res.json();
            djangoCsrfToken = data.csrfToken ?? null;
        } catch (err) {
            console.warn('[loadDjangoCsrf] Non-fatal:', err.message);
        }
    }

    async function loadCart() {
        const res = await fetch('/proxy/cart', {
            credentials: 'same-origin',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
        });

        if (!res.ok) {
            throw new Error(`Could not load cart (HTTP ${res.status}). Please go back and try again.`);
        }

        const data = await res.json();
        hideLoading();

        if (!data.items || data.items.length === 0) {
            document.getElementById('cartEmpty').classList.remove('d-none');
            return;
        }

        cartData = data;
        if (data.id) sessionStorage.setItem('cart_id', String(data.id));

        renderSummary(data);
        document.getElementById('orderForm').classList.remove('d-none');
    }

    function renderSummary(data) {
        let html = '';
        data.items.forEach(item => {
            const unitPrice = Number(item.unit_price ?? item.price ?? 0);
            const lineTotal = (unitPrice * item.quantity).toLocaleString('en-KE', {
                minimumFractionDigits: 2, maximumFractionDigits: 2,
            });
            html += `
                <div class="summary-item">
                    <span>${escapeHtml(item.product_name ?? item.name ?? 'Item')}
                        <span class="text-muted">× ${item.quantity}</span>
                    </span>
                    <span class="fw-semibold">KES ${lineTotal}</span>
                </div>`;
        });
        document.getElementById('summaryContent').innerHTML = html;
        document.getElementById('summaryTotal').textContent = 'KES ' +
            Number(data.subtotal).toLocaleString('en-KE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    window.submitOrder = async function () {
        const nameInput  = document.getElementById('customerName');
        const phoneInput = document.getElementById('phoneNumber');
        const btn        = document.getElementById('submitBtn');

        const name  = nameInput.value.trim();
        const phone = phoneInput.value.trim();

        let hasError = false;
        [{ el: nameInput, val: name }, { el: phoneInput, val: phone }].forEach(({ el, val }) => {
            if (!val) { el.classList.add('is-invalid'); hasError = true; }
            else        el.classList.remove('is-invalid');
        });
        if (hasError) return;

        if (!cartData?.items?.length) {
            showError('Your cart appears to be empty. Please go back and add items.');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Placing order…';

        const payload = {
            cart_id:       String(cartData.id ?? sessionStorage.getItem('cart_id') ?? ''),
            customer_name: name,
            phone_number:  phone,
        };
        if (djangoCsrfToken) payload.django_csrf = djangoCsrfToken;

        try {
            const res = await fetch('/api/ecommerce/place-order/', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept':       'application/json',
                    'X-CSRF-TOKEN': CSRF,
                },
                body: JSON.stringify(payload),
            });

            const orderResponse = await res.json();
            console.log('[submitOrder] Order response:', orderResponse);

         
            const orderObj   = orderResponse.order ?? {};
            const orderNumber = orderObj.order_number ?? orderResponse.order_number ?? null;

            if (!res.ok || !orderNumber) {
                if (orderResponse.errors) {
                    const msgs = Object.entries(orderResponse.errors)
                        .map(([f, e]) => `${f}: ${[].concat(e).join(', ')}`)
                        .join(' | ');
                    throw new Error(msgs);
                }
                throw new Error(
                    orderResponse.message || orderResponse.detail || 'Order could not be placed. Please try again.'
                );
            }

            const waUrl = buildWhatsAppUrl({
                orderNumber,
                name:     orderResponse.customer?.name  ?? name,
                phone:    orderResponse.customer?.phone ?? phone,
                items:    orderResponse.items           ?? cartData.items,
                total:    orderObj.total                ?? orderObj.subtotal ?? cartData.subtotal,
            });

            openWhatsApp(waUrl);

        } catch (err) {
            console.error('[submitOrder]', err);
            showError(err.message);
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-whatsapp me-2"></i>Place Order via WhatsApp';
        }
    };

    function buildWhatsAppUrl({ orderNumber, name, phone, items, total }) {
        const fmt = (n) => Number(n).toLocaleString('en-KE', {
            minimumFractionDigits: 2, maximumFractionDigits: 2,
        });

        const itemLines = (items ?? []).map(item => {
            const unitPrice = Number(item.unit_price ?? item.price ?? 0);
            const qty       = item.quantity ?? item.qty ?? 1;
            return `• ${item.product_name ?? item.name ?? 'Item'} × ${qty} — KES ${fmt(unitPrice * qty)}`;
        }).join('\n');

        const message = [
            `Hello,`,
            ``,
            `I would like to place a new order with the following details:`,
            ``,
            `Order Reference: ${orderNumber}`,
            `Name: ${name}`,
            `Phone: +254${phone}`,
            ``,
            `Items Ordered:`,
            itemLines,
            ``,
            `Total Amount: KES ${fmt(total)}`,
            ``,
            `Kindly confirm receipt of this order.`,
            ``,
            `Thank you.`,
        ].join('\n');

        return `https://wa.me/${WHATSAPP_NUMBER}?text=${encodeURIComponent(message)}`;
    }

    function openWhatsApp(waUrl) {
        document.getElementById('waFallbackLink').href = waUrl;

        document.getElementById('redirectOverlay').style.display = 'flex';

        const isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
        if (isMobile) {
            window.location.href = waUrl;
        } else {
            window.open(waUrl, '_blank');
        }
    }

    function hideLoading() {
        document.getElementById('loadingCart').classList.add('d-none');
    }

    function showError(msg) {
        hideLoading();
        document.getElementById('orderForm').classList.add('d-none');
        document.getElementById('cartEmpty').classList.add('d-none');
        document.getElementById('cartErrorMsg').textContent = msg;
        document.getElementById('cartError').classList.remove('d-none');
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
                  .replace(/"/g,'&quot;').replace(/'/g,'&#39;');
    }

    ['customerName', 'phoneNumber'].forEach(id => {
        document.getElementById(id)?.addEventListener('input', function () {
            this.classList.remove('is-invalid');
        });
    });

})();
</script>

@endsection