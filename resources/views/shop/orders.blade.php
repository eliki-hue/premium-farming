@extends('layouts.app')

@section('title', 'My Orders | Premium Farming Feeds')

@section('content')

<div id="mpesaBanner" class="mpesa-banner d-none">
    <div class="container">
        <div class="mpesa-banner-inner">
            <div class="mpesa-icon">
                <div class="mpesa-pulse"></div>
                <i class="bi bi-phone-fill"></i>
            </div>
            <div class="mpesa-text">
                <strong>Check your phone!</strong>
                <span>An M-Pesa STK push has been sent. Enter your PIN to complete payment.</span>
            </div>
            <div class="mpesa-status" id="mpesaStatusText">
                <div class="spinner-border spinner-border-sm text-success me-2"></div>
                Waiting for payment…
            </div>
        </div>
        <div class="mpesa-progress">
            <div id="mpesaProgressBar" class="mpesa-progress-bar"></div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     PAGE HEADER
══════════════════════════════════════════════════════════ --}}
<div class="page-header">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h2 class="page-title mb-1">
                    <i class="bi bi-receipt me-2"></i>My Orders
                </h2>
                <p class="page-subtitle mb-0">
                    Track and manage your purchases
                    @if(session('django_user.username'))
                        — <span class="text-success fw-semibold">{{ session('django_user.username') }}</span>
                    @endif
                </p>
            </div>
            <a href="{{ route('products') }}" class="btn btn-outline-success">
                <i class="bi bi-bag-plus me-2"></i>Continue Shopping
            </a>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     PAYMENT ALERTS
══════════════════════════════════════════════════════════ --}}
<div id="paymentSuccessAlert" class="container mt-4 d-none">
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-3" role="alert">
        <i class="bi bi-check-circle-fill fs-4"></i>
        <div>
            <strong>Payment confirmed!</strong> Your order has been placed successfully.
            Your items will be delivered as scheduled.
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
</div>

<div id="paymentFailedAlert" class="container mt-4 d-none">
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-3" role="alert">
        <i class="bi bi-x-circle-fill fs-4"></i>
        <div>
            <strong>Payment not confirmed.</strong>
            The M-Pesa request may have timed out or was cancelled.
        </div>
        <a href="{{ route('cart.view') }}" class="btn btn-sm btn-danger ms-3">Back to Cart</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     ORDERS LIST
══════════════════════════════════════════════════════════ --}}
<div class="container my-4">

    {{-- Loading --}}
    <div id="ordersLoading" class="text-center py-5">
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Loading…</span>
        </div>
        <p class="text-muted mt-3">Loading your orders…</p>
    </div>

    {{-- Error --}}
    <div id="ordersError" class="d-none text-center py-5">
        <i class="bi bi-exclamation-circle display-4 text-muted d-block mb-3"></i>
        <h5 class="text-muted">Could not load orders</h5>
        <p class="text-muted mb-4">There was a problem fetching your orders.</p>
        <button onclick="loadOrders()" class="btn btn-outline-success">
            <i class="bi bi-arrow-clockwise me-2"></i>Try Again
        </button>
    </div>

    {{-- Guest (not logged in) --}}
    <div id="ordersGuest" class="d-none text-center py-5">
        <i class="bi bi-lock display-4 text-muted d-block mb-3"></i>
        <h5 class="text-muted">Please log in to view your orders</h5>
        <a href="{{ route('login') }}" class="btn btn-success mt-3 px-4">
            <i class="bi bi-box-arrow-in-right me-2"></i>Login
        </a>
    </div>

    {{-- Empty --}}
    <div id="ordersEmpty" class="d-none text-center py-5">
        <i class="bi bi-bag-x display-4 text-muted d-block mb-3"></i>
        <h5 class="text-muted">No orders yet</h5>
        <p class="text-muted mb-4">Start shopping and your orders will appear here.</p>
        <a href="{{ route('products') }}" class="btn btn-success px-4">
            <i class="bi bi-bag me-2"></i>Shop Now
        </a>
    </div>

    {{-- Orders container — filled by JS --}}
    <div id="ordersContainer" class="d-none"></div>

</div>

