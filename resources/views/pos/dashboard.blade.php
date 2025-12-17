@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid p-4">
    <!-- Header -->
    <div class="mb-4">
        <h1 class="display-5 fw-bold">Dashboard</h1>
        <p class="text-muted">Welcome back! Here's your business overview.</p>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Today's Sales -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-1">Today's Sales</p>
                            <h3 class="fw-bold mb-0">KSh {{ number_format($stats['todaySales'], 0) }}</h3>
                        </div>
                        <div class="bg-primary rounded-3 p-3">
                            <i class="bi bi-currency-dollar text-white fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Orders -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-1">Today's Orders</p>
                            <h3 class="fw-bold mb-0">{{ $stats['totalOrders'] }}</h3>
                        </div>
                        <div class="bg-secondary rounded-3 p-3">
                            <i class="bi bi-cart text-white fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-1">Total Products</p>
                            <h3 class="fw-bold mb-0">{{ $stats['totalProducts'] }}</h3>
                        </div>
                        <div class="bg-info rounded-3 p-3">
                            <i class="bi bi-box text-white fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Items -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-1">Low Stock Items</p>
                            <h3 class="fw-bold mb-0">{{ $stats['lowStockItems'] }}</h3>
                        </div>
                        <div class="bg-danger rounded-3 p-3">
                            <i class="bi bi-exclamation-triangle text-white fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Sales and Quick Stats -->
    <div class="row g-4">
        <!-- Recent Sales -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Recent Sales</h5>
                        <i class="bi bi-arrow-up-right text-muted"></i>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($recentSales) === 0)
                        <p class="text-muted text-center py-5">No sales yet today</p>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($recentSales as $sale)
                                <div class="list-group-item border-0 border-bottom px-0 py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-1 fw-medium">{{ $sale->sale_number }}</p>
                                            <p class="mb-0 small text-muted">
                                                {{ \Carbon\Carbon::parse($sale->created_at)->format('h:i A') }}
                                            </p>
                                        </div>
                                        <p class="mb-0 fw-semibold text-primary">
                                            KSh {{ number_format($sale->total, 0) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Quick Stats</h5>
                        <i class="bi bi-graph-up text-muted"></i>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Average Order Value -->
                    <div class="p-4 bg-light rounded-3 mb-3">
                        <p class="text-muted small mb-2">Average Order Value</p>
                        <h4 class="fw-bold mb-0">
                            KSh {{ $stats['totalOrders'] > 0 ? number_format($stats['todaySales'] / $stats['totalOrders'], 0) : 0 }}
                        </h4>
                    </div>

                    <!-- Stock Health -->
                    <div class="p-4 rounded-3 mb-0" style="background-color: rgba(13, 110, 253, 0.1);">
                        <p class="text-muted small mb-2">Stock Health</p>
                        <h4 class="fw-bold mb-0 text-primary">
                            @php
                                $healthPercentage = $stats['totalProducts'] > 0 
                                    ? round((($stats['totalProducts'] - $stats['lowStockItems']) / $stats['totalProducts']) * 100) 
                                    : 100;
                            @endphp
                            {{ $healthPercentage }}% Healthy
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endpush