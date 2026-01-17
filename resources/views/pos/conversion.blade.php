@extends('layouts.pos')

@section('content')
<div class="container">

<h4 class="fw-bold text-primary mb-3">Bag to KG Conversion (Dummy)</h4>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form method="POST" action="{{ route('pos.convert.store') }}"
      class="bg-white p-4 rounded shadow" style="max-width:500px">
@csrf

<div class="mb-3">
    <label class="form-label">Product</label>
    <select name="product_name" class="form-select" required>
        @foreach($products as $p)
            <option value="{{ $p['name'] }}">
                {{ $p['name'] }} ({{ $p['quantity'] }} kg available)
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Bag Weight (KG)</label>
    <input type="number" name="bag_weight" class="form-control" placeholder="e.g. 50" required>
</div>

<div class="mb-3">
    <label class="form-label">Number of Bags</label>
    <input type="number" name="bags" class="form-control" value="1" required>
</div>

<button class="btn btn-primary w-100">Convert to KG & Add to POS</button>
</form>

</div>
@endsection
