@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1>Shopping Cart</h1>

    @if(empty($cartData['items']))
        <p>Your cart is empty</p>
    @else
        <div class="row">
            <div class="col-md-8">
                @foreach($cartData['items'] as $item)
                    <div class="card mb-3">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5>{{ $item['product']['name'] }}</h5>
                                <p>KES {{ number_format($item['product']['price']) }}</p>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <button onclick="updateQty({{ $item['id'] }}, {{ $item['quantity'] - 1 }})">−</button>

                                <strong>{{ $item['quantity'] }}</strong>

                                <button onclick="updateQty({{ $item['id'] }}, {{ $item['quantity'] + 1 }})">+</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-4">
                <div class="card p-3">
                    <h4>Total</h4>
                    <h2>KES {{ number_format($cartData['total']) }}</h2>

                    <a href="/checkout" class="btn btn-success w-100 mt-3">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function updateQty(itemId, qty) {
    if (qty < 1) return;

    fetch(`/cart/update/${itemId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ quantity: qty })
    }).then(() => location.reload());
}
</script>
@endsection
