{{-- resources/views/shop/orders.blade.php --}}
@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">My Orders</h4>
                </div>
                <div class="card-body">
                    @if(isset($customerInfo) && !empty($customerInfo))
                        <div class="alert alert-info mb-4">
                            <i class="bi bi-person-circle me-2"></i>
                            <strong>Customer:</strong> {{ $customerInfo['name'] ?? 'N/A' }} | 
                            <strong>Phone:</strong> {{ $customerInfo['phone'] ?? 'N/A' }}
                        </div>
                    @endif
                    
                    @if(empty($orders))
                        <div class="text-center py-5">
                            <i class="bi bi-box-seam" style="font-size: 4rem; color: #c8e6c9;"></i>
                            <h5 class="mt-3 text-muted">No orders found</h5>
                            <p class="text-muted">Start shopping to place your first order.</p>
                            <a href="/shop" class="btn btn-success mt-3">
                                <i class="bi bi-bag me-2"></i>Start Shopping
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $orderId => $order)
                                    <tr>
                                        <td>
                                            <strong>{{ $orderId }}</strong>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($order['created_at'])->format('M d, Y') }}</td>
                                        <td>KES {{ number_format($order['subtotal']) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order['status'] == 'completed' ? 'success' : ($order['status'] == 'pending' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($order['status']) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $order['payment_status'] == 'paid' ? 'success' : ($order['payment_status'] == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($order['payment_status']) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="/orders/{{ $orderId }}" class="btn btn-sm btn-outline-success">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection