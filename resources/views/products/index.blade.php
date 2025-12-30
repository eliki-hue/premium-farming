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
