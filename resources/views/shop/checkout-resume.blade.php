@extends('layouts.app')

@section('title', 'Complete Your Order')

@section('content')
<div class="container my-5">
    {{-- Header with WhatsApp status --}}
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success mb-4 d-flex align-items-center">
                <i class="bi bi-whatsapp fs-3 me-3"></i>
                <div>
                    <strong>WhatsApp Discussion Complete!</strong><br>
                    Please review your order details below and complete payment with M-Pesa.
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Order Summary --}}
        <div class="col-md-5 order-md-2 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-success text-white rounded-top-4 border-0 py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-bag-check me-2"></i>Order Summary
                    </h5>
                </div>
                <div class="card-body p-4">
                    <h6 class="mb-3 fw-bold">Items ({{ count($cartItems) }})</h6>
                    
                    @foreach($cartItems as $item)
                    <div class="d-flex justify-content-between mb-3 pb-2 border-bottom">
                        <div>
                            <span class="fw-medium">{{ $item['product_name'] }}</span>
                            <small class="text-muted d-block">Qty: {{ $item['quantity'] }}</small>
                        </div>
                        <span class="fw-semibold">KES {{ number_format($item['unit_price'] * $item['quantity'], 2) }}</span>
                    </div>
                    @endforeach
                    
                    <div class="d-flex justify-content-between mb-2 pt-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-semibold">KES {{ number_format($subtotal, 2) }}</span>
                    </div>
                    
                    @if(isset($deliveryInfo['delivery_charge']))
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Delivery Charge</span>
                        <span class="fw-semibold text-success">KES {{ number_format($deliveryInfo['delivery_charge'], 2) }}</span>
                    </div>
                    @endif
                    
                    <hr class="my-3">
                    
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span class="text-success">
                            KES {{ number_format(($subtotal + ($deliveryInfo['delivery_charge'] ?? 0)), 2) }}
                        </span>
                    </div>

                    @if(!empty($deliveryInfo))
                    <div class="mt-4 p-3 bg-light rounded-3">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-truck text-success me-2"></i>Delivery Details
                        </h6>
                        <p class="mb-1"><span class="text-muted">Address:</span> {{ $deliveryInfo['delivery_address'] ?? 'Not set' }}</p>
                        <p class="mb-1"><span class="text-muted">County:</span> {{ $deliveryInfo['county'] ?? 'Not set' }}</p>
                        <p class="mb-1"><span class="text-muted">Town:</span> {{ $deliveryInfo['town'] ?? 'Not set' }}</p>
                        <p class="mb-1"><span class="text-muted">Type:</span> {{ ucfirst(str_replace('_', ' ', $deliveryInfo['delivery_type'] ?? 'Not set')) }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        {{-- Checkout Form --}}
        <div class="col-md-7 order-md-1">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-success text-white rounded-top-4 border-0 py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-phone me-2"></i>Payment Details
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form id="checkoutForm">
                        @csrf
                        
                        <input type="hidden" name="temp_order_id" value="{{ $tempOrder->id }}">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" class="form-control bg-light" name="name" 
                                       value="{{ $tempOrder->customer_name }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone Number</label>
                                <input type="tel" class="form-control bg-light" name="phone" 
                                       value="{{ $tempOrder->customer_phone }}" readonly>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" class="form-control bg-light" name="email" 
                                   value="{{ $tempOrder->customer_email }}" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Delivery Address *</label>
                            <textarea class="form-control" name="address" rows="2" 
                                      required>{{ $deliveryInfo['delivery_address'] ?? $tempOrder->delivery_address ?? '' }}</textarea>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">County *</label>
                                <input type="text" class="form-control" name="county" 
                                       value="{{ $deliveryInfo['county'] ?? $tempOrder->county ?? '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Town *</label>
                                <input type="text" class="form-control" name="town" 
                                       value="{{ $deliveryInfo['town'] ?? $tempOrder->town ?? '' }}" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Delivery Type *</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="delivery_type" 
                                       value="farm_delivery" 
                                       {{ ($deliveryInfo['delivery_type'] ?? $tempOrder->delivery_type) == 'farm_delivery' ? 'checked' : '' }}
                                       required>
                                <label class="form-check-label">Farm Delivery</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="delivery_type" 
                                       value="pickup_station"
                                       {{ ($deliveryInfo['delivery_type'] ?? $tempOrder->delivery_type) == 'pickup_station' ? 'checked' : '' }}>
                                <label class="form-check-label">Pickup Station</label>
                            </div>
                        </div>
                        
                        {{-- M-Pesa Details --}}
                        <div class="mb-4 p-3 rounded-3" style="background-color: #f0f9f0;">
                            <label class="form-label fw-semibold text-success">
                                <i class="bi bi-phone me-2"></i>M-Pesa Phone Number *
                            </label>
                            <input type="tel" class="form-control form-control-lg" name="mpesa_number"
                                   placeholder="2547XXXXXXXX" value="{{ $tempOrder->customer_phone }}" required>
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                You'll receive an STK push prompt on this number.
                            </small>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg py-3">
                                <i class="bi bi-phone me-2"></i>Complete Payment with M-Pesa
                            </button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('cart.view') }}" class="text-muted">
                                <i class="bi bi-arrow-left me-1"></i>Back to Cart
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 20px !important;
    }
    .card-header {
        border-radius: 20px 20px 0 0 !important;
    }
    .btn-success {
        background: linear-gradient(135deg, #2a6e3f, #3a8e5c);
        border: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-success:hover {
        background: linear-gradient(135deg, #1e5a2f, #2a6e3f);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(42, 110, 63, 0.3);
    }
    .form-control:focus {
        border-color: #2a6e3f;
        box-shadow: 0 0 0 0.2rem rgba(42, 110, 63, 0.25);
    }
    .form-control-lg {
        border-radius: 12px;
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
@endpush

@push('scripts')
<script>
(function() {
    'use strict';
    
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    document.getElementById('checkoutForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const btn = this.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
        btn.disabled = true;
        
        try {
            const formData = new FormData(this);
            
            const response = await fetch('/api/checkout/complete', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
                alert.style.zIndex = '9999';
                alert.innerHTML = `
                    <i class="bi bi-check-circle me-2"></i>
                    Payment initiated! Redirecting...
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(alert);
                
                setTimeout(() => {
                    window.location.href = data.redirect_url;
                }, 2000);
            } else {
                alert(data.message || 'Checkout failed. Please try again.');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
            
        } catch (err) {
            console.error('[checkout]', err);
            alert('Network error during checkout. Please try again.');
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    });
    
})();
</script>
@endpush
@endsection