@extends('layouts.app')

@section('content')

@php
$categories = [
    'Poultry Feeds' => [
        'Chick Mash 50kg',
        'Growers Mash 50kg',
        'Layers Mash 50kg',
        'Super Layers 50kg',
    ],
    'Pig Feeds' => [
        'Pig Starter 50kg',
        'Pig Grower 50kg',
        'Pig Fattener 50kg',
        'Sow & Weaner 50kg',
    ],
    'Pet Feeds' => [
        'Dog Meal 20kg',
        'Dog Meal 10kg',
    ],
    'By-Products' => [
        'Maize Germ',
        'Wheat Bran',
        'Pollard',
    ],
];
@endphp

<style>
.panel{background:#fff;padding:15px;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,.1)}
.cart-item{display:flex;justify-content:space-between}
.total-box{background:#2563eb;color:#fff;padding:12px;border-radius:6px;text-align:center;font-weight:bold}
</style>

<div class="container">

<h4 class="fw-bold text-primary mb-3">POS – New Sale</h4>

{{-- ADD ITEM --}}
<div class="panel mb-4">
<h6 class="fw-bold mb-3">Add Item</h6>

<form method="POST" action="{{ route('cart.add') }}" class="row g-2">
@csrf

<div class="col-md-3">
<label class="form-label">Category</label>
<select id="categorySelect" class="form-select">
<option value="">Select Category</option>
@foreach($categories as $cat => $items)
<option value="{{ $cat }}">{{ $cat }}</option>
@endforeach
</select>
</div>

<div class="col-md-3">
<label class="form-label">Product</label>
<select id="productSelect" class="form-select">
<option value="">Select Product</option>
</select>
</div>

<div class="col-md-2">
<label class="form-label">Quantity</label>
<input name="quantity" type="number" value="1" class="form-control">
</div>

<div class="col-md-2">
<label class="form-label">Unit</label>
<select name="unit" class="form-select">
<option>kg</option>
<option>bag</option>
<option>pcs</option>
</select>
</div>

<div class="col-md-2">
<label class="form-label">Price</label>
<input name="price" type="number" class="form-control" placeholder="Price">
</div>

{{-- hidden product name --}}
<input type="hidden" name="name" id="productName">

<div class="col-md-12">
<button class="btn btn-success w-100 mt-2">Add to Sale</button>
</div>

</form>
</div>

{{-- CURRENT SALE --}}
<div class="panel mb-4">
<h6 class="fw-bold mb-3">Current Sale</h6>

@php $total=0; @endphp
@forelse(session('cart',[]) as $item)
@php $total += $item['price']*$item['quantity']; @endphp
<div class="cart-item">
<span>{{ $item['name'] }} ({{ $item['quantity'] }} {{ $item['unit'] }})</span>
<span>Ksh {{ number_format($item['price']*$item['quantity']) }}</span>
</div>
@empty
<p class="text-muted">No items</p>
@endforelse

<hr>

<div class="total-box mb-3">
TOTAL: Ksh {{ number_format($total) }}
</div>

<form method="POST" action="{{ route('cart.complete') }}">
@csrf
<input name="amount_paid" class="form-control mb-2" placeholder="Amount Paid">
<button class="btn btn-success w-100">Complete Sale</button>
</form>

<div class="d-flex gap-2 mt-2">
<form method="POST" action="{{ route('cart.hold') }}" class="w-50">@csrf
<button class="btn btn-warning w-100">Hold</button>
</form>

<form method="POST" action="{{ route('cart.clear') }}" class="w-50">@csrf
<button class="btn btn-danger w-100">Clear</button>
</form>
</div>
</div>

{{-- HELD SALES --}}
<div class="panel">
<h6 class="fw-bold mb-3">Held Sales</h6>

@forelse(session('holds',[]) as $id=>$sale)
<form method="POST" action="{{ route('cart.resume',$id) }}">
@csrf
<button class="btn btn-outline-primary w-100 mb-2">
{{ $id }} – {{ $sale['time'] }}
</button>
</form>
@empty
<p class="text-muted">No held sales</p>
@endforelse
</div>

</div>

{{-- JS --}}
<script>
const data = @json($categories);

const categorySelect = document.getElementById('categorySelect');
const productSelect  = document.getElementById('productSelect');
const productName    = document.getElementById('productName');

categorySelect.addEventListener('change', function () {
    productSelect.innerHTML = '<option value="">Select Product</option>';

    if (!this.value) return;

    data[this.value].forEach(item => {
        const opt = document.createElement('option');
        opt.value = item;
        opt.textContent = item;
        productSelect.appendChild(opt);
    });
});

productSelect.addEventListener('change', function () {
    productName.value = this.value;
});
</script>

@endsection
