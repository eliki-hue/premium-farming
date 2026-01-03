@extends('layouts.app')

@section('title', 'My Orders - Premium Farming Feeds')

@section('content')
<div class="min-h-screen pt-24 bg-gray-50">
    <div class="container py-8">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3">My Orders</h1>
                    <a href="{{ route('shop.products') }}" class="btn btn-outline-primary">
                        <i class="bi bi-cart-plus me-2"></i> Shop More
                    </a>
                </div>

                @if(empty($orders))
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-cart-x text-muted fs-1 mb-3"></i>
                        <h4 class="text-muted">No orders yet</h4>
                        <p class="text-muted mb-4">You haven't placed any orders yet.</p>
                        <a href="{{ route('products') }}" class="btn btn-primary">
                            <i class="bi bi-cart me-2"></i> Start Shopping
                        </a>
                    </div>
                </div>
                @else
                <!-- Orders Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <strong>{{ $order['order_id'] }}</strong>
                                            <div class="small text-muted">
                                                {{ $order['customer']['name'] }}
                                            </div>
                                        </td>
                                        <td>
                                            {{ date('M d, Y', strtotime($order['order_date'])) }}
                                            <div class="small text-muted">
                                                {{ date('H:i', strtotime($order['order_date'])) }}
                                            </div>
                                        </td>
                                        <td>
                                            {{ count($order['items']) }} item(s)
                                            <div class="small text-muted">
                                                @php
                                                    $itemNames = array_column($order['items'], 'name');
                                                    echo implode(', ', array_slice($itemNames, 0, 2));
                                                    if(count($itemNames) > 2) echo '...';
                                                @endphp
                                            </div>
                                        </td>
                                        <td>
                                            <strong>Ksh {{ number_format($order['totals']['total']) }}</strong>
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'processing' => 'warning',
                                                    'shipped' => 'info',
                                                    'delivered' => 'success',
                                                    'cancelled' => 'danger'
                                                ];
                                                $color = $statusColors[$order['status']] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $color }}">
                                                {{ ucfirst($order['status']) }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $paymentColors = [
                                                    'completed' => 'success',
                                                    'pending' => 'warning',
                                                    'failed' => 'danger'
                                                ];
                                                $pColor = $paymentColors[$order['payment']['status']] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $pColor }}">
                                                {{ ucfirst($order['payment']['status']) }}
                                            </span>
                                            <div class="small text-muted">
                                                {{ ucfirst($order['payment']['method']) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('checkout.order.view', $order['order_id']) }}" 
                                                   class="btn btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('checkout.receipt', $order['order_id']) }}" 
                                                   class="btn btn-outline-secondary">
                                                    <i class="bi bi-receipt"></i>
                                                </a>
                                                @if($order['status'] == 'processing')
                                                <button class="btn btn-outline-danger">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Order Status Legend -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h6 class="mb-3">Order Status Guide</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-warning me-2">●</span>
                                    <span>Processing</span>
                                </div>
                                <small class="text-muted">Order is being prepared</small>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-info me-2">●</span>
                                    <span>Shipped</span>
                                </div>
                                <small class="text-muted">On the way to you</small>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-success me-2">●</span>
                                    <span>Delivered</span>
                                </div>
                                <small class="text-muted">Successfully delivered</small>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-danger me-2">●</span>
                                    <span>Cancelled</span>
                                </div>
                                <small class="text-muted">Order was cancelled</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection