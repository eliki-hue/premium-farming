@extends('layouts.app')

@section('title', 'Order Details - Premium Farming Feeds')

@section('content')
<div class="min-h-screen pt-24 bg-gray-50">
    <div class="container py-8">
        <div class="row">
            <div class="col-12">
                <!-- Back Button -->
                <div class="mb-4">
                    <a href="{{ route('checkout.orders') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Back to Orders
                    </a>
                </div>

                <!-- Order Header -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="h4 mb-1">Order #{{ $order['order_id'] }}</h1>
                                <p class="text-muted mb-0">
                                    Placed on {{ date('F d, Y \a\t H:i', strtotime($order['order_date'])) }}
                                </p>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $order['status'] == 'delivered' ? 'success' : 'warning' }} fs-6">
                                    {{ ucfirst($order['status']) }}
                                </span>
                                <div class="mt-2">
                                    <strong>Ksh {{ number_format($order['totals']['total']) }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Left Column: Order Items & Status -->
                    <div class="col-lg-8">
                        <!-- Order Items -->
                        <div class="card mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Order Items</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-end">Price</th>
                                                <th class="text-end">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order['items'] as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset($item['image'] ?? 'images/default-product.jpg') }}" 
                                                             alt="{{ $item['name'] }}" 
                                                             class="rounded me-3" 
                                                             style="width: 50px; height: 50px; object-fit: cover;">
                                                        <div>
                                                            <strong>{{ $item['name'] }}</strong>
                                                            <div class="small text-muted">
                                                                Product ID: {{ $item['id'] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center align-middle">
                                                    {{ $item['quantity'] }}
                                                </td>
                                                <td class="text-end align-middle">
                                                    Ksh {{ number_format($item['price']) }}
                                                </td>
                                                <td class="text-end align-middle">
                                                    <strong>Ksh {{ number_format($item['price'] * $item['quantity']) }}</strong>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Order Timeline -->
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Order Timeline</h5>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    @php
                                        $timeline = [
                                            'order_placed' => [
                                                'icon' => 'bi-cart-check',
                                                'title' => 'Order Placed',
                                                'date' => $order['order_date'],
                                                'active' => true
                                            ],
                                            'payment_confirmed' => [
                                                'icon' => 'bi-credit-card',
                                                'title' => 'Payment Confirmed',
                                                'date' => date('Y-m-d H:i:s', strtotime($order['order_date'] . ' +30 minutes')),
                                                'active' => $order['payment']['status'] == 'completed'
                                            ],
                                            'processing' => [
                                                'icon' => 'bi-gear',
                                                'title' => 'Processing',
                                                'date' => date('Y-m-d H:i:s', strtotime($order['order_date'] . ' +1 hour')),
                                                'active' => in_array($order['status'], ['processing', 'shipped', 'delivered'])
                                            ],
                                            'shipped' => [
                                                'icon' => 'bi-truck',
                                                'title' => 'Shipped',
                                                'date' => date('Y-m-d H:i:s', strtotime($order['order_date'] . ' +1 day')),
                                                'active' => in_array($order['status'], ['shipped', 'delivered'])
                                            ],
                                            'delivered' => [
                                                'icon' => 'bi-check-circle',
                                                'title' => 'Delivered',
                                                'date' => date('Y-m-d H:i:s', strtotime($order['order_date'] . ' +2 days')),
                                                'active' => $order['status'] == 'delivered'
                                            ]
                                        ];
                                    @endphp

                                    @foreach($timeline as $step)
                                    <div class="timeline-item {{ $step['active'] ? 'active' : '' }}">
                                        <div class="timeline-icon">
                                            <i class="bi {{ $step['icon'] }}"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h6 class="mb-1">{{ $step['title'] }}</h6>
                                            <p class="text-muted mb-0 small">
                                                {{ date('M d, Y H:i', strtotime($step['date'])) }}
                                            </p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Order Summary & Details -->
                    <div class="col-lg-4">
                        <!-- Order Summary -->
                        <div class="card mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Order Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <span>Ksh {{ number_format($order['totals']['subtotal']) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping</span>
                                    <span>Ksh {{ number_format($order['totals']['shipping']) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax (16% VAT)</span>
                                    <span>Ksh {{ number_format($order['totals']['tax']) }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-0">
                                    <strong>Total</strong>
                                    <strong class="h5">Ksh {{ number_format($order['totals']['total']) }}</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="card mb-4">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Customer Information</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-2">
                                    <i class="bi bi-person me-2"></i>
                                    <strong>{{ $order['customer']['name'] }}</strong>
                                </p>
                                <p class="mb-2">
                                    <i class="bi bi-telephone me-2"></i>
                                    {{ $order['customer']['phone'] }}
                                </p>
                                <p class="mb-2">
                                    <i class="bi bi-envelope me-2"></i>
                                    {{ $order['customer']['email'] }}
                                </p>
                                <hr>
                                <h6 class="mb-2">Delivery Address</h6>
                                <p class="mb-1">{{ $order['customer']['address'] }}</p>
                                <p class="mb-1">{{ $order['customer']['town'] }}, {{ $order['customer']['county'] }} County</p>
                                <p class="mb-0">
                                    <strong>Delivery Type:</strong> 
                                    {{ ucfirst(str_replace('_', ' ', $order['delivery']['type'])) }}
                                </p>
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Payment Information</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-2">
                                    <strong>Method:</strong>
                                    @if($order['payment']['method'] == 'mpesa')
                                        M-Pesa
                                        @if($order['payment']['mpesa_number'])
                                            ({{ $order['payment']['mpesa_number'] }})
                                        @endif
                                    @elseif($order['payment']['method'] == 'cash')
                                        Cash on Delivery
                                    @elseif($order['payment']['method'] == 'bank')
                                        Bank Transfer
                                    @else
                                        {{ ucfirst($order['payment']['method']) }}
                                    @endif
                                </p>
                                <p class="mb-0">
                                    <strong>Status:</strong>
                                    <span class="badge bg-{{ $order['payment']['status'] == 'completed' ? 'success' : 'warning' }}">
                                        {{ ucfirst($order['payment']['status']) }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-4">
                            <div class="d-grid gap-2">
                                <a href="{{ route('checkout.receipt', $order['order_id']) }}" 
                                   class="btn btn-outline-primary">
                                    <i class="bi bi-receipt me-2"></i> View Receipt
                                </a>
                                <button onclick="window.print()" class="btn btn-outline-secondary">
                                    <i class="bi bi-printer me-2"></i> Print Order
                                </button>
                                @if($order['status'] == 'processing')
                                <button class="btn btn-outline-danger">
                                    <i class="bi bi-x-circle me-2"></i> Cancel Order
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    
    .timeline-item.active .timeline-icon {
        background-color: #2a6e3f;
        color: white;
    }
    
    .timeline-icon {
        position: absolute;
        left: -30px;
        top: 0;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
    }
    
    .timeline-content {
        padding-left: 20px;
    }
</style>
@endsection