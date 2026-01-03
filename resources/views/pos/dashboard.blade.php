@extends('layouts.pos')

@section('page-title', 'Dashboard')
@section('content')
<div class="pos-card">
    <div class="container-fluid">
        <!-- Stats Cards -->
        <div class="stats-grid mb-4">
            @php
                // Get today's date
                $today = now()->format('Y-m-d');
                
                // Get today's sales (you'll need to adjust this based on your actual Order model)
                $todaySales = 0; // Placeholder - replace with actual query
                
                // Get today's transactions
                $todayTransactions = 0; // Placeholder - replace with actual query
                
                // Get low stock products (stock <= 5)
                $lowStockProducts = \App\Models\PosProduct::where('stock', '<=', 5)->get();
                
                // Get today's customers
                $todayCustomers = 0; // Placeholder - you don't have an orders table yet
                
                // Get total products
                $totalProducts = \App\Models\PosProduct::count();
                
                // Get in stock products
                $inStockProducts = \App\Models\PosProduct::where('stock', '>', 0)->count();
                
                // Get out of stock products
                $outOfStockProducts = \App\Models\PosProduct::where('stock', '<=', 0)->count();
            @endphp
            
            <div class="stat-card bg-primary text-white">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-value">KSh {{ number_format($todaySales) }}</div>
                <div class="stat-label">Today's Sales</div>
            </div>
            
            <div class="stat-card bg-success text-white">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-value">{{ $todayTransactions }}</div>
                <div class="stat-label">Today's Orders</div>
            </div>
            
            <div class="stat-card bg-warning text-white">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-value">{{ $lowStockProducts->count() }}</div>
                <div class="stat-label">Low Stock Items</div>
            </div>
            
            <div class="stat-card bg-info text-white">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value">{{ $todayCustomers }}</div>
                <div class="stat-label">Today's Customers</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-4">
            <h5 class="mb-3">Quick Actions</h5>
            <div class="quick-actions d-flex flex-wrap gap-3">
                <a href="{{ route('pos.sell') }}" class="action-btn btn btn-primary btn-lg d-flex flex-column align-items-center justify-content-center p-4">
                    <i class="fas fa-cash-register fa-2x mb-2"></i>
                    <span>New Sale</span>
                </a>
                
                <button class="action-btn btn btn-success btn-lg d-flex flex-column align-items-center justify-content-center p-4" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="fas fa-plus-circle fa-2x mb-2"></i>
                    <span>Add Product</span>
                </button>
                
                <a href="{{ route('pos.orders') }}" class="action-btn btn btn-info btn-lg d-flex flex-column align-items-center justify-content-center p-4">
                    <i class="fas fa-receipt fa-2x mb-2"></i>
                    <span>View Orders</span>
                </a>
                
                <a href="{{ route('pos.reports') }}" class="action-btn btn btn-warning btn-lg d-flex flex-column align-items-center justify-content-center p-4">
                    <i class="fas fa-chart-bar fa-2x mb-2"></i>
                    <span>Sales Report</span>
                </a>
            </div>
        </div>

        <!-- Low Stock Alert -->
        @if($lowStockProducts->count() > 0)
        <div class="alert alert-warning mb-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                <div>
                    <h6 class="alert-heading mb-1">⚠️ Low Stock Alert!</h6>
                    <p class="mb-0">{{ $lowStockProducts->count() }} products are running low on stock.</p>
                </div>
                <a href="{{ route('pos.products') }}" class="btn btn-warning btn-sm ms-auto">
                    View Products
                </a>
            </div>
        </div>
        @endif

        <!-- Recent Products -->
        <div class="table-card mb-4">
            <h5>Recent Products</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $recentProducts = \App\Models\PosProduct::orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp
                        
                        @forelse($recentProducts as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td class="fw-bold">KSh {{ number_format($product->selling_price) }}</td>
                            <td>
                                <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $product->stock }} {{ $product->unit }}
                                </span>
                            </td>
                            <td>
                                @if($product->stock > 10)
                                    <span class="badge bg-success">In Stock</span>
                                @elseif($product->stock > 0)
                                    <span class="badge bg-warning">Low Stock</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="fas fa-box fa-2x mb-3"></i>
                                <p>No products found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Today's Summary -->
        <div class="row mt-4">
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="fas fa-chart-pie text-primary me-2"></i>
                            Sales Summary (Today)
                        </h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Cash Sales:</span>
                            <strong>KSh 0</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>M-Pesa Sales:</span>
                            <strong>KSh 0</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Total Sales:</span>
                            <strong class="text-success">KSh 0</strong>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="fas fa-boxes text-warning me-2"></i>
                            Stock Status
                        </h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Products:</span>
                            <strong>{{ $totalProducts }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>In Stock:</span>
                            <strong class="text-success">{{ $inStockProducts }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Out of Stock:</span>
                            <strong class="text-danger">{{ $outOfStockProducts }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Products by Stock -->
        <div class="table-card">
            <h5>Top Products (Most Stock)</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Total Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $topStockProducts = \App\Models\PosProduct::orderBy('stock', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp
                        
                        @foreach($topStockProducts as $index => $product)
                        <tr>
                            <td>
                                <span class="badge bg-primary">#{{ $index + 1 }}</span>
                            </td>
                            <td>{{ $product->name }}</td>
                            <td class="fw-bold">{{ $product->stock }} {{ $product->unit }}</td>
                            <td>KSh {{ number_format($product->selling_price) }}</td>
                            <td class="text-success">KSh {{ number_format($product->stock * $product->selling_price) }}</td>
                        </tr>
                        @endforeach
                        
                        @if($topStockProducts->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="fas fa-chart-line fa-2x mb-3"></i>
                                <p>No products found</p>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        opacity: 0.8;
    }
    
    .stat-value {
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
    }
    
    .action-btn {
        text-decoration: none;
        color: #333;
        text-align: center;
        padding: 20px 10px;
        border-radius: 10px;
        background: white;
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }
    
    .action-btn:hover {
        background: #f8f9fa;
        border-color: #0d6efd;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .action-btn i {
        margin-bottom: 10px;
        color: #0d6efd;
    }
    
    .action-btn span {
        display: block;
        font-weight: 500;
    }
    
    .table-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    
    .table-card h5 {
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script>
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // F1 - Quick sale
        if (e.key === 'F1') {
            e.preventDefault();
            window.location.href = "{{ route('pos.sell') }}";
        }
        
        // F2 - Products
        if (e.key === 'F2') {
            e.preventDefault();
            window.location.href = "{{ route('pos.products') }}";
        }
        
        // F3 - Orders
        if (e.key === 'F3') {
            e.preventDefault();
            window.location.href = "{{ route('pos.orders') }}";
        }
        
        // F4 - Dashboard
        if (e.key === 'F4') {
            e.preventDefault();
            window.location.href = "{{ route('pos.dashboard') }}";
        }
        
        // Ctrl + P - Add Product
        if (e.ctrlKey && e.key === 'p') {
            e.preventDefault();
            $('#addProductModal').modal('show');
        }
    });
    
    // Auto-refresh dashboard every 60 seconds
    setTimeout(function() {
        window.location.reload();
    }, 60000);
</script>
@endpush
@endsection