@extends('pos.layout')

@section('title','Stores')

@section('content')
<div class="container-fluid py-6">
    <div class="row">
        <!-- Sidebar (if exists) -->
        @if(isset($mode) && $mode === 'pos')
        <div class="col-md-3">
            @include('pos.sidebar')
        </div>
        @endif

        <!-- Main Content -->
        <div class="col-md-{{ isset($mode) && $mode === 'pos' ? '9' : '12' }}">
            <div class="d-flex justify-content-between align-items-center mb-6">
                <div>
                    <h1 class="fw-bold text-4xl text-gray-800 mb-2">POS - Stores</h1>
                    <!-- ✅ LINE 26 ADDED HERE -->
                    <p class="text-gray-600 mb-0">Total Items: {{ $items->count() }} | Low Stock: {{ $items->where('stock', '<=', 20)->count() }}</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <p class="mb-4 text-gray-600">Manage items available in this store.</p>

            <!-- Create item form -->
            <div class="card mb-4 shadow-lg border-0">
                <div class="card-header bg-gradient-to-r from-blue-500 to-indigo-600 text-white fw-bold">
                    <i class="fas fa-plus-circle me-2"></i>Add Item to Store
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('items.store') }}">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">SKU</label>
                                <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" required>
                                @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Item Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Category</label>
                                <input type="text" name="category" class="form-control @error('category') is-invalid @enderror">
                                @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Price (KES)</label>
                                <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" required>
                                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Stock Quantity</label>
                                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" required min="0">
                                @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 mt-4 fw-bold shadow-lg">
                            <i class="fas fa-save me-2"></i>Save Item to Store
                        </button>
                    </form>
                </div>
            </div>

            <!-- Items table -->
            <div class="card shadow-xl border-0">
                <div class="card-header bg-gradient-to-r from-emerald-500 to-green-600 text-white fw-bold">
                    <i class="fas fa-boxes me-2"></i>Store Items ({{ $items->count() }} total)
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="py-4 px-6 fw-bold text-gray-700">ID</th>
                                    <th class="py-4 px-6 fw-bold text-gray-700">SKU</th>
                                    <th class="py-4 px-6 fw-bold text-gray-700">Product</th>
                                    <th class="py-4 px-6 fw-bold text-gray-700 text-center">Stock</th>
                                    <th class="py-4 px-6 fw-bold text-gray-700 text-center">Price</th>
                                    <th class="py-4 px-6 fw-bold text-gray-700 text-center">Created</th>
                                    <th class="py-4 px-6 fw-bold text-gray-700 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                <tr class="hover:bg-gray-50 transition-all @if($item->stock <= 5) bg-red-50 @elseif($item->stock <= 20) bg-yellow-50 @endif">
                                    <td class="py-4 px-6 font-mono text-sm bg-gray-100 rounded">{{ $item->id }}</td>
                                    <td class="py-4 px-6 font-mono text-sm text-blue-600 fw-bold">{{ $item->sku }}</td>
                                    <td class="py-4 px-6">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 text-white w-10 h-10 rounded-xl d-flex align-items-center justify-content-center me-3 text-lg">
                                                📦
                                            </div>
                                            <div>
                                                <div class="fw-bold text-gray-800">{{ $item->name }}</div>
                                                <small class="text-muted">{{ $item->category }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="fw-bold text-2xl {{ $item->stock <= 5 ? 'text-red-600' : ($item->stock <= 20 ? 'text-amber-600' : 'text-emerald-600') }}">
                                            {{ $item->stock }}
                                        </span>
                                        @if($item->stock <= 5)
                                            <span class="badge bg-danger ms-2">CRITICAL</span>
                                        @elseif($item->stock <= 20)
                                            <span class="badge bg-warning ms-2">LOW</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="fw-bold text-2xl text-emerald-600">KES {{ number_format($item->price, 0) }}</div>
                                    </td>
                                    <td class="py-4 px-6 text-center text-sm text-gray-500">{{ $item->created_at->format('M d, Y') }}</td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-sm btn-success">
                                                <i class="fas fa-cash-register"></i> Sell
                                            </a>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-12">
                                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                                        <h3 class="text-2xl text-gray-500 mb-2">No items in store yet</h3>
                                        <p class="text-muted mb-4">Add your first product above!</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
