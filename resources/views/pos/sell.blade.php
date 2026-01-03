@extends('layouts.pos')

@section('content')
@php 
$VAT_RATE = 16; 
$order_id = 'ORD' . time();

// ✅ HARDCODED PRODUCTS (Always available)
$hardcodedProducts = [
    ['id' => 1, 'name' => 'Chick Mash 50kg', 'selling_price' => 1700, 'stock' => 45, 'unit' => 'bag'],
    ['id' => 2, 'name' => 'Layers Mash 50kg', 'selling_price' => 1850, 'stock' => 3, 'unit' => 'bag'],
    ['id' => 3, 'name' => 'Pig Fattener 50kg', 'selling_price' => 2600, 'stock' => 120, 'unit' => 'bag'],
    ['id' => 4, 'name' => 'Dog Meal 25kg', 'selling_price' => 2200, 'stock' => 8, 'unit' => 'bag'],
    ['id' => 5, 'name' => 'Broiler Starter', 'selling_price' => 1950, 'stock' => 0, 'unit' => 'bag'],
    ['id' => 6, 'name' => 'Pig Grower 50kg', 'selling_price' => 2400, 'stock' => 67, 'unit' => 'bag'],
];

// ✅ DATABASE PRODUCTS (New ones you add)
$dbProducts = [];
try {
    $dbProducts = \App\Models\PosProduct::orderBy('name')->get()
        ->map(function($product) {
            return [
                'id' => 'db_' . $product->id,
                'name' => $product->name,
                'selling_price' => $product->selling_price,
                'stock' => $product->stock,
                'unit' => $product->unit ?? 'bag'
            ];
        })->toArray();
} catch (Exception $e) {
    // If no model/table, skip silently
}

// ✅ COMBINE BOTH - PRIORITY: DB first, then hardcoded
$products = collect(array_merge($dbProducts, $hardcodedProducts));
$lowStockProducts = $products->where('stock', '<=', 5)->values();
@endphp

@push('styles')
<style>
    .pos-sell-wrapper { 
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); 
        min-height: 100vh; 
        padding: 20px; 
    }
    .pos-sell-container { max-width: 1400px; margin: 0 auto; }
    .pos-sell-panel { 
        background: rgb(198, 191, 191); 
        border-radius: 16px; 
        padding: 25px; 
        box-shadow: 0 8px 32px rgba(0,0,0,0.1); 
        border: 1px solid #606b76; 
        margin-bottom: 25px; 
    }
    .pos-sell-content { display: flex; gap: 25px; }
    @media (max-width: 992px) { .pos-sell-content { flex-direction: column; } }
    .pos-sell-left-panel { flex: 1; }
    .pos-sell-right-panel { width: 400px; }
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; }
    .product-btn { 
        border: 2px solid #dee2e6; 
        border-radius: 12px; 
        padding: 20px; 
        text-align: center; 
        background: white; 
        cursor: pointer; 
        transition: all 0.3s; 
        height: 140px; 
        position: relative; 
        overflow: hidden; 
    }
    .product-btn:hover:not(.out-stock) { 
        border-color: #0d6efd; 
        box-shadow: 0 12px 30px rgba(0,0,0,0.15); 
        transform: translateY(-5px); 
    }
    .product-btn.low-stock { border-color: #ffc107; background: #fff3cd; }
    .product-btn.out-stock { border-color: #dc3545; background: #f8d7da; cursor: not-allowed; opacity: 0.6; }
    .stock-badge { 
        position: absolute; 
        top: 10px; 
        right: 10px; 
        padding: 6px 12px; 
        border-radius: 20px; 
        font-size: 11px; 
        font-weight: bold; 
        min-width: 50px; 
        text-align: center; 
    }
    .stock-ok { background: #d1e7dd; color: #0f5132; }
    .stock-low { background: #fff3cd; color: #664d03; animation: pulse-warning 2s infinite; }
    .stock-out { background: #777676; color: #58151c; }
    @keyframes pulse-warning { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }
    
    /* PERFECT ADD BUTTON */
    .btn-add-custom { 
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white !important; 
        border: none; 
        border-radius: 16px; 
        padding: 18px 24px;
        font-weight: 700; 
        font-size: 18px; 
        box-shadow: 0 8px 25px rgba(40,167,69,0.4);
        transition: all 0.3s ease; 
        position: relative; 
        overflow: hidden;
    }
    .btn-add-custom:hover:not(:disabled) { 
        background: linear-gradient(135deg, #218838 0%, #1ea085 100%);
        transform: translateY(-4px); 
        box-shadow: 0 15px 35px rgba(40,167,69,0.5);
    }
    .btn-add-custom:disabled { 
        background: #6c757d !important; 
        box-shadow: none; 
        cursor: not-allowed; 
        transform: none; 
    }
    .btn-add-custom.ready { animation: pulse-green 2s infinite; }
    @keyframes pulse-green { 
        0%, 100% { box-shadow: 0 8px 25px rgba(40,167,69,0.4); } 
        50% { box-shadow: 0 8px 35px rgba(40,167,69,0.6); } 
    }
    
    .payment-tabs-custom { display: flex; gap: 12px; margin-bottom: 20px; }
    .payment-tab-custom { 
        flex: 1; 
        padding: 15px; 
        border: 2px solid #3e3f40; 
        border-radius: 12px; 
        background: rgb(94, 91, 91); 
        cursor: pointer; 
        transition: all 0.3s; 
        font-weight: 600; 
        text-align: center; 
        color: white; 
    }
    .payment-tab-custom.active { 
        border-color: #28a745; 
        background: #606361; 
        transform: translateY(-2px); 
        box-shadow: 0 5px 15px rgba(40,167,69,0.2); 
    }
    .btn-mpesa-custom { 
        background: linear-gradient(135deg, #ff6b35, #f7931e) !important; 
        color: white !important; 
        border-radius: 16px; 
        font-weight: 700; 
    }
    .btn-cash-custom { 
        background: linear-gradient(135deg, #28a745, #20c997) !important; 
        color: white !important; 
        border-radius: 16px; 
        font-weight: 700; 
    }
    .total-section-custom { 
        background: linear-gradient(135deg, #198754, #157347); 
        color: white; 
        text-align: center; 
        border-radius: 20px; 
    }
    .mpesa-details-custom { 
        background: #656461; 
        border: 2px solid #3f3e3b; 
        border-radius: 12px; 
        padding: 15px; 
        margin: 15px 0; 
        font-size: 14px; 
        color: white; 
    }
    .receipt-btn-custom { 
        background: linear-gradient(135deg, #17a2b8, #138496) !important; 
        color: white !important; 
        border-radius: 16px; 
        font-weight: 700; 
    }
    .form-control-lg-custom { 
        border-radius: 12px; 
        border: 2px solid #5b5e60; 
        font-weight: 500; 
        padding: 12px 16px; 
    }
    .input-group-text-custom { 
        background: #676b6e; 
        border-radius: 12px 0 0 12px !important; 
        border: 2px solid #57595a; 
        color: white; 
    }
    
    /* ✅ FANCY GOLDEN TOTAL BOX */
    .grand-total-box-custom {
        background: linear-gradient(135deg, #d4af37 0%, #f7e1b5 50%, #e6c07a 100%) !important;
        backdrop-filter: blur(10px);
        border: 3px solid #b8942f !important;
        box-shadow: 0 15px 45px rgba(212, 175, 55, 0.4), inset 0 2px 10px rgba(255,255,255,0.6) !important;
        border-radius: 24px !important;
        padding: 28px !important;
        position: relative;
        overflow: hidden;
    }
    .grand-total-box-custom::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.4) 0%, transparent 70%);
        animation: shine 4s infinite;
    }
    @keyframes shine {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }
    .grand-total-box-custom .display-5 {
        color: #8B4513 !important;
        text-shadow: 0 3px 6px rgba(0,0,0,0.4) !important;
        font-weight: 900 !important;
    }
    .grand-total-box-custom .fs-6 {
        color: #654321 !important;
        font-weight: 700 !important;
        text-shadow: 0 1px 3px rgba(0,0,0,0.3) !important;
    }
</style>
@endpush

<div class="pos-sell-wrapper">
    <div class="pos-sell-container">
        <!-- HEADER -->
        <div class="pos-sell-panel">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h3 class="fw-bold text-primary mb-1">🐄 Premium Farm Feed POS</h3>
                    <p class="text-muted mb-0">Cash • M-Pesa 247247 • Fast Sales</p>
                </div>
                <div class="col-md-4 text-center">
                    <span class="badge bg-success fs-6 px-4 py-2 me-2">👤 {{ auth()->user()->name ?? 'Guest' }}</span>
                    <span class="badge bg-info fs-6 px-4 py-2">🧾 #{{ $order_id }}</span>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        ➕ Add Product
                    </button>
                    {{-- Fixed: Use url() instead of route() for now --}}
                    <button class="btn btn-outline-primary" onclick="showProductCount()">
                        📋 {{ $products->count() }} Products
                    </button>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="pos-sell-content">
            <!-- LEFT PANEL: Quick Sell + Products -->
            <div class="pos-sell-left-panel">
                <!-- QUICK SELL -->
                <div class="pos-sell-panel">
                    <h5 class="fw-bold mb-4"><i class="fas fa-bolt text-warning me-2"></i>Quick Sell</h5>
                    <form id="quickSellForm" action="{{ route('cart.add') }}" method="POST" class="row g-3 align-items-end">
                        @csrf
                        <div class="col-lg-3 col-md-12">
                            <label class="form-label fw-semibold">📦 Product</label>
                            <select name="product_id" id="productSelect" class="form-select form-control-lg-custom" required>
                                <option value="">Choose product...</option>
                                @foreach($products as $product)
                                <option value="{{ $product['id'] }}" 
                                    data-price="{{ $product['selling_price'] }}" 
                                    data-name="{{ $product['name'] }}" 
                                    data-stock="{{ $product['stock'] }}" 
                                    data-unit="{{ $product['unit'] }}">
                                    {{ $product['name'] }} • KSh {{ number_format($product['selling_price']) }} • {{ $product['stock'] }} {{ $product['unit'] }}{{ $product['stock'] != 1 ? 's' : '' }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label fw-semibold">📊 Stock</label>
                            <input type="text" id="stockDisplay" class="form-control form-control-lg-custom text-center bg-light" readonly>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label fw-semibold">📦 Qty</label>
                            <input name="quantity" id="quantityInput" type="number" class="form-control form-control-lg-custom text-center" value="1" min="1" max="999" required>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label fw-semibold">💰 Price</label>
                            <input name="price" id="priceInput" class="form-control form-control-lg-custom bg-success text-white text-center fw-bold fs-6" readonly required>
                            <input type="hidden" name="name" id="productName">
                            <input type="hidden" name="unit" id="productUnit">
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label fw-semibold">💵 Total</label>
                            <input id="totalDisplay" class="form-control form-control-lg-custom bg-info text-white text-center fw-bold fs-6" readonly>
                        </div>
                        <div class="col-lg-1 col-md-12">
                            <label class="form-label fw-semibold">&nbsp;</label>
                            <button type="submit" id="addBtn" class="btn btn-add-custom w-100 py-4 fs-5 fw-bold text-white" disabled>
                                <i class="fas fa-plus-circle me-2"></i>SELECT
                            </button>
                        </div>
                    </form>
                </div>

                <!-- FAST PRODUCTS -->
                <div class="pos-sell-panel">
                    <h5 class="fw-bold mb-4">⭐ Fast Products</h5>
                    <div class="product-grid">
                        @foreach($products as $product)
                        <div class="product-btn {{ $product['stock'] <= 5 && $product['stock'] > 0 ? 'low-stock' : '' }} {{ $product['stock'] == 0 ? 'out-stock' : '' }}" 
                            data-id="{{ $product['id'] }}" 
                            data-price="{{ $product['selling_price'] }}" 
                            data-name="{{ $product['name'] }}" 
                            data-stock="{{ $product['stock'] }}" 
                            data-unit="{{ $product['unit'] }}">
                            <div class="stock-badge {{ $product['stock'] > 5 ? 'stock-ok' : ($product['stock'] == 0 ? 'stock-out' : 'stock-low') }}">
                                {{ $product['stock'] }}<br><small>{{ strtoupper($product['unit']) }}</small>
                            </div>
                            <div class="fw-bold mt-4 mb-2" style="font-size: 14px;">{{ Str::limit($product['name'], 18) }}</div>
                            <div class="text-success fw-bold h6 mb-0">KSh {{ number_format($product['selling_price']) }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- RIGHT PANEL: Cart + Payment -->
            <div class="pos-sell-right-panel">
                @if($lowStockProducts->count() > 0)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    ⚠️ {{ $lowStockProducts->count() }} products low on stock!
                    <button class="btn btn-sm btn-warning ms-2" data-bs-toggle="modal" data-bs-target="#addProductModal">➕ Restock</button>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <!-- CART -->
                <div class="pos-sell-panel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold"><i class="fas fa-shopping-cart text-success me-2"></i>Shopping Cart</h5>
                        <span class="badge bg-primary fs-6 px-3 py-2">{{ count(session('cart', [])) }} items</span>
                    </div>
                    <div style="height: 300px; overflow-y: auto;">
                        @php $subtotal = 0; @endphp
                        @forelse(session('cart', []) as $item)
                        @php 
                            $lineTotal = ($item['price'] ?? 0) * ($item['quantity'] ?? 1); 
                            $subtotal += $lineTotal; 
                        @endphp
                        <div class="p-3 mb-3 rounded-3 border-start border-4 border-success bg-light position-relative">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <div class="fw-bold">{{ $item['name'] ?? 'Item' }}</div>
                                    <small class="text-muted">{{ $item['quantity'] ?? 1 }} × {{ strtoupper($item['unit'] ?? 'UNIT') }}</small>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="fw-bold fs-5 text-success">KSh {{ number_format($lineTotal) }}</div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-shopping-cart fa-4x mb-3 opacity-50"></i>
                            <h6 class="text-muted">Cart is empty</h6>
                            <small>Add products to get started!</small>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- TOTAL & PAYMENT -->
                @php 
                $discount = session('discount', 0);
                $vat = round((($subtotal - $discount) * $VAT_RATE / 100));
                $grandTotal = ($subtotal - $discount) + $vat;
                @endphp
                <div class="pos-sell-panel total-section-custom text-white p-4">
                    <div class="row text-center g-3 mb-4">
                        <div class="col-6"><small>SUBTOTAL</small></div>
                        <div class="col-6"><div class="fs-6 fw-bold">KSh {{ number_format($subtotal) }}</div></div>
                        <div class="col-6"><small>DISCOUNT</small></div>
                        <div class="col-6"><div class="fs-6 fw-bold">-KSh {{ number_format($discount) }}</div></div>
                        <div class="col-6"><small>VAT ({{ $VAT_RATE }}%)</small></div>
                        <div class="col-6"><div class="fs-6 fw-bold">KSh {{ number_format($vat) }}</div></div>
                    </div>

                    <!-- ✅ FANCY GOLDEN TOTAL BOX -->
                    <div class="p-4 grand-total-box-custom rounded-4 mb-4">
                        <div class="display-5 fw-bold mb-1">KSh {{ number_format($grandTotal) }}</div>
                        <div class="fs-6 opacity-90 fw-semibold">TOTAL TO PAY</div>
                    </div>

                    <!-- PAYMENT TABS -->
                    <div class="payment-tabs-custom">
                        <div class="payment-tab-custom active" data-payment="cash">
                            <i class="fas fa-money-bill-wave fs-5 me-2"></i>
                            <div>CASH</div>
                        </div>
                        <div class="payment-tab-custom" data-payment="mpesa">
                            <i class="fas fa-mobile-alt fs-5 me-2"></i>
                            <div>M-PESA</div>
                        </div>
                    </div>

                    <!-- CASH PAYMENT -->
                    <form id="cashForm" action="{{ route('cart.complete') }}" method="POST" class="payment-form">
                        @csrf
                        <input type="hidden" name="payment_method" value="cash">
                        <input type="hidden" name="vat" value="{{ $vat }}">
                        <input type="hidden" name="discount" value="{{ $discount }}">
                        <input type="hidden" name="order_id" value="{{ $order_id }}">
                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text input-group-text-custom"><i class="fas fa-money-bill-wave fs-5"></i></span>
                                <input type="number" name="amount_paid" class="form-control form-control-lg-custom fw-bold text-center fs-5" 
                                    placeholder="Cash Amount" step="50" min="{{ $grandTotal }}" required>
                                <span class="input-group-text input-group-text-custom">KSh</span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-cash-custom w-100 py-4 fs-5 fw-bold mb-3">
                            <i class="fas fa-check-circle me-2"></i>✅ COMPLETE CASH SALE
                        </button>
                    </form>

                    <!-- M-PESA PAYMENT -->
                    <form id="mpesaForm" action="{{ route('cart.mpesa') }}" method="POST" class="payment-form" style="display: none;">
                        @csrf
                        <input type="hidden" name="payment_method" value="mpesa">
                        <input type="hidden" name="amount" value="{{ $grandTotal }}">
                        <input type="hidden" name="vat" value="{{ $vat }}">
                        <input type="hidden" name="discount" value="{{ $discount }}">
                        <input type="hidden" name="order_id" value="{{ $order_id }}">
                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text input-group-text-custom"><i class="fas fa-phone fs-5 me-1"></i></span>
                                <input type="tel" name="phone" class="form-control form-control-lg-custom fw-bold text-center fs-5" 
                                    placeholder="07XXXXXXXX" pattern="07[0-9]{8}" required maxlength="10">
                                <span class="input-group-text input-group-text-custom"><i class="fas fa-mobile-alt fs-5"></i></span>
                            </div>
                        </div>
                        <div class="mpesa-details-custom">
                            <div class="fw-bold text-light mb-2 fs-6">📱 M-Pesa Instructions:</div>
                            <div class="row text-center">
                                <div class="col-6">
                                    <i class="fas fa-building text-warning me-1"></i>
                                    <strong>Paybill:</strong><br><span class="fs-6">247247</span>
                                </div>
                                <div class="col-6">
                                    <i class="fas fa-hashtag text-info me-1"></i>
                                    <strong>Account:</strong><br><span class="fs-6">470470</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <i class="fas fa-tag text-primary me-1"></i>
                                <strong>Amount:</strong> KSh {{ number_format($grandTotal) }} | Order #{{ $order_id }}
                            </div>
                        </div>
                        <button type="submit" class="btn btn-mpesa-custom w-100 py-4 fs-5 fw-bold">
                            <i class="fas fa-university me-2"></i>📱 PAY VIA M-PESA
                        </button>
                        <div class="alert alert-info mt-3 small">
                            Customer: M-Pesa → Lipa na M-Pesa → Pay Bill → 247247 → 470470 → Amount → PIN
                        </div>
                    </form>

                    <!-- ACTION BUTTONS -->
                    <div class="row g-2 mt-4">
                        <div class="col-6">
                            <form action="{{ route('cart.hold') }}" method="POST" style="display: contents;">@csrf
                                <button class="btn btn-warning w-100 py-3 fs-6 fw-bold">⏸️ Hold Sale</button>
                            </form>
                        </div>
                        <div class="col-6">
                            <form action="{{ route('cart.clear') }}" method="POST" style="display: contents;">@csrf
                                <button class="btn btn-secondary w-100 py-3 fs-6 fw-bold">🗑️ Clear Cart</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- SAFE RECEIPT BUTTON -->
                @if(isset(session('receipt')['order_id']))
                <div class="pos-sell-panel text-center">
                    <a href="{{ route('receipt.print', ['order_id' => session('receipt.order_id')]) }}" 
                        class="btn btn-info w-100 py-4 fs-5 fw-bold receipt-btn-custom" target="_blank">
                        <i class="fas fa-print me-2"></i>🧾 PRINT RECEIPT #{{ session('receipt.order_id') }}
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- ADD PRODUCT MODAL -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">➕ Add New Product</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pos.products') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Product Name *</label>
                            <input type="text" name="name" class="form-control form-control-lg-custom" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Category *</label>
                            <select name="category" class="form-select form-control-lg-custom" required>
                                <option value="poultry">🐔 Poultry</option>
                                <option value="pig">🐷 Pig</option>
                                <option value="pet">🐶 Pet</option>
                                <option value="byproduct">🌾 By-Product</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Selling Price (KSh) *</label>
                            <input type="number" name="selling_price" class="form-control form-control-lg-custom" min="0" step="10" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Buying Price (KSh)</label>
                            <input type="number" name="buying_price" class="form-control form-control-lg-custom" min="0" step="10">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Stock Qty *</label>
                            <input type="number" name="stock" class="form-control form-control-lg-custom" min="0" value="50" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Unit</label>
                            <select name="unit" class="form-select form-control-lg-custom">
                                <option value="bag">Bag</option>
                                <option value="kg">KG</option>
                                <option value="ltr">Litre</option>
                                <option value="pc">Piece</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Low Stock Alert</label>
                            <input type="number" name="low_stock_warning" class="form-control form-control-lg-custom" value="5" min="1">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">💾 Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function showProductCount() {
    alert('There are {{ $products->count() }} products available in the system.');
}

document.addEventListener('DOMContentLoaded', function() {
    // Quick Sell Logic
    const productSelect = document.getElementById('productSelect');
    const priceInput = document.getElementById('priceInput');
    const stockDisplay = document.getElementById('stockDisplay');
    const quantityInput = document.getElementById('quantityInput');
    const totalDisplay = document.getElementById('totalDisplay');
    const productName = document.getElementById('productName');
    const productUnit = document.getElementById('productUnit');
    const addBtn = document.getElementById('addBtn');

    function formatNumber(num) { return num.toLocaleString(); }

    // Product selection change
    productSelect.addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        if (option.value) {
            const stock = parseInt(option.dataset.stock) || 0;
            const price = parseFloat(option.dataset.price) || 0;
            const qty = parseInt(quantityInput.value) || 1;
            
            priceInput.value = price;
            productName.value = option.dataset.name;
            productUnit.value = option.dataset.unit;
            stockDisplay.value = `${stock} ${option.dataset.unit?.toUpperCase()}`;
            quantityInput.max = stock || 1;
            updateTotal(price, qty);

            if (stock === 0) {
                addBtn.disabled = true;
                addBtn.innerHTML = '<i class="fas fa-times-circle me-2"></i>OUT';
                addBtn.classList.remove('ready');
            } else {
                addBtn.disabled = false;
                addBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>➕ ADD';
                addBtn.classList.add('ready');
            }
        } else {
            resetForm();
        }
    });

    function updateTotal(price, qty) {
        totalDisplay.value = `KSh ${formatNumber(price * qty)}`;
    }

    function resetForm() {
        priceInput.value = '';
        stockDisplay.value = '';
        totalDisplay.value = '';
        productName.value = '';
        productUnit.value = '';
        quantityInput.value = 1;
        quantityInput.max = 999;
        addBtn.disabled = true;
        addBtn.innerHTML = '<i class="fas fa-plus-circle me-2"></i>SELECT';
        addBtn.classList.remove('ready');
    }

    // Quantity change
    quantityInput.addEventListener('input', function() {
        const option = productSelect.options[productSelect.selectedIndex];
        if (option && option.value) {
            const stock = parseInt(option.dataset.stock);
            const price = parseFloat(option.dataset.price);
            let qty = parseInt(this.value) || 1;
            
            if (qty > stock && stock > 0) {
                this.value = stock;
                qty = stock;
            }
            updateTotal(price, qty);
        }
    });

    // Product buttons (click to add)
    document.querySelectorAll('.product-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (this.classList.contains('out-stock')) {
                e.preventDefault();
                return alert('❌ Out of stock!');
            }
            
            productSelect.value = this.dataset.id;
            productSelect.dispatchEvent(new Event('change'));
            quantityInput.value = 1;
            
            // Auto-submit after 500ms
            setTimeout(() => {
                document.getElementById('quickSellForm').submit();
            }, 500);
        });
    });

    // Payment tabs
    const paymentTabs = document.querySelectorAll('.payment-tab-custom');
    const paymentForms = document.querySelectorAll('.payment-form');
    
    paymentTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const method = this.dataset.payment;
            
            // Update active tab
            paymentTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Toggle forms
            paymentForms.forEach((form, index) => {
                if (method === 'cash' && index === 0) {
                    form.style.display = 'block';
                } else if (method === 'mpesa' && index === 1) {
                    form.style.display = 'block';
                } else {
                    form.style.display = 'none';
                }
            });
        });
    });

    // Phone number formatting
    const phoneInput = document.querySelector('input[name="phone"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.startsWith('07') && value.length <= 10) {
                this.setCustomValidity('');
            } else {
                this.setCustomValidity('Please enter valid Kenyan phone number (07XXXXXXXX)');
            }
        });
    }
});
</script>
@endpush
@endsection