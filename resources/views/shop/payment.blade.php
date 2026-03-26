{{-- resources/views/payment.blade.php --}}
@extends('layouts.app')

@section('title', 'Payment Processing')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            {{-- Payment Card --}}
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5 text-center">
                    {{-- Logo/Icon --}}
                    <div class="mb-4">
                        <i class="bi bi-credit-card-2-front" style="font-size: 4rem; color: #2a6e3f;"></i>
                    </div>

                    {{-- Order Info --}}
                    <h3 class="fw-bold mb-3" style="color: #2a6e3f;">Complete Your Payment</h3>
                    <p class="text-muted mb-4">Order #{{ $orderId }}</p>

                    {{-- Status Messages --}}
                    <div id="statusContainer" class="mb-4">
                        <div id="loadingState">
                            <div class="spinner-border text-success mb-3" role="status">
                                <span class="visually-hidden">Processing...</span>
                            </div>
                            <p class="text-muted">Initializing payment...</p>
                        </div>
                        
                        <div id="successState" class="d-none">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                            <h5 class="mt-2 text-success">Payment Initiated!</h5>
                            <p id="successMessage" class="text-muted"></p>
                        </div>
                        
                        <div id="errorState" class="d-none">
                            <i class="bi bi-x-circle-fill text-danger" style="font-size: 3rem;"></i>
                            <h5 class="mt-2 text-danger">Payment Failed</h5>
                            <p id="errorMessage" class="text-muted"></p>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div id="actionButtons" class="d-none">
                        <div class="d-grid gap-3">
                            <button id="retryPaymentBtn" class="btn btn-success btn-lg">
                                <i class="bi bi-arrow-repeat me-2"></i>Retry Payment
                            </button>
                            <a href="{{ route('orders') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-box-arrow-right me-2"></i>View My Orders
                            </a>
                            <a href="{{ route('products') }}" class="btn btn-link text-muted">
                                <i class="bi bi-shop me-2"></i>Continue Shopping
                            </a>
                        </div>
                    </div>

                    {{-- Info Note --}}
                    <div class="mt-4 pt-3 border-top">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            An M-Pesa STK push will be sent to your registered phone number.
                            Please check your phone and enter your PIN to complete the payment.
                        </small>
                    </div>
                </div>
            </div>

            {{-- Instructions Card --}}
            <div class="card border-0 mt-4 bg-light">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-telephone me-2 text-success"></i>What to expect:
                    </h6>
                    <ul class="text-muted mb-0">
                        <li class="mb-2">📱 You'll receive a payment request on your M-Pesa phone</li>
                        <li class="mb-2">🔢 Enter your M-Pesa PIN to authorize the payment</li>
                        <li class="mb-2">✅ Payment confirmation will be sent via SMS</li>
                        <li>🔄 The page will redirect to your orders once complete</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 20px;
        transition: transform 0.2s;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #2a6e3f, #3a8e5c);
        border: none;
        font-weight: 600;
        padding: 12px;
    }
    
    .btn-success:hover {
        background: linear-gradient(135deg, #1e5a2f, #2a6e3f);
        transform: translateY(-1px);
    }
    
    .btn-outline-secondary:hover {
        transform: translateY(-1px);
    }
    
    /* Animation for success icon */
    @keyframes bounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    
    .bi-check-circle-fill {
        animation: bounce 0.5s ease;
    }
    
    /* Spinner animation */
    .spinner-border {
        width: 3rem;
        height: 3rem;
    }
</style>

<script>
(function() {
    'use strict';

    // Get order details from URL
    const urlParams = new URLSearchParams(window.location.search);
    const orderId = {{ $orderId }};
    const token = '{{ $token }}';
    
    // API endpoint
    const API_URL = `/api/ecommerce/pay/${orderId}`;
    
    // DOM elements
    const loadingState = document.getElementById('loadingState');
    const successState = document.getElementById('successState');
    const errorState = document.getElementById('errorState');
    const actionButtons = document.getElementById('actionButtons');
    const retryBtn = document.getElementById('retryPaymentBtn');
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');
    
    // Polling interval for checking payment status
    let pollingInterval = null;
    let pollCount = 0;
    const MAX_POLLS = 20;
    
    /**
     * Show notification toast
     */
    function showToast(message, type = 'info', duration = 5000) {
        const existingToast = document.querySelector('.payment-toast');
        if (existingToast) existingToast.remove();
        
        const toast = document.createElement('div');
        toast.className = `payment-toast position-fixed bottom-0 end-0 m-3 p-3 bg-white rounded-3 shadow-lg`;
        toast.style.zIndex = '9999';
        toast.style.minWidth = '300px';
        toast.style.borderLeft = `4px solid ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#17a2b8'}`;
        
        const icon = document.createElement('i');
        icon.className = type === 'success' ? 'bi bi-check-circle-fill text-success me-2' : 
                        type === 'error' ? 'bi bi-exclamation-circle-fill text-danger me-2' : 
                        'bi bi-info-circle-fill text-info me-2';
        
        const text = document.createElement('span');
        text.textContent = message;
        
        toast.appendChild(icon);
        toast.appendChild(text);
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.3s';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }
    
    /**
     * Initialize STK Push
     */
    async function initiatePayment() {
        try {
            loadingState.classList.remove('d-none');
            successState.classList.add('d-none');
            errorState.classList.add('d-none');
            actionButtons.classList.add('d-none');
            
            const response = await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    token: token,
                    order_id: orderId
                })
            });
            
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Failed to initiate payment');
            }
            
            loadingState.classList.add('d-none');
            successState.classList.remove('d-none');
            
            let message = data.message || 'Payment prompt has been sent to your phone.';
            if (data.checkout_request_id) {
                message += ` Check your phone and enter your PIN to complete the payment.`;
            }
            successMessage.textContent = message;
            actionButtons.classList.remove('d-none');
            
            showToast('✅ STK push sent! Check your phone to complete payment.', 'success', 6000);
            
            startPollingPaymentStatus();
            
        } catch (error) {
            console.error('Payment initiation error:', error);
            
            loadingState.classList.add('d-none');
            errorState.classList.remove('d-none');
            
            let message = error.message || 'Failed to initiate payment. Please try again.';
            if (message.includes('timeout') || message.includes('network')) {
                message = 'Network error. Please check your connection and try again.';
            }
            errorMessage.textContent = message;
            actionButtons.classList.remove('d-none');
            
            showToast('❌ ' + message, 'error', 8000);
        }
    }
    
    /**
     * Poll for payment status
     */
    async function checkPaymentStatus() {
        if (!pollingInterval) return;
        
        pollCount++;
        
        try {
            const response = await fetch(`/api/payment/status/${orderId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                credentials: 'same-origin'
            });
            
            const data = await response.json();
            
            if (data.status === 'completed' || data.status === 'paid') {
                stopPolling();
                
                successState.classList.add('d-none');
                errorState.classList.add('d-none');
                loadingState.classList.add('d-none');
                
                const statusContainer = document.getElementById('statusContainer');
                statusContainer.innerHTML = `
                    <div class="text-center">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                        <h5 class="mt-2 text-success">Payment Successful!</h5>
                        <p class="text-muted">Your payment has been confirmed. Redirecting to orders...</p>
                    </div>
                `;
                
                showToast('✅ Payment successful! Redirecting...', 'success', 3000);
                
                setTimeout(() => {
                    window.location.href = '/orders';
                }, 3000);
                
            } else if (data.status === 'failed' || data.status === 'cancelled') {
                stopPolling();
                
                errorState.classList.remove('d-none');
                errorMessage.textContent = 'Payment failed or was cancelled. Please try again.';
                showToast('❌ Payment failed. Please try again.', 'error', 5000);
                
            } else if (pollCount >= MAX_POLLS) {
                stopPolling();
                
                errorState.classList.remove('d-none');
                errorMessage.textContent = 'Payment is taking longer than expected. Please check your phone or try again.';
                showToast('⏱️ Payment timeout. Please check your phone or retry.', 'warning', 8000);
            }
            
        } catch (error) {
            console.error('Error checking payment status:', error);
            
            if (pollCount >= MAX_POLLS) {
                stopPolling();
                errorState.classList.remove('d-none');
                errorMessage.textContent = 'Unable to verify payment status. Please check your orders page.';
            }
        }
    }
    
    /**
     * Start polling for payment status
     */
    function startPollingPaymentStatus() {
        if (pollingInterval) {
            clearInterval(pollingInterval);
        }
        
        pollCount = 0;
        pollingInterval = setInterval(() => {
            checkPaymentStatus();
        }, 3000);
    }
    
    /**
     * Stop polling
     */
    function stopPolling() {
        if (pollingInterval) {
            clearInterval(pollingInterval);
            pollingInterval = null;
        }
    }
    
    /**
     * Retry payment
     */
    function retryPayment() {
        pollCount = 0;
        initiatePayment();
    }
    
    /**
     * Validate token before proceeding
     */
    function validateToken() {
        if (!token || token === '') {
            errorState.classList.remove('d-none');
            loadingState.classList.add('d-none');
            errorMessage.textContent = 'Invalid or missing payment token. Please contact support.';
            actionButtons.classList.remove('d-none');
            retryBtn.disabled = true;
            retryBtn.style.opacity = '0.5';
            retryBtn.title = 'Invalid token - cannot retry';
            return false;
        }
        return true;
    }
    
    /**
     * Handle page visibility change
     */
    function handleVisibilityChange() {
        if (!document.hidden && pollingInterval === null && 
            !loadingState.classList.contains('d-none') === false &&
            successState.classList.contains('d-none') === false) {
            startPollingPaymentStatus();
        }
    }
    
    /**
     * Initialize page
     */
    function init() {
        if (!validateToken()) {
            return;
        }
        
        retryBtn.addEventListener('click', retryPayment);
        document.addEventListener('visibilitychange', handleVisibilityChange);
        initiatePayment();
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    window.addEventListener('beforeunload', function() {
        if (pollingInterval) {
            clearInterval(pollingInterval);
        }
    });
})();
</script>

@push('styles')
<style>
    .payment-toast {
        animation: slideInRight 0.3s ease;
        transition: opacity 0.3s ease;
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>
@endpush

@endsection