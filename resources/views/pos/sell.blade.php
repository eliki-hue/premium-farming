@extends('layouts.app')

@section('content')
@php
$products = collect([
    ['name'=>'Chick Mash 50kg','price'=>1700],
    ['name'=>'Growers Mash 50kg','price'=>1800],
    ['name'=>'Layers Mash 50kg','price'=>1850],
    ['name'=>'Pig Fattener 50kg','price'=>2600],
    ['name'=>'Dog Meal 20kg','price'=>2200],
    ['name'=>'Maize Germ','price'=>1200],
]);
@endphp

<style>
.pos-layout{display:grid;grid-template-columns:65% 35%;gap:20px}
.panel{background:#fff;padding:15px;border-radius:8px;box-shadow:0 2px 6px rgba(0,0,0,.1)}
.cart-item{display:flex;justify-content:space-between}
.total-box{background:#2563eb;color:#fff;padding:12px;border-radius:6px;text-align:center;font-weight:bold}
</style>

<div class="container-fluid">
<h4 class="fw-bold text-primary mb-3">Point of Sale</h4>

<div class="pos-layout">

<!-- LEFT -->
<div>

<!-- ADD ITEM MANUALLY -->
<div class="panel mb-4">
<h6 class="fw-bold mb-3">Add Item (Manual)</h6>

<form action="{{ route('cart.add') }}" method="POST" class="d-flex flex-wrap gap-2 align-items-end">
@csrf

<div style="min-width:260px;flex:1">
<label class="form-label">Product Name</label>
<input type="text" name="name" class="form-control" placeholder="Enter product name" required>
</div>

<div style="width:90px">
<label class="form-label">Qty</label>
<input name="quantity" type="number" class="form-control" value="1" min="1">
</div>

<div style="width:100px">
<label class="form-label">Unit</label>
<select name="unit" class="form-select">
<option>bag</option>
<option>kg</option>
<option>pcs</option>
</select>
</div>

<div style="width:120px">
<label class="form-label">Unit Price</label>
<input name="price" type="number" class="form-control" required>
</div>

<button class="btn btn-success">Add Item</button>
</form>
</div>

<!-- QUICK PRODUCTS (OPTIONAL) -->
<div class="panel mb-4">
<h6 class="fw-bold mb-3">Quick Add</h6>
<table class="table table-sm">
@foreach($products as $p)
<tr>
<td>{{ $p['name'] }}</td>
<td>Ksh {{ number_format($p['price']) }}</td>
<td>
<form action="{{ route('cart.add') }}" method="POST">
@csrf
<input type="hidden" name="name" value="{{ $p['name'] }}">
<input type="hidden" name="price" value="{{ $p['price'] }}">
<input type="hidden" name="quantity" value="1">
<button class="btn btn-sm btn-primary">+</button>
</form>
</td>
</tr>
@endforeach
</table>
</div>

<!-- CURRENT SALE -->
<div class="panel">
<h6 class="fw-bold mb-3">Current Sale</h6>

@php $total=0; @endphp
@forelse(session('cart',[]) as $item)
@php $total += $item['price']*$item['quantity']; @endphp
<div class="cart-item">
<span>
    {{ $item['name'] }}
    ({{ $item['quantity'] }} {{ $item['unit'] ?? 'pcs' }})
</span>
<span>Ksh {{ number_format($item['price']*$item['quantity']) }}</span>
</div>
@empty
<p class="text-muted">No items</p>
@endforelse

<hr>

<div class="total-box mb-3">
TOTAL: Ksh {{ number_format($total) }}
</div>

<form action="{{ route('cart.complete') }}" method="POST">
@csrf
<input type="number" name="amount_paid" class="form-control mb-2" placeholder="Amount Paid" required>
<button class="btn btn-success w-100 mb-2">Complete Sale</button>
</form>

<div class="d-flex gap-2">
<form action="{{ route('cart.hold') }}" method="POST" class="w-50">@csrf
<button class="btn btn-warning w-100">Hold</button>
</form>

<form action="{{ route('cart.clear') }}" method="POST" class="w-50">@csrf
<button class="btn btn-danger w-100">Clear</button>
</form>
</div>
</div>

</div>

<!-- RIGHT -->
<div class="panel">
<h6 class="fw-bold mb-3">Held Sales</h6>

@forelse(session('holds',[]) as $id=>$sale)
<form action="{{ route('cart.resume',$id) }}" method="POST">
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
</div>
@endsection
