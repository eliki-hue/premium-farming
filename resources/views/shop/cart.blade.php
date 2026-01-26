@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<section class="cart-section py-5">
    <div class="container">

        <h1 class="mb-4">Shopping Cart</h1>

        @if(empty($cartData['items']))
            <div class="alert alert-info text-center">
                Your cart is empty
                <br>
                <a href="{{ route('products.index') }}" class="btn btn-success mt-3">
                    Continue Shopping
                </a>
            </div>
        @else
            <div class="row">

                <!-- CART ITEMS -->
                <div class="col-lg-8">
                    @foreach($cartData['items'] as $item)
                        <div class="card mb-3">
                            <div class="card-body d-flex align-items-center">

                                <img
                                    src="{{ $item['product']['image'] ?? 'https://via.placeholder.com/120' }}"
                                    width="120"
                                    class="me-3 rounded"
                                >

                                <div class="flex-grow-1">
                                    <h5 class="mb-1">{{ $item['product']['name'] }}</h5>
                                    <p class="mb-1 text-muted">
                                        KES {{ number_format($item['product']['unit_price']) }}
                                    </p>

                                    <input
                                        type="number"
                                        min="1"
                                        value="{{ $item['quantity'] }}"
                                        class="form-control w-25 update-qty"
                                        data-id="{{ $item['id'] }}"
                                    >
                                </div>

                                <div class="fw-bold text-success">
                                    KES {{ number_format($item['total_price']) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- SUMMARY -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5>Summary</h5>
                            <hr>

                            <p class="d-flex justify-content-between">
                                <span>Subtotal</span>
                                <strong>KES {{ number_format($cartData['subtotal']) }}</strong>
                            </p>

                            <p class="d-flex justify-content-between">
                                <span>Total</span>
                                <strong class="text-success">
                                    KES {{ number_format($cartData['total']) }}
                                </strong>
                            </p>

                            <a href="{{ route('checkout.index') }}"
                               class="btn btn-success w-100">
                                Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        @endif

    </div>
</section>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.update-qty').forEach(input => {
    input.addEventListener('change', function () {

        fetch("{{ route('cart.update') }}", {
            method: "PATCH",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                item_id: this.dataset.id,
                quantity: this.value
            })
        }).then(() => location.reload());
    });
});
</script>
@endpush
