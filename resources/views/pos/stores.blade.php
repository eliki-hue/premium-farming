@extends('layouts.app', ['mode' => 'pos'])

@section('title', 'Store Inventory')

@push('styles')
<style>
.stock-low { background: linear-gradient(135deg, #fef3c7, #fed7aa); }
.stock-critical { background: linear-gradient(135deg, #fecaca, #fca5a5); }
.stock-ok { background: linear-gradient(135deg, #dcfce7, #bbf7d0); }
</style>
@endpush

@section('content')
<div class="container-fluid py-6">
    <div class="row">
        <!-- Store Sidebar -->
        {{-- <div class="col-md-3">
            @include('pos.sidebar')
        </div> --}}

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-6">
                <div>
                    <h1 class="fw-bold text-4xl text-gray-800 mb-2">Store Inventory</h1>
                    <p class="text-gray-600 mb-0">Total Items: {{ $products->count() }} | Low Stock: {{ $lowStock }}</p>
                </div>
                <a href="{{ route('pos.sell') }}" class="btn btn-success btn-lg px-6">
                    <i class="fas fa-cash-register me-2"></i>Start Sale
                </a>
            </div>

            <!-- Inventory Table -->
            <div class="card shadow-xl border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="border-0 py-4 px-6 font-bold text-gray-700">Product</th>
                                    <th class="border-0 py-4 px-6 font-bold text-gray-700 text-center">Stock</th>
                                    <th class="border-0 py-4 px-6 font-bold text-gray-700 text-center">Price</th>
                                    <th class="border-0 py-4 px-6 font-bold text-gray-700 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr class="hover:bg-gray-50 transition-colors @if($product->stock_quantity <= 5) stock-critical @elseif($product->stock_quantity <= 20) stock-low @else stock-ok @endif">
                                    <td class="py-4 px-6 font-medium">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 text-white w-12 h-12 rounded-2xl d-flex align-items-center justify-content-center me-3 text-xl">
                                                {{ $product->category->icon ?? '📦' }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-gray-800">{{ $product->name }}</div>
                                                <small class="text-muted">{{ $product->category->name ?? 'General' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <span class="fw-bold text-2xl {{ $product->stock_quantity <= 5 ? 'text-red-600' : ($product->stock_quantity <= 20 ? 'text-amber-600' : 'text-emerald-600') }}">
                                                {{ $product->stock_quantity }}
                                            </span>
                                            @if($product->stock_quantity <= 5)
                                            <span class="ms-2 badge bg-danger">CRITICAL</span>
                                            @elseif($product->stock_quantity <= 20)
                                            <span class="ms-2 badge bg-warning">LOW</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="fw-bold text-2xl text-emerald-600">KES {{ number_format($product->price) }}</div>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ route('pos.sell', ['product' => $product->id]) }}" 
                                               class="btn btn-sm btn-success px-3">
                                                <i class="fas fa-cash-register"></i> Sell
                                            </a>
                                            <a href="{{ route('pos.items.edit', $product->id) }}" 
                                               class="btn btn-sm btn-outline-primary px-3">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-12">
                                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                                        <h3 class="text-2xl text-gray-500 mb-2">No products in store</h3>
                                        <a href="{{ route('pos.items.create') }}" class="btn btn-primary">Add First Product</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Stock Summary Cards -->
            <div class="row mt-6 g-4">
                <div class="col-md-4">
                    <div class="card text-center bg-gradient-to-br from-emerald-500 to-green-600 text-white shadow-2xl">
                        <div class="card-body py-6">
                            <i class="fas fa-check-circle text-4xl mb-3 opacity-75"></i>
                            <h3 class="fw-bold text-4xl mb-1">{{ $products->where('stock_quantity', '>', 20)->count() }}</h3>
                            <p class="mb-0 opacity-90">In Stock</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center bg-gradient-to-br from-amber-500 to-orange-600 text-white shadow-2xl">
                        <div class="card-body py-6">
                            <i class="fas fa-exclamation-triangle text-4xl mb-3 opacity-75"></i>
                            <h3 class="fw-bold text-4xl mb-1">{{ $lowStock }}</h3>
                            <p class="mb-0 opacity-90">Low Stock</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center bg-gradient-to-br from-red-500 to-rose-600 text-white shadow-2xl">
                        <div class="card-body py-6">
                            <i class="fas fa-times-circle text-4xl mb-3 opacity-75"></i>
                            <h3 class="fw-bold text-4xl mb-1">{{ $products->where('stock_quantity', 0)->count() }}</h3>
                            <p class="mb-0 opacity-90">Out of Stock</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
