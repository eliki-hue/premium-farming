{{-- resources/views/orders/confirmation.blade.php --}}
@extends('layouts.app')

@section('title', 'Order Confirmation - #' . $order['order_id'])

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white text-center py-4">
                    <i class="bi bi-check-circle-fill" style="font-size: 3rem;"></i>
                    <h3 class="mb-0 mt-2">Order Confirmed!</h3>
                    <p class="mb-0 mt-2">Thank you for your purchase</p>
                </div>
                
                <div class="card-body p-4">
                    {{-- Order Status Badge --}}
                    <div class="text-center mb-4">
                        @if($order['payment_status'] == 'paid')
                            <span class="badge bg-success px-3 py-2">
                                <i class="bi bi-check-circle me-1"></i> Payment Successful
                            </span>
                        @else
                            <span class="badge bg-warning px-3 py-2">
                                <i class="bi bi-clock me-1"></i> Payment Pending
                            </span>
                        @endif
                        
                        @if($order['status'] == 'completed')
                            <span class="badge bg-success px-3 py-2 ms-2">
                                <i class="bi bi-check-all me-1"></i> Order Completed
                            </span>
                        @else
                            <span class="badge bg-info px-3 py-2 ms-2">
                                <i class="bi bi-hourglass-split me-1"></i> {{ ucfirst($order['status']) }}
                            </span>
                        @endif
                    </div>
                    
                    {{-- Order ID --}}
                    <div class="text-center mb-4">
                        <h5>Order ID</h5>
                        <h4 class="fw-bold text-success">{{ $order['order_id'] }}</h4>
                        <p class="text-muted small">Placed on {{ \Carbon\Carbon::parse($order['created_at'])->format('F j, Y, g:i a') }}</p>
                    </div>
                    
                    {{-- Order Summary --}}
                    <div class="border rounded p-3 mb-4 bg-light">
                        <h5 class="mb-3">Order Summary</h5>
                        
                        @foreach($order['items'] as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <span class="fw-medium">{{ $item['product_name'] }}</span>
                                <br>
                                <small class="text-muted">Qty: {{ $item['quantity'] }} × KES {{ number_format($item['unit_price']) }}</small>
                            </div>
                            <span class="fw-bold">KES {{ number_format($item['unit_price'] * $item['quantity']) }}</span>
                        </div>
                        @endforeach
                        
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span class="text-success">KES {{ number_format($order['subtotal']) }}</span>
                        </div>
                    </div>
                    
                    {{-- Customer Details --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="border rounded p-3">
                                <h6 class="fw-bold mb-2">
                                    <i class="bi bi-person me-1"></i> Customer Details
                                </h6>
                                <p class="mb-1"><strong>Name:</strong> {{ $order['customer_name'] }}</p>
                                <p class="mb-1"><strong>Phone:</strong> {{ $order['phone_number'] }}</p>
                                @if(!empty($order['address']))
                                <p class="mb-0"><strong>Address:</strong> {{ $order['address'] }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-6 mt-3 mt-md-0">
                            <div class="border rounded p-3">
                                <h6 class="fw-bold mb-2">
                                    <i class="bi bi-truck me-1"></i> Delivery Info
                                </h6>
                                <p class="mb-1"><strong>Status:</strong> 
                                    @if($order['status'] == 'completed')
                                        <span class="text-success">Delivered</span>
                                    @elseif($order['status'] == 'pending')
                                        <span class="text-warning">Processing</span>
                                    @else
                                        <span class="text-info">{{ ucfirst($order['status']) }}</span>
                                    @endif
                                </p>
                                <p class="mb-0"><strong>Payment:</strong>
                                    @if($order['payment_status'] == 'paid')
                                        <span class="text-success">Completed ✓</span>
                                    @else
                                        <span class="text-warning">Pending</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Action Buttons --}}
                    <div class="d-grid gap-2">
                        @if($order['payment_status'] != 'paid')
                            <a href="/payment/{{ $order['order_id'] }}" class="btn btn-success py-2">
                                <i class="bi bi-credit-card me-2"></i>Complete Payment
                            </a>
                        @endif
                        
                        <a href="/orders" class="btn btn-outline-primary py-2">
                            <i class="bi bi-list-ul me-2"></i>View All Orders
                        </a>
                        
                        <a href="/shop" class="btn btn-outline-secondary py-2">
                            <i class="bi bi-bag me-2"></i>Continue Shopping
                        </a>
                    </div>
                    
                    {{-- Additional Info --}}
                    <div class="alert alert-info mt-4 mb-0">
                        <i class="bi bi-envelope me-2"></i>
                        A confirmation has been sent to your phone. For any questions, contact us at 
                        <strong>0700680017</strong> or email <strong>premiumfarming@gmail.com</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
    .card-header {
        border-radius: 0;
    }
    .badge {
        font-size: 0.9rem;
        font-weight: 500;
    }
    .border {
        border-color: #e0e0e0 !important;
    }
    .btn {
        font-weight: 500;
    }
    .alert {
        border-radius: 10px;
    }
</style>

<script>
// Auto-refresh order status if payment is pending
@if($order['payment_status'] != 'paid')
let refreshCount = 0;
const maxRefreshes = 12; // Check for 2 minutes (12 * 10 seconds)

const interval = setInterval(async () => {
    refreshCount++;
    
    try {
        const response = await fetch(`/api/orders/{{ $order['order_id'] }}/status`);
        const data = await response.json();
        
        if (data.payment_status === 'paid') {
            // Payment completed, refresh page
            clearInterval(interval);
            location.reload();
        } else if (refreshCount >= maxRefreshes) {
            // Stop polling after max attempts
            clearInterval(interval);
        }
    } catch (error) {
        console.error('Error checking order status:', error);
    }
}, 10000); // Check every 10 seconds
@endif

// WhatsApp share function (optional)
function shareViaWhatsApp() {
    const message = encodeURIComponent(`Check out my order #{{ $order['order_id'] }} from Premium Farming Feeds!`);
    window.open(`https://wa.me/?text=${message}`, '_blank');
}
</script>
@endsection