{{-- resources/views/checkout/cheque.blade.php --}}
@extends('layouts.app')

@section('title', 'Cheque Payment Instructions')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0"><i class="fas fa-money-check-alt me-2"></i>Cheque Payment Instructions</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <h5><i class="fas fa-check-circle me-2"></i>Order Placed Successfully!</h5>
                        <p class="mb-0">Your order has been received. Order Number: <strong>{{ $order->order_number }}</strong></p>
                    </div>

                    <div class="cheque-instructions mb-4">
                        <h5 class="mb-3"><i class="fas fa-file-invoice-dollar me-2"></i>Pay via Bank Cheque</h5>
                        
                        <div class="card mb-4">
                            <div class="card-body bg-light">
                                <h6 class="mb-3">Cheque Details:</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Payable to:</strong> [Your Business Name]</p>
                                        <p><strong>Cheque Number:</strong> {{ $order->cheque_number }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Amount:</strong> KES {{ number_format($order->grand_total, 2) }}</p>
                                        <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- WhatsApp Confirmation Section -->
                    <div class="whatsapp-section mb-4">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0"><i class="fab fa-whatsapp me-2"></i>Confirm via WhatsApp</h6>
                            </div>
                            <div class="card-body">
                                <p>After issuing the cheque, please send the cheque details via WhatsApp:</p>
                                
                                <div class="text-center mb-3">
                                    <a href="https://wa.me/2547XXXXXXXXX?text={{ urlencode($whatsappMessage) }}" 
                                       class="btn btn-success btn-lg" 
                                       target="_blank">
                                        <i class="fab fa-whatsapp me-2"></i>Confirm Cheque Details
                                    </a>
                                </div>
                                
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Note:</strong> Please include cheque photo in your WhatsApp message.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="action-buttons text-center">
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection