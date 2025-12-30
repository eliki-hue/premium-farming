@extends('layouts.pos-dashboard')

@section('content')
<div class="container-fluid">
    <!-- POS DASHBOARD HEADER -->
    <div class="row mb-5">
        <div class="col-lg-8">
            <div class="d-flex align-items-center h-100">
                <div>
                    <h1 class="display-4 fw-bold mb-1 text-green-700">🐄 POS Dashboard</h1>
                    <p class="lead text-muted mb-0">Premium Farming Feeds - Turitu | Githiga | Ikinu</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 text-lg-end">
            <div class="btn-group" role="group">
                <a href="{{ route('pos.sell') }}" class="btn btn-success btn-lg px-4">
                    <i class="fas fa-cash-register me-2"></i>Start POS Sale
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg px-4">
                    <i class="fas fa-boxes me-2"></i>Manage Products
                </a>
            </div>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 text-center bg-gradient-green">
                <div class="card-body py-4">
                    <i class="fas fa-shopping-cart fa-3x text-white mb-3"></i>
                    <h3 class="text-white fw-bold mb-1">{{ rand(45, 78) }}</h3>
                    <p class="text-white-50 mb-0">Today's Sales</p>
                    <small class="text-white-50">KSh {{ number_format(rand(25000, 85000)) }}</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 text-center bg-gradient-orange">
                <div class="card-body py-4">
                    <i class="fas fa-box fa-3x text-white mb-3"></i>
                    <h3 class="text-white fw-bold mb-1">{{ rand(120, 250) }}</h3>
                    <p class="text-white-50 mb-0">Total Products</p>
                    <small class="text-white-50">45 Low Stock</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 text-center bg-gradient-blue">
                <div class="card-body py-4">
                    <i class="fas fa-users fa-3x text-white mb-3"></i>
                    <h3 class="text-white fw-bold mb-1">{{ rand(12, 35) }}</h3>
                    <p class="text-white-50 mb-0">Today's Customers</p>
                    <small class="text-white-50">78% Repeat</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 text-center bg-gradient-purple">
                <div class="card-body py-4">
                    <i class="fas fa-chart-line fa-3x text-white mb-3"></i>
                    <h3 class="text-white fw-bold mb-1">+{{ rand(12, 28) }}%</h3>
                    <p class="text-white-50 mb-0">Sales Growth</p>
                    <small class="text-white-50">vs Last Week</small>
                </div>
            </div>
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="mb-3"><i class="fas fa-bolt text-success me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('pos.sell') }}" class="btn btn-success w-100 py-3">
                                <i class="fas fa-cash-register fa-2x d-block mb-2"></i>
                                <span class="fw-bold">New Sale</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('products.index') }}" class="btn btn-primary w-100 py-3">
                                <i class="fas fa-plus-circle fa-2x d-block mb-2"></i>
                                <span class="fw-bold">Add Product</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="btn btn-warning w-100 py-3">
                                <i class="fas fa-sync-alt fa-2x d-block mb-2"></i>
                                <span class="fw-bold">Restock</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="btn btn-info w-100 py-3">
                                <i class="fas fa-receipt fa-2x d-block mb-2"></i>
                                <span class="fw-bold">Reports</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="btn btn-outline-secondary w-100 py-3">
                                <i class="fas fa-users fa-2x d-block mb-2"></i>
                                <span class="fw-bold">Customers</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="#" class="btn btn-dark w-100 py-3">
                                <i class="fas fa-warehouse fa-2x d-block mb-2"></i>
                                <span class="fw-bold">Stock Check</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle text-warning me-2"></i>Low Stock Alert</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @for($i = 0; $i < 5; $i++)
                        <div class="list-group-item px-0 border-0 py-2">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-20 p-2 rounded-circle me-3">
                                    <i class="fas fa-exclamation-triangle text-warning"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold text-dark">Layers Mash 50kg</div>
                                    <small class="text-muted">Only 3 bags left</small>
                                </div>
                                <span class="badge bg-warning text-dark ms-2">URGENT</span>
                            </div>
                        </div>
                        @endfor
                    </div>
                    <a href="#" class="btn btn-outline-warning w-100 mt-3">View All Alerts</a>
                </div>
            </div>
        </div>
    </div>

    <!-- RECENT SALES -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="mb-3"><i class="fas fa-receipt text-primary me-2"></i>Recent Transactions</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Method</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i = 1; $i <= 5; $i++)
                                <tr>
                                    <td><span class="badge bg-primary">ORD{{ 1000 + $i }}</span></td>
                                    <td>John Doe</td>
                                    <td>3 items</td>
                                    <td><strong>KSh {{ number_format(rand(2500, 8500)) }}</strong></td>
                                    <td>
                                        <span class="badge bg-success">M-Pesa</span>
                                    </td>
                                    <td>{{ now()->subMinutes(rand(1, 120))->format('H:i') }}</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="#" class="btn btn-outline-primary">View All Sales</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.bg-gradient-green { background: linear-gradient(135deg, #28a745, #20c997); }
.bg-gradient-orange { background: linear-gradient(135deg, #fd7e14, #e8630b); }
.bg-gradient-blue { background: linear-gradient(135deg, #0d6efd, #0b5ed7); }
.bg-gradient-purple { background: linear-gradient(135deg, #6f42c1, #5a2d91); }
.text-white-50 { color: rgba(255,255,255,.5) !important; }
</style>
@endpush
