@extends('layouts.app')

@section('content')
<div class="container">

    <h4 class="fw-bold text-primary mb-4">
        Product Conversion (Bag → KG)
    </h4>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Conversion Form --}}
    <form method="POST"
          action="{{ route('pos.convert.store') }}"
          class="bg-white p-4 rounded shadow"
          style="max-width:520px">

        @csrf

        {{-- Product --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">
                Product Name
            </label>
            <select name="product_name" class="form-select" required>
                <option value="">-- Select Product --</option>
                @foreach($products as $product)
                    <option value="{{ $product->name }}">
                        {{ $product->name }} ({{ $product->quantity }} bags)
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Bag Weight --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">
                Weight per Bag (KG)
            </label>
            <input type="number"
                   name="bag_weight"
                   class="form-control"
                   placeholder="e.g. 50"
                   min="1"
                   required>
        </div>

        {{-- Number of Bags --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">
                Number of Bags to Convert
            </label>
            <input type="number"
                   name="bags"
                   class="form-control"
                   value="1"
                   min="1"
                   required>
        </div>

        {{-- Info --}}
        <div class="alert alert-info small">
            ⚠️ This will:
            <ul class="mb-0">
                <li>Reduce bag stock</li>
                <li>Increase KG stock</li>
                <li>Make KG available in POS automatically</li>
            </ul>
        </div>

        {{-- Submit --}}
        <button class="btn btn-primary w-100 fw-semibold">
            Convert to Kilograms
        </button>

    </form>

</div>
@endsection
