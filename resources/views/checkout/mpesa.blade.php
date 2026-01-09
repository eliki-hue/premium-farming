@extends('layouts.app')

@section('title', 'M-Pesa Payment Instructions')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fab fa-whatsapp me-2"></i>M-Pesa Payment Instructions</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <h5><i class="fas fa-check-circle me-2"></i>Order Placed Successfully!</h5>
                        <p class="mb-0">Your order has been received. Order Number: <strong>{{ $order->order_number }}</strong></p>
                    </div>

                    <div class="payment-instructions">
                        <h5 class="mb-3"><i class="fas fa-mobile-alt me-2"></i>Pay via M-Pesa PayBill</h5>
                        
                        <div class="card mb-4">
                            <div class="card-body bg-light">
                                <div class="paybill-details text-center">
                                    <h4 class="text-primary mb-3">PayBill: <span class="badge bg-primary fs-5">247247</span></h4>
                                    <h4 class="text-success mb-3">Account: <span class="badge bg-success fs-5">470470</span></h4>
                                    <h4 class="mb-3">Amount: <span class="badge bg-warning text-dark fs-5">KES {{ number_format($order->grand_total, 2) }}</span></h4>
                                </div>
                            </div>
                        </div>

                        <div class="step-by-step mb-4">
                            <h6 class="mb-3">Payment Steps:</h6>
                            <ol class="list-group list-group-numbered">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Go to M-Pesa Menu</div>
                                        Select <strong>Lipa na M-Pesa</strong>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Select PayBill</div>
                                        Choose <strong>PayBill</strong> option
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Enter Business Number</div>
                                        Enter <strong class="text-primary">247247</strong>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Enter Account Number</div>
                                        Enter <strong class="text-success">470470</strong>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Enter Amount</div>
                                        Enter <strong class="text-warning">KES {{ number_format($order->grand_total, 2) }}</strong>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Enter Your PIN</div>
                                        Complete the transaction
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Confirm Payment via WhatsApp</div>
                                        Send payment confirmation to our WhatsApp
                                    </div>
                                </li>
                            </ol>
                        </div>

                        <!-- WhatsApp Section -->
                        <div class="whatsapp-section mb-4">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0"><i class="fab fa-whatsapp me-2"></i>Confirm Payment via WhatsApp</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-3">After making payment, please confirm by sending the following information via WhatsApp:</p>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6><i class="fas fa-info-circle me-2"></i>Required Information:</h6>
                                                    <ul class="mb-0">
                                                        <li>Your Name</li>
                                                        <li>Order Number: <strong>{{ $order->order_number }}</strong></li>
                                                        <li>Amount Paid: <strong>KES {{ number_format($order->grand_total, 2) }}</strong></li>
                                                        <li>M-Pesa Transaction Code</li>
                                                        <li>Payment Date & Time</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="card bg-success text-white">
                                                <div class="card-body text-center">
                                                    <h6><i class="fas fa-phone-alt me-2"></i>WhatsApp Contact</h6>
                                                    <div class="whatsapp-contact mt-3">
                                                        <h4>+254 7XX XXX XXX</h4>
                                                        <p class="mb-3">(Customer Support)</p>
                                                        <a href="https://wa.me/2547XXXXXXXXX?text={{ urlencode($whatsappMessage) }}" 
                                                           class="btn btn-success btn-lg" 
                                                           target="_blank">
                                                            <i class="fab fa-whatsapp me-2"></i>Chat on WhatsApp
                                                        </a>
                                                        <small class="d-block mt-2">Click to open WhatsApp with pre-filled message</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Important:</strong> Your order will be processed only after payment confirmation via WhatsApp.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="order-summary mb-4">
                            <h6 class="mb-3"><i class="fas fa-receipt me-2"></i>Order Summary</h6>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                                            <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
                                            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                                            <p><strong>Subtotal:</strong> KES {{ number_format($order->subtotal, 2) }}</p>
                                            <p><strong>Total Amount:</strong> <span class="text-success fw-bold">KES {{ number_format($order->grand_total, 2) }}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="important-notes">
                            <div class="alert alert-warning">
                                <h6><i class="fas fa-exclamation-triangle me-2"></i>Important Notes:</h6>
                                <ul class="mb-0">
                                    <li>Please complete payment within 24 hours</li>
                                    <li>Keep your M-Pesa transaction code safe</li>
                                    <li>Order will be processed after WhatsApp confirmation</li>
                                    <li>You will receive order updates via email</li>
                                </ul>
                            </div>
                        </div>

                        <div class="action-buttons text-center">
                            <a href="{{ route('checkout.receipt', ['orderId' => $order->order_number]) }}" 
                               class="btn btn-outline-primary me-2">
                                <i class="fas fa-receipt me-2"></i>View Receipt
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-outline-success">
                                <i class="fas fa-home me-2"></i>Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 10px;
}
.card-header {
    border-radius: 10px 10px 0 0 !important;
}
.paybill-details .badge {
    padding: 10px 20px;
    font-size: 1.5rem;
}
.btn-success {
    background-color: #25D366;
    border-color: #25D366;
}
.btn-success:hover {
    background-color: #1da851;
    border-color: #1da851;
}
.list-group-item {
    border-left: 3px solid #28a745;
}
</style>
@endsection