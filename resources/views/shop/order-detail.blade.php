{{-- resources/views/shop/order-detail.blade.php --}}
@extends('layouts.app')

@section('title', 'Order #' . $order['order_id'])

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Order Confirmation</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        <h3 class="mt-3">Order Placed Successfully!</h3>
                        <p class="text-muted">Order #{{ $order['order_id'] }}</p>
                        <p class="text-muted">Placed on {{ \Carbon\Carbon::parse($order['created_at'])->format('F j, Y, g:i a') }}</p>
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-whatsapp me-2"></i>
                        <strong>WhatsApp message sent!</strong> Our admin will review your order and send a payment link shortly.
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Customer Information</h5>
                            <p class="mb-1"><strong>Name:</strong> {{ $order['customer_name'] }}</p>
                            <p class="mb-1"><strong>Phone:</strong> {{ $order['phone_number'] }}</p>
                            <p><strong>Address:</strong> {{ $order['address'] }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Order Status</h5>
                            <p class="mb-1">
                                <strong>Order Status:</strong>
                                <span class="badge bg-{{ $order['status'] == 'completed' ? 'success' : ($order['status'] == 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($order['status']) }}
                                </span>
                            </p>
                            <p>
                                <strong>Payment Status:</strong>
                                <span class="badge bg-{{ $order['payment_status'] == 'paid' ? 'success' : ($order['payment_status'] == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($order['payment_status']) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <h5>Order Items</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order['items'] as $item)
                                <tr>
                                    <td>{{ $item['product_name'] }}</td>
                                    <td class="text-center">{{ $item['quantity'] }}</td>
                                    <td>KES {{ number_format($item['unit_price']) }}</td>
                                    <td>KES {{ number_format($item['unit_price'] * $item['quantity']) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total:</td>
                                    <td class="fw-bold">KES {{ number_format($order['subtotal']) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if($order['payment_status'] == 'pending' && isset($order['payment_link']))
                    <div class="text-center mt-4">
                        <a href="{{ $order['payment_link'] }}" class="btn btn-success btn-lg" target="_blank">
                            <i class="bi bi-credit-card me-2"></i>Complete Payment
                        </a>
                    </div>
                    @endif

                    <div class="text-center mt-4">
                        <a href="/shop" class="btn btn-outline-success">Continue Shopping</a>
                        <a href="/orders" class="btn btn-outline-secondary ms-2">View All Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-refresh order status every 30 seconds
    setInterval(async function() {
        const orderId = '{{ $order['order_id'] }}';
        try {
            const response = await fetch(`/api/orders/${orderId}/status`);
            const data = await response.json();
            
            if (data.success && data.payment_status === 'paid') {
                location.reload();
            }
        } catch (error) {
            console.error('Error checking order status:', error);
        }
    }, 30000);
</script>
@endsection