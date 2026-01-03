@extends('layouts.pos')

@section('page-title', 'Reports')
@section('content')
<div class="pos-card">
    <h4>📈 Reports</h4>
    <p class="text-muted">Sales and inventory reports</p>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="p-3 border rounded mb-3">
                <h6>📊 Sales Report</h6>
                <p class="text-muted small">View daily, weekly, monthly sales</p>
                <button class="btn btn-sm btn-outline-primary">Generate Report</button>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-3 border rounded mb-3">
                <h6>📦 Stock Report</h6>
                <p class="text-muted small">View inventory levels</p>
                <button class="btn btn-sm btn-outline-primary">View Stock</button>
            </div>
        </div>
    </div>
</div>
@endsection