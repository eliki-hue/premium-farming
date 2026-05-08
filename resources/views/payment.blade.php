{{-- resources/views/payment.blade.php --}}
@extends('layouts.app')

@section('title', 'Complete Payment')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Complete Your Payment</h4>
                </div>
                <div class="card-body">
                    <div id="paymentStatus" class="text-center py-4">
                        <div class="spinner-border text-success mb-3" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <h5>Processing your payment...</h5>
                        <p class="text-muted">Please check your phone for the STK push prompt.</p>
                    </div>

                    <div id="paymentSuccess" class="text-center py-4 d-none">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        <h4 class="mt-3">Payment Successful!</h4>
                        <p class="text-muted">Your order has been confirmed.</p>
                        <a href="/orders" class="btn btn-success mt-3">View My Orders</a>
                    </div>

                    <div id="paymentFailed" class="text-center py-4 d-none">
                        <i class="bi bi-x-circle-fill text-danger" style="font-size: 4rem;"></i>
                        <h4 class="mt-3">Payment Failed</h4>
                        <p class="text-muted" id="failureReason">Please try again or contact support.</p>
                        <button onclick="retryPayment()" class="btn btn-warning mt-3">Retry Payment</button>
                        <a href="/cart" class="btn btn-outline-secondary mt-3">Back to Cart</a>
                    </div>

                    <div id="paymentPending" class="text-center py-4 d-none">
                        <i class="bi bi-hourglass-split text-warning" style="font-size: 4rem;"></i>
                        <h4 class="mt-3">Payment Pending</h4>
                        <p class="text-muted">Waiting for payment confirmation...</p>
                        <button onclick="checkPaymentStatus()" class="btn btn-primary mt-3">Check Status</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const orderId = '{{ $orderId }}';
const token = '{{ $token }}';

function checkPaymentStatus() {
    fetch(`/api/payment/status/${orderId}`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'completed' || data.status === 'paid') {
            document.getElementById('paymentStatus').classList.add('d-none');
            document.getElementById('paymentSuccess').classList.remove('d-none');
        } else if (data.status === 'failed') {
            document.getElementById('paymentStatus').classList.add('d-none');
            document.getElementById('paymentFailed').classList.remove('d-none');
            document.getElementById('failureReason').textContent = data.message || 'Payment failed. Please try again.';
        } else {
            // Still pending, wait and check again
            setTimeout(checkPaymentStatus, 5000);
        }
    })
    .catch(error => {
        console.error('Error checking payment status:', error);
    });
}

function retryPayment() {
    // Trigger STK push again
    fetch(`/api/ecommerce/pay/`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            order_id: orderId,
            token: token
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('paymentFailed').classList.add('d-none');
            document.getElementById('paymentStatus').classList.remove('d-none');
            // Start polling again
            setTimeout(checkPaymentStatus, 3000);
        } else {
            alert('Failed to initiate payment. Please try again later.');
        }
    })
    .catch(error => {
        console.error('Error retrying payment:', error);
        alert('Network error. Please try again.');
    });
}

// Start checking payment status on page load
document.addEventListener('DOMContentLoaded', function() {
    // First, trigger the STK push
    fetch(`/api/ecommerce/pay/`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            order_id: orderId,
            token: token
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Start polling for payment status
            setTimeout(checkPaymentStatus, 5000);
        } else {
            document.getElementById('paymentStatus').classList.add('d-none');
            document.getElementById('paymentFailed').classList.remove('d-none');
            document.getElementById('failureReason').textContent = data.message || 'Failed to initiate payment.';
        }
    })
    .catch(error => {
        console.error('Error initiating payment:', error);
        document.getElementById('paymentStatus').classList.add('d-none');
        document.getElementById('paymentFailed').classList.remove('d-none');
        document.getElementById('failureReason').textContent = 'Network error. Please try again.';
    });
});
</script>
@endsection