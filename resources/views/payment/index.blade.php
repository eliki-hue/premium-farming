{{-- resources/views/payment/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Complete Payment')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Complete Payment</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Order Details</h5>
                        <p class="mb-1"><strong>Order ID:</strong> <span id="orderIdDisplay">{{ $orderId }}</span></p>
                        <p><strong>Amount:</strong> KES <span id="orderAmount">{{ number_format($order['subtotal'] ?? 0) }}</span></p>
                    </div>

                    <form id="paymentForm">
                        @csrf
                        <input type="hidden" name="order_id" id="orderId" value="{{ $orderId }}">
                        <input type="hidden" name="token" id="token" value="{{ $token ?? '' }}">
                        
                        <div class="mb-3">
                            <label class="form-label">M-Pesa Phone Number</label>
                            <input type="tel" class="form-control" name="phone_number" id="phoneNumber" 
                                   placeholder="0700680017" required>
                            <small class="text-muted">Enter the number that will receive the STK push</small>
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100 py-2" id="payBtn">
                            <i class="bi bi-phone me-2"></i>Pay with M-Pesa
                        </button>
                    </form>

                    <div id="paymentStatus" class="mt-4 d-none">
                        <div class="alert" id="statusAlert"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
        border: none;
    }
    .card-header {
        border-radius: 10px 10px 0 0;
    }
    .form-control:focus {
        border-color: #2a6e3f;
        box-shadow: 0 0 0 0.2rem rgba(42, 110, 63, 0.25);
    }
    .btn-success {
        background-color: #2a6e3f;
        border: none;
        padding: 12px;
        font-weight: 600;
    }
    .btn-success:hover {
        background-color: #1e5a2f;
    }
    .btn-success:disabled {
        background-color: #6c757d;
        cursor: not-allowed;
    }
</style>

<script>
let pollingInterval = null;

document.getElementById('paymentForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const orderId = document.getElementById('orderId').value;
    const phoneNumber = document.getElementById('phoneNumber').value.trim();
    const token = document.getElementById('token').value;
    
    if (!phoneNumber) {
        showStatus('Please enter your M-Pesa phone number', 'danger');
        return;
    }
    
    const payBtn = document.getElementById('payBtn');
    payBtn.disabled = true;
    payBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Initiating Payment...';
    
    try {
        // Step 9: POST to api/ecommerce/pay/
        const response = await fetch('/api/ecommerce/pay/', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                order_id: orderId,
                token: token,
                phone_number: phoneNumber
            })
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.message || 'Payment initiation failed');
        }
        
        showStatus('✅ STK Push sent! Check your phone and enter PIN to complete payment.', 'info');
        
        // Start polling for payment status
        startPolling(orderId);
        
    } catch (error) {
        showStatus('❌ ' + error.message, 'danger');
        payBtn.disabled = false;
        payBtn.innerHTML = '<i class="bi bi-phone me-2"></i>Pay with M-Pesa';
    }
});

function startPolling(orderId) {
    let attempts = 0;
    const maxAttempts = 30; // 30 * 5 seconds = 2.5 minutes
    
    if (pollingInterval) {
        clearInterval(pollingInterval);
    }
    
    pollingInterval = setInterval(async () => {
        attempts++;
        
        try {
            const response = await fetch(`/api/payment/status/${orderId}`, {
                headers: {
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.payment_status === 'paid' || data.status === 'completed') {
                // Step 10 & 11: Payment successful
                clearInterval(pollingInterval);
                showStatus('✅ Payment successful! Order completed.', 'success');
                
                const payBtn = document.getElementById('payBtn');
                payBtn.disabled = true;
                payBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Payment Completed';
                
                // Redirect to order confirmation after 3 seconds
                setTimeout(() => {
                    window.location.href = `/orders/${orderId}`;
                }, 3000);
                
            } else if (data.payment_status === 'failed') {
                // Payment failed
                clearInterval(pollingInterval);
                showStatus('❌ Payment failed. Please try again.', 'danger');
                
                const payBtn = document.getElementById('payBtn');
                payBtn.disabled = false;
                payBtn.innerHTML = '<i class="bi bi-phone me-2"></i>Retry Payment';
                
            } else if (attempts >= maxAttempts) {
                // Timeout
                clearInterval(pollingInterval);
                showStatus('⏱️ Payment timeout. Please check your M-Pesa messages or contact support.', 'warning');
                
                const payBtn = document.getElementById('payBtn');
                payBtn.disabled = false;
                payBtn.innerHTML = '<i class="bi bi-phone me-2"></i>Retry Payment';
            }
            
        } catch (error) {
            console.error('Error checking payment status:', error);
        }
    }, 5000); // Check every 5 seconds
}

function showStatus(message, type) {
    const statusDiv = document.getElementById('paymentStatus');
    const alertDiv = document.getElementById('statusAlert');
    
    statusDiv.classList.remove('d-none');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.innerHTML = message;
    
    // Auto hide after 10 seconds for success/error
    if (type !== 'info') {
        setTimeout(() => {
            statusDiv.classList.add('d-none');
        }, 10000);
    }
}
</script>
@endsection