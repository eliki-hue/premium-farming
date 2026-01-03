@extends('layouts.pos')

@section('page-title', 'Products')
@section('content')
<div class="pos-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>📦 Products</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="fas fa-plus me-2"></i> Add Product
        </button>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Unit</th>
                    <th>Category</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>KSh {{ number_format($product->selling_price) }}</td>
                    <td>
                        <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td>{{ $product->unit }}</td>
                    <td>{{ $product->category }}</td>
                </tr>
                @endforeach
                @if($products->isEmpty())
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        No products found. Add your first product!
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection