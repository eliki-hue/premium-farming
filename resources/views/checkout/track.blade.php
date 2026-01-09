@extends('layouts.app')

@section('title', 'Track Your Order')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-search-location me-2"></i>Track Your Order</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(isset($error))
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endif

                    <div class="track-instructions mb-4">
                        <p class="text-muted">
                            <i class="fas fa-info-circle me-2"></i>
                            Enter your Order ID or Email address to track your order status.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('checkout.track') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="order_id" class="form-label">Order ID</label>
                                <input type="text" 
                                       class="form-control @error('order_id') is-invalid @enderror" 
                                       id="order_id" 
                                       name="order_id" 
                                       value="{{ old('order_id') }}"
                                       placeholder="e.g., ORD-123456">
                                @error('order_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Found in your order confirmation email</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       placeholder="Your email address">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">The email used to place the order</small>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-search me-2"></i>Track Order
                            </button>
                        </div>
                    </form>

                    @if(isset($order) && $searchPerformed)
                        <hr class="my-4">
                        
                        <div class="tracking-results">
                            <h5 class="mb-3"><i class="fas fa-box me-2"></i>Order Details</h5>
                            
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Order ID:</strong> {{ $order->order_number }}</p>
                                            <p><strong>Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                                            <p><strong>Status:</strong> 
                                                <span class="badge 
                                                    @if($order->status == 'completed') bg-success
                                                    @elseif($order->status == 'processing') bg-info
                                                    @elseif($order->status == 'shipped') bg-primary
                                                    @elseif($order->status == 'cancelled') bg-danger
                                                    @else bg-secondary @endif">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
                                            <p><strong>Email:</strong> {{ $order->email }}</p>
                                            <p><strong>Total:</strong> KES {{ number_format($order->total_amount, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Status Timeline -->
                            <div class="status-timeline mb-4">
                                <h6 class="mb-3">Order Status Timeline</h6>
                                <div class="progress" style="height: 8px;">
                                    @php
                                        $statuses = ['pending', 'processing', 'shipped', 'completed'];
                                        $currentIndex = array_search($order->status, $statuses);
                                        $progress = $currentIndex !== false ? (($currentIndex + 1) / count($statuses)) * 100 : 25;
                                    @endphp
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%" 
                                         aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-2">
                                    @foreach($statuses as $status)
                                        <div class="text-center">
                                            <div class="status-icon 
                                                @if(array_search($status, $statuses) <= $currentIndex) text-success @else text-muted @endif">
                                                @if($status == 'pending')
                                                    <i class="fas fa-clock fa-2x"></i>
                                                @elseif($status == 'processing')
                                                    <i class="fas fa-cog fa-2x"></i>
                                                @elseif($status == 'shipped')
                                                    <i class="fas fa-shipping-fast fa-2x"></i>
                                                @elseif($status == 'completed')
                                                    <i class="fas fa-check-circle fa-2x"></i>
                                                @endif
                                            </div>
                                            <small class="d-block mt-1">{{ ucfirst($status) }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="order-items mb-4">
                                <h6 class="mb-3">Order Items</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($order->items && count($order->items) > 0)
                                                @foreach($order->items as $item)
                                                    <tr>
                                                        <td>{{ $item->product_name ?? 'Product' }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>KES {{ number_format($item->price, 2) }}</td>
                                                        <td>KES {{ number_format($item->quantity * $item->price, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="text-center">No items found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Shipping Information -->
                            <div class="shipping-info">
                                <h6 class="mb-3">Shipping Information</h6>
                                <div class="card">
                                    <div class="card-body">
                                        <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
                                        @if($order->shipping_city)
                                            <p><strong>City:</strong> {{ $order->shipping_city }}</p>
                                        @endif
                                        @if($order->shipping_state)
                                            <p><strong>State:</strong> {{ $order->shipping_state }}</p>
                                        @endif
                                        @if($order->shipping_zip)
                                            <p><strong>ZIP Code:</strong> {{ $order->shipping_zip }}</p>
                                        @endif
                                        @if($order->shipping_country)
                                            <p><strong>Country:</strong> {{ $order->shipping_country }}</p>
                                        @endif
                                        <p><strong>Phone:</strong> {{ $order->phone }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-4 text-center">
                                <a href="{{ route('checkout.receipt', ['orderId' => $order->id]) }}" 
                                   class="btn btn-outline-primary me-2">
                                    <i class="fas fa-receipt me-2"></i>View Receipt
                                </a>
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-shopping-cart me-2"></i>Continue Shopping
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- @if($searchPerformed && !isset($order) && !isset($error))
                        <div class="alert alert-info mt-4">
                            <i class="fas fa-info-circle me-2"></i>
                            No order found. Please check your information and try again.
                        </div>
                    @endif --}}

                    <div class="mt-4 pt-3 border-top">
                        <h6 class="mb-3"><i class="fas fa-question-circle me-2"></i>Need Help?</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><i class="fas fa-phone me-2"></i> Call us: 123-456-7890</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><i class="fas fa-envelope me-2"></i> Email: support@example.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.status-timeline .status-icon {
    transition: all 0.3s ease;
}
.status-timeline .status-icon.text-success i {
    color: #28a745 !important;
}
.status-timeline .status-icon.text-muted i {
    color: #6c757d !important;
}
.card {
    border-radius: 10px;
}
.card-header {
    border-radius: 10px 10px 0 0 !important;
}
.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}
.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}
</style>

@endsection