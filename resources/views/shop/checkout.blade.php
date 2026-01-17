@extends('layouts.app')

@section('title', 'Checkout - Premium Farming Feeds')

@section('content')
<div class="min-h-screen pt-24 bg-gray-50">
    <div class="container py-8">
        <div class="row">
            <div class="col-lg-8">
                <!-- Checkout Progress -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-center">
                                <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    1
                                </div>
                                <p class="mt-2 mb-0 small">Cart</p>
                            </div>
                            <div class="flex-grow-1 mx-3">
                                <div class="progress" style="height: 2px;">
                                    <div class="progress-bar bg-primary" style="width: 100%"></div>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    2
                                </div>
                                <p class="mt-2 mb-0 small">Delivery</p>
                            </div>
                            <div class="flex-grow-1 mx-3">
                                <div class="progress" style="height: 2px;">
                                    <div class="progress-bar" style="width: 0%"></div>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    3
                                </div>
                                <p class="mt-2 mb-0 small">Payment</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information Form -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h4 class="mb-0"><i class="bi bi-truck me-2"></i> Delivery Information</h4>
                    </div>
                    <div class="card-body">
                        <form id="checkoutForm" method="POST" action="{{ route('checkout.process') }}">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ auth()->user()->name ?? '' }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number *</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="{{ auth()->user()->email ?? '' }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="address" class="form-label">Delivery Address *</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required 
                                          placeholder="Farm name, location, nearest town, and directions"></textarea>
                                <small class="text-muted">Please provide detailed directions to your farm</small>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="county" class="form-label">County *</label>
                                    <select class="form-control" id="county" name="county" required>
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
                                <div class="col-md-6 mb-3">
                                    <label for="town" class="form-label">Town/Nearest Town *</label>
                                    <input type="text" class="form-control" id="town" name="town" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Delivery Instructions</label>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="delivery_type" id="delivery1" value="farm_delivery" checked>
                                    <label class="form-check-label" for="delivery1">
                                        <strong>Farm Delivery</strong> - We deliver directly to your farm (Ksh 500)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="delivery_type" id="delivery2" value="pickup_station">
                                    <label class="form-check-label" for="delivery2">
                                        <strong>Pickup Station</strong> - Collect from our nearest depot (Free)
                                    </label>
                                </div>
                            </div>

                            <!-- Payment Methods -->
                            <div class="mb-4">
                                <h5><i class="bi bi-credit-card me-2"></i> Payment Method *</h5>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="card payment-method-card">
                                            <div class="card-body text-center">
                                                <input class="form-check-input" type="radio" name="payment_method" id="mpesa" value="mpesa" checked>
                                                <label class="form-check-label" for="mpesa">
                                                    <i class="bi bi-phone text-success fs-1"></i>
                                                    <h6 class="mt-2">M-Pesa</h6>
                                                    <small class="text-muted">Pay via Lipa Na M-Pesa</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card payment-method-card">
                                            <div class="card-body text-center">
                                                <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash">
                                                <label class="form-check-label" for="cash">
                                                    <i class="bi bi-cash text-warning fs-1"></i>
                                                    <h6 class="mt-2">Cash on Delivery</h6>
                                                    <small class="text-muted">Pay when goods arrive</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card payment-method-card">
                                            <div class="card-body text-center">
                                                <input class="form-check-input" type="radio" name="payment_method" id="bank" value="bank">
                                                <label class="form-check-label" for="bank">
                                                    <i class="bi bi-bank text-primary fs-1"></i>
                                                    <h6 class="mt-2">Bank Transfer</h6>
                                                    <small class="text-muted">Direct bank payment</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- M-Pesa Details (Hidden by default) -->
                            <div id="mpesaDetails" class="mb-4 border p-3 rounded bg-light">
                                <h6><i class="bi bi-phone me-2"></i> M-Pesa Payment Instructions</h6>
                                <ol class="mb-3">
                                    <li>You will receive an M-Pesa prompt on your phone</li>
                                    <li>Enter your M-Pesa PIN to complete payment</li>
                                    <li>Payment confirmation will be sent via SMS</li>
                                    <li>wats up to confirm delivery charges</li>
                                </ol>
                                <div class="mb-3">
                                    <label for="mpesa_number" class="form-label">M-Pesa Phone Number *</label>
                                    <input type="tel" class="form-control" id="mpesa_number" name="mpesa_number" 
                                           placeholder="07XX XXX XXX">
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a>
                                </label>
                            </div>

                            <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                            <input type="hidden" name="shipping" value="{{ $shipping }}">
                            <input type="hidden" name="tax" value="{{ $tax }}">
                            <input type="hidden" name="total" value="{{ $total }}">

                            <button type="submit" class="btn btn-success btn-lg w-100">
                                <i class="bi bi-lock-fill me-2"></i>
                                Complete Order - Ksh {{ number_format($total) }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 100px;">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">Order Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6>Items in Cart ({{ count($cart) }})</h6>
                            <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                @foreach($cart as $item)
                                <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                    <div>
                                        <small class="d-block">{{ $item['name'] }}</small>
                                        <small class="text-muted">Qty: {{ $item['quantity'] }} × Ksh {{ number_format($item['price']) }}</small>
                                    </div>
                                    <small class="fw-bold">Ksh {{ number_format($item['price'] * $item['quantity']) }}</small>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span>Ksh {{ number_format($subtotal) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping</span>
                                <span id="shippingAmount">Ksh {{ number_format($shipping) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax (10% VAT)</span>
                                <span>Ksh {{ number_format($tax) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <h5>Total</h5>
                                <h5 id="totalAmount">Ksh {{ number_format($total) }}</h5>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <div class="d-flex">
                                <i class="bi bi-info-circle me-2"></i>
                                <small>Orders are typically delivered within 2-3 business days</small>
                            </div>
                        </div>

                        <a href="{{ route('cart.view') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-left me-2"></i>
                            Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Terms and Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>Delivery Terms</h6>
                <ul>
                    <li>Delivery within 2-3 business days for major towns</li>
                    <li>Remote areas may take 4-5 business days</li>
                    <li>watsup to confirm delivery charges</li>
                    <li>Delivery fees are non-refundable</li>
                </ul>
                
                <h6>Payment Terms</h6>
                <ul>
                    <li>M-Pesa payments must be confirmed within 15 minutes</li>
                    <li>Cash on delivery requires exact amount</li>
                    <li>Bank transfers must be confirmed before delivery</li>
                </ul>
                
                <h6>Returns & Refunds</h6>
                <ul>
                    <li>Damaged goods must be reported within 24 hours</li>
                    <li>Returns subject to inspection and approval</li>
                    <li>Refunds processed within 5-7 business days</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    .payment-method-card {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .payment-method-card:hover {
        border-color: #2a6e3f;
        transform: translateY(-2px);
    }
    
    .payment-method-card input[type="radio"]:checked + label .card {
        border-color: #2a6e3f;
        background-color: rgba(42, 110, 63, 0.05);
    }
    
    .sticky-top {
        position: sticky;
        z-index: 1;
    }
    
    .form-check-input:checked {
        background-color: #2a6e3f;
        border-color: #2a6e3f;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show/hide M-Pesa details based on payment method
    const mpesaDetails = document.getElementById('mpesaDetails');
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    
    function toggleMpesaDetails() {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
        if (selectedMethod === 'mpesa') {
            mpesaDetails.style.display = 'block';
            document.getElementById('mpesa_number').required = true;
        } else {
            mpesaDetails.style.display = 'none';
            document.getElementById('mpesa_number').required = false;
        }
    }
    
    paymentMethods.forEach(method => {
        method.addEventListener('change', toggleMpesaDetails);
    });
    
    // Update shipping amount based on delivery type
    const deliveryOptions = document.querySelectorAll('input[name="delivery_type"]');
    const shippingAmount = document.getElementById('shippingAmount');
    const totalAmount = document.getElementById('totalAmount');
    const baseTotal = {{ $subtotal + $tax }};
    const shippingFee = {{ $shipping }};
    
    function updateTotals() {
        const selectedDelivery = document.querySelector('input[name="delivery_type"]:checked').value;
        let shipping = 0;
        
        if (selectedDelivery === 'farm_delivery') {
            shipping = shippingFee;
        }
        
        const total = baseTotal + shipping;
        
        shippingAmount.textContent = 'Ksh ' + shipping.toLocaleString();
        totalAmount.textContent = 'Ksh ' + total.toLocaleString();
        
        // Update hidden form fields
        document.querySelector('input[name="shipping"]').value = shipping;
        document.querySelector('input[name="total"]').value = total;
    }
    
    deliveryOptions.forEach(option => {
        option.addEventListener('change', updateTotals);
    });
    
    // Initialize
    toggleMpesaDetails();
    updateTotals();
    
    // Form validation
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const phone = document.getElementById('phone').value;
        if (!phone.match(/^(07|01)\d{8}$/)) {
            e.preventDefault();
            alert('Please enter a valid Kenyan phone number (07XXXXXXXX or 01XXXXXXXX)');
            document.getElementById('phone').focus();
        }
    });
});
</script>
@endsection