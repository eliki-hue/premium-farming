@extends('layouts.app')

@section('content')
<div class="container">
<h3>My Orders</h3>

@foreach($orders as $order)
<div class="card mb-3">
    <div class="card-header">
        Order #{{ $order['id'] }} —
        <strong>{{ strtoupper($order['status']) }}</strong>
    </div>

    <div class="card-body">
        <p>Total: KES {{ $order['total'] }}</p>

        <table class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order['items'] as $item)
                <tr>
                    <td>{{ $item['product_name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>KES {{ $item['price'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endforeach
</div>
@endsection