{{-- ══════════════════════════════════════════════════════════
     ORDER DETAIL MODAL
     Fetches GET /proxy/orders/{id}/ (numeric Django PK)
     Django returns: { order_number, customer, branch, status,
                       total, created_at,
                       items: [{ product, quantity, unit_price, subtotal }] }
══════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="orderDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0" style="background:#f8fdf9;">
                <h5 class="modal-title fw-bold" style="color:#2a6e3f;">
                    <i class="bi bi-receipt me-2"></i>
                    Order <span id="modalOrderNumber"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalOrderBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-success"></div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('products') }}" class="btn btn-success">
                    <i class="bi bi-bag-plus me-2"></i>Shop More
                </a>
            </div>
        </div>
    </div>
</div>


<style>
    .page-header {
        background: linear-gradient(135deg, #f8fdf9 0%, #e8f5e9 100%);
        border-bottom: 2px solid #e0f2e9;
        padding: 2rem 0;
        margin-top: 76px;
    }
    .page-title   { font-size: 1.8rem; font-weight: 800; color: #1a4d2e; }
    .page-subtitle { color: #6b7280; font-size: 0.95rem; }

    /* ── M-Pesa Banner ── */
    .mpesa-banner {
        background: linear-gradient(135deg, #1a4d2e, #2a6e3f);
        color: white;
        padding: 1rem 0 0;
        position: sticky;
        top: 76px;
        z-index: 100;
        box-shadow: 0 4px 20px rgba(42,110,63,0.3);
    }
    .mpesa-banner-inner {
        display: flex; align-items: center; gap: 1.5rem;
        padding-bottom: 0.75rem; flex-wrap: wrap;
    }
    .mpesa-icon { position: relative; width: 48px; height: 48px; flex-shrink: 0; }
    .mpesa-icon i { font-size: 1.8rem; position: relative; z-index: 2; }
    .mpesa-pulse {
        position: absolute; inset: -8px; border-radius: 50%;
        background: rgba(255,255,255,0.2);
        animation: pulse 1.5s ease-in-out infinite;
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50%       { transform: scale(1.3); opacity: 0.2; }
    }
    .mpesa-text { flex: 1; }
    .mpesa-text strong { display: block; font-size: 1rem; font-weight: 700; }
    .mpesa-text span   { font-size: 0.85rem; opacity: 0.85; }
    .mpesa-status {
        display: flex; align-items: center;
        font-size: 0.85rem; font-weight: 600; white-space: nowrap;
    }
    .mpesa-progress     { height: 4px; background: rgba(255,255,255,0.2); }
    .mpesa-progress-bar { height: 100%; background: #4caf50; width: 0%; transition: width 0.5s ease; }

    /* ── Order Cards ── */
    .order-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e8f5e9;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        overflow: hidden;
        margin-bottom: 1.25rem;
    }
    .order-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(42,110,63,0.12);
    }
    .order-card-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1.25rem 1.5rem;
        background: #f8fdf9; border-bottom: 1px solid #e8f5e9;
        flex-wrap: wrap; gap: 0.75rem;
    }
    .order-number {
        font-weight: 800; color: #1a4d2e; font-size: 1rem;
        font-family: 'Courier New', monospace; letter-spacing: 0.5px;
    }
    .order-date { color: #6b7280; font-size: 0.82rem; }
    .order-card-body {
        padding: 1.25rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 1rem;
    }
    .order-meta        { display: flex; gap: 2rem; flex-wrap: wrap; }
    .order-meta-item   { display: flex; flex-direction: column; }
    .order-meta-label  { font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.8px; color: #9ca3af; font-weight: 600; margin-bottom: 2px; }
    .order-meta-value  { font-size: 0.95rem; font-weight: 600; color: #1a1a1a; }
    .order-total       { font-size: 1.3rem; font-weight: 800; color: #2a6e3f; }

    
    .status-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 12px; border-radius: 20px;
        font-size: 0.78rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .status-paid       { background: #d1e7dd; color: #0a3622; }   
    .status-pending    { background: #fff3cd; color: #856404; }
    .status-processing { background: #cff4fc; color: #055160; }
    .status-completed  { background: #d1e7dd; color: #0a3622; }
    .status-delivered  { background: #d1e7dd; color: #0a3622; }
    .status-cancelled  { background: #f8d7da; color: #842029; }
    .status-failed     { background: #f8d7da; color: #842029; }

    /* ── Modal Items Table ── */
    .items-table th {
        background: #f8fdf9; color: #2a6e3f;
        font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;
        font-weight: 700; border-bottom: 2px solid #e8f5e9;
    }
    .items-table td { vertical-align: middle; font-size: 0.9rem; border-color: #f0f9f1; }
    .order-summary-row { background: #f8fdf9; font-weight: 700; color: #1a4d2e; }

    /* ── Buttons ── */
    .btn-success {
        background: linear-gradient(135deg, #2a6e3f, #3a8e5c);
        border: none; font-weight: 600; border-radius: 8px;
    }
    .btn-success:hover {
        background: linear-gradient(135deg, #1e5a2f, #2a6e3f);
        transform: translateY(-1px);
    }
    .btn-outline-success {
        border-color: #2a6e3f; color: #2a6e3f;
        font-weight: 600; border-radius: 8px;
    }
    .btn-outline-success:hover { background: #2a6e3f; color: white; }
    .btn-view-order { font-size: 0.85rem; padding: 6px 16px; }

    @media (max-width: 768px) {
        .page-header { margin-top: 56px; }
        .mpesa-banner { top: 56px; }
        .order-meta { gap: 1rem; }
        .order-card-header { flex-direction: column; align-items: flex-start; }
    }
</style>

<script>
(function () {
    'use strict';

    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

   
    const urlParams     = new URLSearchParams(window.location.search);
    const checkoutReqId = urlParams.get('checkout_request_id');
    let   pollInterval  = null;
    let   pollCount     = 0;
    const MAX_POLLS     = 22; // 22 × 4s ≈ 90s (Safaricom STK timeout)

    if (checkoutReqId) {
        startPaymentPolling(checkoutReqId);
    }

    function startPaymentPolling(reqId) {
        document.getElementById('mpesaBanner').classList.remove('d-none');

        pollInterval = setInterval(async () => {
            pollCount++;
            const pct = Math.min((pollCount / MAX_POLLS) * 100, 100);
            document.getElementById('mpesaProgressBar').style.width = pct + '%';

            try {
                const res  = await fetch(`/proxy/checkout/status/${reqId}`, {
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
                    credentials: 'same-origin',
                });
                const data = await res.json();

                // Django returns "Paid" (capital P) for confirmed payment
                const s = (data.status ?? '').toLowerCase();

                if (s === 'paid' || s === 'completed') {
                    stopPolling();
                    onPaymentSuccess();
                    return;
                }
                if (s === 'failed' || s === 'cancelled') {
                    stopPolling();
                    onPaymentFailed();
                    return;
                }

            } catch (err) {
                console.warn('[poll]', err);
            }

            if (pollCount >= MAX_POLLS) {
                stopPolling();
                onPaymentFailed();
            }
        }, 4000);
    }

    function stopPolling() {
        clearInterval(pollInterval);
        document.getElementById('mpesaBanner').classList.add('d-none');
        window.history.replaceState({}, '', '/orders');
    }

    function onPaymentSuccess() {
        document.getElementById('paymentSuccessAlert').classList.remove('d-none');
        loadOrders();
    }

    function onPaymentFailed() {
        document.getElementById('paymentFailedAlert').classList.remove('d-none');
    }

 
    window.loadOrders = async function () {
        show('ordersLoading');

        try {
            const res = await fetch('/proxy/orders', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
                credentials: 'same-origin',
            });

            if (res.status === 401) { show('ordersGuest'); return; }
            if (!res.ok)            { show('ordersError'); return; }

            const data   = await res.json();
            const orders = Array.isArray(data) ? data : (data.results ?? []);

            if (orders.length === 0) { show('ordersEmpty'); return; }

            renderOrders(orders);

        } catch (err) {
            console.error('[loadOrders]', err);
            show('ordersError');
        }
    };

    /* ═══════════════════════════════════════════════════════════
       RENDER ORDER CARDS
       Uses order.id (numeric Django PK) for the detail button.
       Shows order.order_number as the display label.
    ═══════════════════════════════════════════════════════════ */
    function renderOrders(orders) {
        const container = document.getElementById('ordersContainer');

        container.innerHTML = orders.map(order => `
            <div class="order-card">
                <div class="order-card-header">
                    <div>
                        <div class="order-number">${order.order_number}</div>
                        <div class="order-date">
                            <i class="bi bi-calendar3 me-1"></i>
                            ${formatDate(order.created_at)}
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        ${statusBadge(order.status)}
                        <button
                            class="btn btn-outline-success btn-view-order"
                            onclick="viewOrderDetail(${order.id}, '${order.order_number}')">
                            <i class="bi bi-eye me-1"></i>View Items
                        </button>
                    </div>
                </div>
                <div class="order-card-body">
                    <div class="order-meta">
                        <div class="order-meta-item">
                            <span class="order-meta-label">Customer</span>
                            <span class="order-meta-value">${order.customer ?? '—'}</span>
                        </div>
                        <div class="order-meta-item">
                            <span class="order-meta-label">Branch</span>
                            <span class="order-meta-value">${order.branch ?? 'Main Branch'}</span>
                        </div>
                    </div>
                    <div class="order-total">
                        KES ${Number(order.total).toLocaleString('en-KE', {minimumFractionDigits: 2})}
                    </div>
                </div>
            </div>
        `).join('');

        show('ordersContainer');
    }

    window.viewOrderDetail = async function (orderId, orderNumber) {
        document.getElementById('modalOrderNumber').textContent = orderNumber;
        document.getElementById('modalOrderBody').innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-success"></div>
                <p class="text-muted mt-2 mb-0">Loading items…</p>
            </div>`;

        const modal = new bootstrap.Modal(document.getElementById('orderDetailModal'));
        modal.show();

        try {
            const res   = await fetch(`/proxy/orders/${orderId}`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
                credentials: 'same-origin',
            });
            const order = await res.json();
            document.getElementById('modalOrderBody').innerHTML = renderOrderDetail(order);

        } catch (err) {
            console.error('[viewOrderDetail]', err);
            document.getElementById('modalOrderBody').innerHTML = `
                <div class="alert alert-danger">Could not load order details. Please try again.</div>`;
        }
    };

    function renderOrderDetail(order) {
        const items = order.items ?? [];

        const rows = items.length
            ? items.map(item => `
                <tr>
                    {{-- product is a plain string e.g. "cow salt (0013)" --}}
                    <td>${item.product ?? '—'}</td>
                    <td class="text-center fw-semibold">${item.quantity}</td>
                    <td class="text-end">
                        KES ${Number(item.unit_price).toLocaleString('en-KE', {minimumFractionDigits: 2})}
                    </td>
                    <td class="text-end fw-semibold">
                        KES ${Number(item.subtotal).toLocaleString('en-KE', {minimumFractionDigits: 2})}
                    </td>
                </tr>`).join('')
            : `<tr><td colspan="4" class="text-center text-muted py-3">No items found.</td></tr>`;

        return `
            <div class="mb-4">
                {{-- Order summary header --}}
                <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3"
                     style="background:#f8fdf9; padding:1rem; border-radius:10px;">
                    <div>
                        <div class="order-meta-label">Customer</div>
                        <div class="fw-semibold">${order.name ?? '—'}</div>
                    </div>
                    <div>
                        <div class="order-meta-label">Branch</div>
                        <div class="fw-semibold">${order.branch ?? 'Main Branch'}</div>
                    </div>
                    <div>
                        <div class="order-meta-label">Placed on</div>
                        <div class="fw-semibold">${formatDate(order.created_at)}</div>
                    </div>
                    <div>
                        <div class="order-meta-label">Status</div>
                        <div>${statusBadge(order.status)}</div>
                    </div>
                </div>

                {{-- Items table --}}
                <table class="table items-table mb-0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>${rows}</tbody>
                    <tfoot>
                        <tr class="order-summary-row">
                            <td colspan="3" class="text-end">Order Total</td>
                            <td class="text-end" style="color:#2a6e3f; font-size:1.1rem;">
                                KES ${Number(order.total).toLocaleString('en-KE', {minimumFractionDigits: 2})}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>`;
    }


    function show(id) {
        ['ordersLoading','ordersError','ordersGuest','ordersEmpty','ordersContainer']
            .forEach(i => document.getElementById(i)?.classList.add('d-none'));
        document.getElementById(id)?.classList.remove('d-none');
    }

    function formatDate(dateStr) {
        if (!dateStr) return '—';
        return new Date(dateStr).toLocaleDateString('en-KE', {
            day: 'numeric', month: 'short', year: 'numeric',
            hour: '2-digit', minute: '2-digit',
        });
    }

   
    function statusBadge(status) {
        const s = (status ?? 'pending').toLowerCase();
        const icons = {
            paid:       'bi-check-circle-fill',
            pending:    'bi-clock',
            processing: 'bi-gear',
            completed:  'bi-check-circle',
            delivered:  'bi-truck',
            cancelled:  'bi-x-circle',
            failed:     'bi-x-circle',
        };
        const icon = icons[s] ?? 'bi-circle';
        return `<span class="status-badge status-${s}">
                    <i class="bi ${icon}"></i>${status ?? 'Pending'}
                </span>`;
    }

    document.addEventListener('DOMContentLoaded', loadOrders);

})();
</script>

@endsection