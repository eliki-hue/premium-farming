@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Shopping Cart</h1>
    
    @if(empty($cart))
        <div class="alert alert-info">
            Your cart is empty. <a href="{{ route('products') }}">Continue shopping</a>
        </div>
    @else
        <div class="row">
            <div class="col-md-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>Ksh {{ number_format($item['price']) }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>Ksh {{ number_format($item['price'] * $item['quantity']) }}</td>
                            <td>
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $item['id'] }}">
                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4>Order Summary</h4>
                        <p>Total: <strong>Ksh {{ number_format($total) }}</strong></p>
                        <a href="{{ route('checkout') }}" class="btn btn-primary w-100">Checkout</a>
                        <a href="{{ route('shop.products') }}" class="btn btn-secondary w-100 mt-2">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection