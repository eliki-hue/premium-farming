@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Checkout</h1>
    
    @if(empty($cart))
        <div class="alert alert-info">
            Your cart is empty. <a href="{{ route('products') }}">Browse products</a>
        </div>
    @else
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('checkout.place.order') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="customer_name" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="customer_email" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="tel" name="customer_phone" class="form-control" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Payment Method</label>
                                <select name="payment_method" class="form-select" required>
                                    <option value="mpesa">M-Pesa</option>
                                    <option value="bank">Bank Transfer</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-success btn-lg w-100">
                                Place Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        @foreach($cart as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                            <span>KSh {{ number_format($item['price'] * $item['quantity']) }}</span>
                        </div>
                        @endforeach
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>KSh {{ number_format($subtotal) }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>VAT (16%)</span>
                            <span>KSh {{ number_format($tax) }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span class="text-success">KSh {{ number_format($total) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection