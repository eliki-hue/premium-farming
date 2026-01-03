@extends('layouts.pos')

@section('page-title', 'Orders')
@section('content')
<div class="pos-card">
    <h4>📋 Orders</h4>
    <p class="text-muted">View all sales orders</p>
    
    <div class="text-center py-5">
        <i class="fas fa-receipt fa-4x text-muted mb-3"></i>
        <h5 class="text-muted">No orders yet</h5>
        <p>Start selling to see orders here</p>
        <a href="{{ route('pos.sell') }}" class="btn btn-primary">
            <i class="fas fa-cash-register me-2"></i> Start Selling
        </a>
    </div>
</div>
@endsection