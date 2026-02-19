@extends('layout')

@section('title','Products')

@section('content')
<h1 class="mb-4">Products</h1>

<div class="row">
    @foreach($products as $product)
        <div class="col-md-4 mb-3">
            <div class="card h-100">

                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>

                    <p class="card-text">
                        {{ \Illuminate\Support\Str::limit($product->description, 120) }}
                    </p>

                    <p class="fw-bold">
                        KES {{ number_format($product->price, 2) }}
                    </p>

                    <a href="{{ route('products.show', $product) }}"
                       class="btn btn-sm btn-primary">
                        View
                    </a>
                </div>

            </div>
        </div>
    @endforeach
</div>

{{-- Pagination --}}
<div class="mt-4">
    {{ $products->links() }}
</div>

@endsection


    @php
    $cartCount = 0;
    $cartTotal = 0;
    $cartItems = [];
    
    if(session()->has('cart')) {
        $cartItems = session('cart', []);
        $cartCount = count($cartItems);
        
        foreach($cartItems as $item) {
            $cartTotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        }
    }
@endphp

after right reserved
                <div class="modal-body">
                    @if($cartCount > 0)
                        <div class="list-group">
                            @foreach($cartItems as $id => $item)
                                @php
                                    $lineTotal = ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
                                @endphp
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold">{{ $item['name'] ?? 'Product' }}</div>
                                            <small class="text-muted">Qty: {{ $item['quantity'] ?? 1 }} × KSh {{ number_format($item['price'] ?? 0) }}</small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold text-success">KSh {{ number_format($lineTotal) }}</div>
                                            <div class="mt-1">
                                                <button class="btn btn-sm btn-outline-danger" onclick="removeFromCart('{{ $id }}')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-3 p-3 bg-light rounded">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span class="fw-bold">KSh {{ number_format($cartTotal) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>VAT (16%):</span>
                                <span>KSh {{ number_format($cartTotal * 0.16) }}</span>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-2">
                                <span class="fw-bold">Total:</span>
                                <span class="fw-bold text-success">KSh {{ number_format($cartTotal * 1.16) }}</span>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 mt-3">
                            <a href="{{ route('checkout') }}" class="btn btn-success">Checkout Now</a>
                            <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Continue Shopping</button>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-cart-x display-1 text-muted"></i>
                            <p class="mt-3">Your cart is empty</p>
                            <a href="{{ route('products') }}" class="btn btn-success mt-2">Start Shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>ews
    <li class="nav-item">
                        <div class="navbar-cart-container">
                            <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#cartModal">
                                <i class="bi bi-cart3"></i>
                                @if($cartCount > 0)
                                    <span class="cart-badge">{{ $cartCount }}</span>
                                @endif
                            </button>
                        </div>
                    </li>
    after revi

      <script>
    function removeFromCart(id) {
        fetch('/cart/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            }
        });
    }
    </script>
