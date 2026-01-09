{{-- resources/views/checkout/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Checkout - Complete Your Order')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user me-2"></i>Customer Information</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('checkout.place.order') }}" id="checkout-form" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Personal Details Section -->
                        <h5 class="mb-3 text-primary"><i class="fas fa-id-card me-2"></i>Personal Details</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" 
                                           class="form-control @error('customer_name') is-invalid @enderror" 
                                           id="customer_name" 
                                           name="customer_name" 
                                           value="{{ old('customer_name', Auth::user()->name ?? '') }}"
                                           required
                                           placeholder="Enter your full name">
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="customer_email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" 
                                           class="form-control @error('customer_email') is-invalid @enderror" 
                                           id="customer_email" 
                                           name="customer_email" 
                                           value="{{ old('customer_email', Auth::user()->email ?? '') }}"
                                           required
                                           placeholder="your.email@example.com">
                                    @error('customer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="customer_phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="tel" 
                                           class="form-control @error('customer_phone') is-invalid @enderror" 
                                           id="customer_phone" 
                                           name="customer_phone" 
                                           value="{{ old('customer_phone', Auth::user()->phone ?? '') }}"
                                           required
                                           placeholder="0712 345 678">
                                    @error('customer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">We'll use this to contact you about your order</small>
                            </div>
                        </div>

                        <!-- Payment Method Section -->
                        <h5 class="mb-3 text-primary"><i class="fas fa-credit-card me-2"></i>Payment Method</h5>
                        <div class="card border-primary mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Choose how you want to pay <span class="text-danger">*</span></h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- M-Pesa Option -->
                                    <div class="col-md-4">
                                        <div class="form-check payment-method-card">
                                            <input class="form-check-input" type="radio" name="payment_method" id="mpesa" value="mpesa" checked>
                                            <label class="form-check-label w-100" for="mpesa">
                                                <div class="card h-100 border-2 payment-card">
                                                    <div class="card-body text-center">
                                                        <div class="payment-icon mb-3">
                                                            <i class="fas fa-mobile-alt fa-3x text-success"></i>
                                                        </div>
                                                        <h6 class="card-title">M-Pesa</h6>
                                                        <p class="card-text small text-muted">Pay via M-Pesa PayBill</p>
                                                        <div class="mt-2">
                                                            <span class="badge bg-success">Instant</span>
                                                            <span class="badge bg-info">Secure</span>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top-0">
                                                        <small><i class="fas fa-check-circle text-success me-1"></i>Recommended</small>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <!-- Cheque Option -->
                                    <div class="col-md-4">
                                        <div class="form-check payment-method-card">
                                            <input class="form-check-input" type="radio" name="payment_method" id="cheque" value="cheque">
                                            <label class="form-check-label w-100" for="cheque">
                                                <div class="card h-100 border-2 payment-card">
                                                    <div class="card-body text-center">
                                                        <div class="payment-icon mb-3">
                                                            <i class="fas fa-money-check-alt fa-3x text-info"></i>
                                                        </div>
                                                        <h6 class="card-title">Bank Cheque</h6>
                                                        <p class="card-text small text-muted">Pay via bank cheque</p>
                                                        <div class="mt-2">
                                                            <span class="badge bg-warning">2-3 Days</span>
                                                            <span class="badge bg-info">Secure</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <!-- Bank Transfer Option -->
                                    <div class="col-md-4">
                                        <div class="form-check payment-method-card">
                                            <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                            <label class="form-check-label w-100" for="bank_transfer">
                                                <div class="card h-100 border-2 payment-card">
                                                    <div class="card-body text-center">
                                                        <div class="payment-icon mb-3">
                                                            <i class="fas fa-university fa-3x text-primary"></i>
                                                        </div>
                                                        <h6 class="card-title">Bank Transfer</h6>
                                                        <p class="card-text small text-muted">Direct bank transfer</p>
                                                        <div class="mt-2">
                                                            <span class="badge bg-warning">1-2 Days</span>
                                                            <span class="badge bg-info">Secure</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Payment Method Details -->
                                <div class="payment-details-section mt-4">
                                    <!-- M-Pesa Details -->
                                    <div class="payment-details card border-success mb-3" id="mpesa-details">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="mb-0"><i class="fas fa-mobile-alt me-2"></i>M-Pesa Payment Details</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="mpesa_number" class="form-label">M-Pesa Phone Number <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">+254</span>
                                                        <input type="tel" 
                                                               class="form-control @error('mpesa_number') is-invalid @enderror" 
                                                               id="mpesa_number" 
                                                               name="mpesa_number" 
                                                               value="{{ old('mpesa_number') }}"
                                                               placeholder="7XXXXXXXX"
                                                               pattern="[0-9]{9}"
                                                               title="Enter 9-digit phone number (without 0)">
                                                        @error('mpesa_number')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <small class="text-muted">Enter your M-Pesa registered number</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="alert alert-success">
                                                        <h6><i class="fas fa-info-circle me-2"></i>Payment Instructions</h6>
                                                        <p class="mb-1 small">PayBill: <strong>247247</strong></p>
                                                        <p class="mb-1 small">Account: <strong>470470</strong></p>
                                                        <p class="mb-0 small">Confirm via WhatsApp after payment</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Cheque Details -->
                                    <div class="payment-details card border-info mb-3" id="cheque-details" style="display: none;">
                                        <div class="card-header bg-info text-white">
                                            <h6 class="mb-0"><i class="fas fa-money-check-alt me-2"></i>Cheque Payment Details</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="cheque_number" class="form-label">Cheque Number <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                                        <input type="text" 
                                                               class="form-control @error('cheque_number') is-invalid @enderror" 
                                                               id="cheque_number" 
                                                               name="cheque_number" 
                                                               value="{{ old('cheque_number') }}"
                                                               placeholder="Enter cheque number">
                                                        @error('cheque_number')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="alert alert-info">
                                                        <h6><i class="fas fa-info-circle me-2"></i>Important</h6>
                                                        <p class="mb-0 small">Please make cheque payable to: <strong>AGROVET SUPPLIES LTD</strong></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Bank Transfer Details -->
                                    <div class="payment-details card border-primary mb-3" id="bank-transfer-details" style="display: none;">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="mb-0"><i class="fas fa-university me-2"></i>Bank Transfer Details</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="bank_name" class="form-label">Bank Name <span class="text-danger">*</span></label>
                                                    <input type="text" 
                                                           class="form-control @error('bank_name') is-invalid @enderror" 
                                                           id="bank_name" 
                                                           name="bank_name" 
                                                           value="{{ old('bank_name') }}"
                                                           placeholder="e.g., KCB, Equity">
                                                    @error('bank_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="account_name" class="form-label">Account Name <span class="text-danger">*</span></label>
                                                    <input type="text" 
                                                           class="form-control @error('account_name') is-invalid @enderror" 
                                                           id="account_name" 
                                                           name="account_name" 
                                                           value="{{ old('account_name') }}"
                                                           placeholder="Account holder name">
                                                    @error('account_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="account_number" class="form-label">Account Number <span class="text-danger">*</span></label>
                                                    <input type="text" 
                                                           class="form-control @error('account_number') is-invalid @enderror" 
                                                           id="account_number" 
                                                           name="account_number" 
                                                           value="{{ old('account_number') }}"
                                                           placeholder="Account number">
                                                    @error('account_number')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Payment Proof Upload -->
                                    <div class="payment-details card border-warning mb-3" id="payment-proof-section" style="display: none;">
                                        <div class="card-header bg-warning text-dark">
                                            <h6 class="mb-0"><i class="fas fa-upload me-2"></i>Upload Payment Proof <span class="text-danger">*</span></h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="bank_slip" class="form-label">Payment Proof File</label>
                                                <input type="file" 
                                                       class="form-control @error('bank_slip') is-invalid @enderror" 
                                                       id="bank_slip" 
                                                       name="bank_slip"
                                                       accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                                @error('bank_slip')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Upload cheque photo or bank transfer slip (JPG, PNG, PDF, DOC - max 5MB)
                                                </div>
                                            </div>
                                            <div class="alert alert-info">
                                                <i class="fas fa-lightbulb me-2"></i>
                                                <strong>Tip:</strong> You can also send payment proof via WhatsApp after order placement
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @error('payment_method')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Order Notes -->
                        <h5 class="mb-3 text-primary"><i class="fas fa-sticky-note me-2"></i>Additional Information</h5>
                        <div class="card border-light mb-4">
                            <div class="card-body">
                                <label for="notes" class="form-label">Order Notes (Optional)</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" 
                                          name="notes" 
                                          rows="3"
                                          placeholder="Any special instructions, delivery preferences, or questions about your order...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-comment me-1"></i>
                                    Add any special requirements or questions about your order
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="form-check mb-4">
                            <input class="form-check-input @error('terms') is-invalid @enderror" 
                                   type="checkbox" 
                                   id="terms" 
                                   name="terms" 
                                   required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a> and understand that my order will be processed after payment confirmation via WhatsApp.
                            </label>
                            @error('terms')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3" id="place-order-btn">
                                <i class="fas fa-lock me-2"></i>Place Order & Generate Receipt
                            </button>
                            <div class="text-center mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-arrow-right me-1"></i>
                                    You'll be redirected to your receipt page after order placement
                                </small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Order Summary Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Order Summary</h4>
                </div>
                <div class="card-body">
                    <!-- Cart Items -->
                    <div class="order-items mb-4">
                        <h6 class="mb-3">Items ({{ count($cart) }})</h6>
                        <div class="cart-items-list">
                            @foreach($cart as $item)
                            <div class="cart-item d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div class="d-flex align-items-start">
                                    <div class="item-image me-3">
                                        @if(isset($item['image']))
                                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="rounded" width="60" height="60">
                                        @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                            <i class="fas fa-box text-muted"></i>
                                        </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $item['name'] }}</h6>
                                        <small class="text-muted">
                                            @if(isset($item['unit']))
                                            {{ $item['unit'] }} •
                                            @endif
                                            Qty: {{ $item['quantity'] }}
                                        </small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold">KES {{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                                    <small class="text-muted">KES {{ number_format($item['price'], 2) }} each</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Price Breakdown -->
                    <div class="order-summary">
                        <h6 class="mb-3">Price Breakdown</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal ({{ count($cart) }} items)</span>
                            <span class="fw-semibold">KES {{ number_format($subtotal, 2) }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Delivery Fee</span>
                            <span class="fw-semibold">KES {{ number_format($shipping, 2) }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tax (VAT)</span>
                            <span class="fw-semibold">KES {{ number_format($tax, 2) }}</span>
                        </div>
                        
                        <hr class="my-3">
                        
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0">Total Amount</h5>
                            <h4 class="text-success mb-0">KES {{ number_format($total, 2) }}</h4>
                        </div>
                    </div>
                    
                    <!-- Payment Information -->
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>Payment Information</h6>
                        <p class="mb-2 small">After placing order, you'll receive:</p>
                        <ul class="small mb-0">
                            <li>Order confirmation with receipt number</li>
                            <li>Payment instructions for your chosen method</li>
                            <li>WhatsApp contact for payment confirmation</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Support Card -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6><i class="fas fa-headset me-2 text-primary"></i>Need Help?</h6>
                    <p class="small mb-3">Our support team is here to help you with your order.</p>
                    
                    <div class="row g-2">
                        <div class="col-12">
                            <a href="https://wa.me/2547XXXXXXXXX?text=Hello!%20I%20need%20help%20with%20checkout" 
                               class="btn btn-success w-100" 
                               target="_blank">
                                <i class="fab fa-whatsapp me-2"></i>Chat on WhatsApp
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="tel:+254700000000" class="btn btn-outline-primary w-100">
                                <i class="fas fa-phone me-2"></i>Call Us
                            </a>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            Support available: Mon-Fri, 8AM-6PM
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- Security Badge -->
            <div class="text-center mt-4">
                <div class="d-flex justify-content-center gap-3">
                    <div class="text-center">
                        <i class="fas fa-shield-alt fa-2x text-primary"></i>
                        <p class="small mb-0 mt-1">Secure Payment</p>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-lock fa-2x text-success"></i>
                        <p class="small mb-0 mt-1">SSL Encrypted</p>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-user-shield fa-2x text-info"></i>
                        <p class="small mb-0 mt-1">Privacy Protected</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Order Processing</h6>
                <p>Orders are processed only after payment confirmation via WhatsApp. Please complete payment within 24 hours.</p>
                
                <h6>Payment Methods</h6>
                <p>We accept M-Pesa, Bank Cheque, and Bank Transfer. All payments require confirmation via WhatsApp.</p>
                
                <h6>Delivery</h6>
                <p>Delivery times vary based on payment confirmation and product availability.</p>
                
                <h6>Returns & Refunds</h6>
                <p>Returns accepted within 30 days with original receipt. Refunds processed within 5-7 business days.</p>
                
                <h6>Privacy Policy</h6>
                <p>Your personal information is secure and will not be shared with third parties.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 12px;
    border: 1px solid #e0e0e0;
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-2px);
}
.card-header {
    border-radius: 12px 12px 0 0 !important;
}
.payment-method-card .form-check-input {
    position: absolute;
    opacity: 0;
}
.payment-card {
    cursor: pointer;
    transition: all 0.3s ease;
    border-color: #dee2e6;
}
.payment-card:hover {
    border-color: #007bff;
    box-shadow: 0 4px 8px rgba(0,123,255,0.1);
}
.form-check-input:checked + .form-check-label .payment-card {
    border-color: #007bff;
    background-color: rgba(0,123,255,0.05);
    box-shadow: 0 4px 12px rgba(0,123,255,0.15);
}
.payment-details {
    border-left: 4px solid;
    animation: fadeIn 0.3s ease-in;
}
#mpesa-details {
    border-left-color: #28a745;
}
#cheque-details {
    border-left-color: #17a2b8;
}
#bank-transfer-details {
    border-left-color: #007bff;
}
#payment-proof-section {
    border-left-color: #ffc107;
}
.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border: none;
    padding: 15px;
    font-size: 18px;
    font-weight: 600;
    border-radius: 8px;
}
.btn-primary:hover {
    background: linear-gradient(135deg, #0056b3 0%, #004494 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,123,255,0.3);
}
.cart-item {
    transition: background-color 0.2s;
}
.cart-item:hover {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 8px;
    margin: -8px -8px 8px -8px;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const paymentDetails = document.querySelectorAll('.payment-details');
    const paymentProofSection = document.getElementById('payment-proof-section');
    
    // Function to show/hide payment details
    function togglePaymentDetails() {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
        
        // Hide all payment details
        paymentDetails.forEach(detail => {
            detail.style.display = 'none';
        });
        paymentProofSection.style.display = 'none';
        
        // Show selected payment details
        if (selectedMethod === 'mpesa') {
            document.getElementById('mpesa-details').style.display = 'block';
        } else if (selectedMethod === 'cheque') {
            document.getElementById('cheque-details').style.display = 'block';
            paymentProofSection.style.display = 'block';
        } else if (selectedMethod === 'bank_transfer') {
            document.getElementById('bank-transfer-details').style.display = 'block';
            paymentProofSection.style.display = 'block';
        }
    }
    
    // Add event listeners to payment methods
    paymentMethods.forEach(method => {
        method.addEventListener('change', togglePaymentDetails);
    });
    
    // Initialize on page load
    togglePaymentDetails();
    
    // Form validation
    const form = document.getElementById('checkout-form');
    const placeOrderBtn = document.getElementById('place-order-btn');
    
    form.addEventListener('submit', function(e) {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
        let isValid = true;
        
        // Validate M-Pesa number
        if (selectedMethod === 'mpesa') {
            const mpesaNumber = document.getElementById('mpesa_number').value;
            if (!mpesaNumber || !/^[0-9]{9}$/.test(mpesaNumber)) {
                alert('Please enter a valid 9-digit M-Pesa number (without the leading 0)');
                isValid = false;
            }
        }
        
        // Validate cheque number
        if (selectedMethod === 'cheque') {
            const chequeNumber = document.getElementById('cheque_number').value;
            if (!chequeNumber || chequeNumber.trim() === '') {
                alert('Please enter cheque number');
                isValid = false;
            }
        }
        
        // Validate bank transfer details
        if (selectedMethod === 'bank_transfer') {
            const bankName = document.getElementById('bank_name').value;
            const accountName = document.getElementById('account_name').value;
            const accountNumber = document.getElementById('account_number').value;
            
            if (!bankName || bankName.trim() === '') {
                alert('Please enter bank name');
                isValid = false;
            } else if (!accountName || accountName.trim() === '') {
                alert('Please enter account name');
                isValid = false;
            } else if (!accountNumber || accountNumber.trim() === '') {
                alert('Please enter account number');
                isValid = false;
            }
        }
        
        // Check terms acceptance
        const termsAccepted = document.getElementById('terms').checked;
        if (!termsAccepted) {
            alert('Please accept the Terms and Conditions to proceed');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            placeOrderBtn.disabled = false;
            placeOrderBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Place Order & Generate Receipt';
        } else {
            placeOrderBtn.disabled = true;
            placeOrderBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing Order...';
        }
    });
    
    // Phone number formatting
    const phoneInput = document.getElementById('customer_phone');
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0) {
            value = value.match(/.{1,3}/g).join(' ');
        }
        e.target.value = value;
    });
});
</script>
@endsection