@extends('layouts.app')

@section('title', 'Checkout - Premium Farming Feeds')

@section('content')
<div class="min-h-screen pt-24 bg-gray-50">
    <div class="container py-8">
        <div class="row">
            <!-- Checkout Form -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <form id="checkoutForm" method="POST" action="{{ route('checkout.process') }}">
                            @csrf

                            <h4 class="mb-3"><i class="bi bi-truck me-2"></i> Delivery Information</h4>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Full Name *</label>
                                    <input type="text" class="form-control" name="name" value="{{ auth()->user()->name ?? '' }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Phone Number *</label>
                                    <input type="tel" class="form-control" name="phone" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Email Address *</label>
                                <input type="email" class="form-control" name="email" value="{{ auth()->user()->email ?? '' }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Delivery Address *</label>
                                <textarea class="form-control" name="address" rows="3" required placeholder="Farm name, location, nearest town, directions"></textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>County *</label>
                                    <select class="form-control" name="county" required>
                                        <option value="">Select County</option>
                                        <option value="Nairobi">Nairobi</option>
                                        <option value="Kiambu">Kiambu</option>
                                        <option value="Nakuru">Nakuru</option>
                                        <option value="Eldoret">Eldoret</option>
                                        <option value="Kisumu">Kisumu</option>
                                        <option value="Mombasa">Mombasa</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Town *</label>
                                    <input type="text" class="form-control" name="town" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label>Delivery Type *</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="delivery_type" value="farm_delivery" checked>
                                    <label class="form-check-label">Farm Delivery (Ksh 500)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="delivery_type" value="pickup_station">
                                    <label class="form-check-label">Pickup Station (Free)</label>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="mb-4">
                                <h5>Payment Method *</h5>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" value="mpesa" checked>
                                    <label class="form-check-label">M-Pesa</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" value="cash">
                                    <label class="form-check-label">Cash on Delivery</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" value="bank">
                                    <label class="form-check-label">Bank Transfer</label>
                                </div>
                            </div>

                            <!-- M-Pesa Details -->
                            <div id="mpesaDetails" class="mb-4 border p-3 rounded bg-light">
                                <label>M-Pesa Phone Number *</label>
                                <input type="tel" class="form-control" name="mpesa_number" placeholder="2547XXXXXXXX">
                            </div>

                            <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                            <input type="hidden" name="shipping" value="{{ $shipping }}">
                            <input type="hidden" name="tax" value="{{ $tax }}">
                            <input type="hidden" name="total" value="{{ $total }}">

                            <button type="submit" class="btn btn-success btn-lg w-100">
                                Complete Order - Ksh {{ number_format($total) }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 100px;">
                    <div class="card-body">
                        <h5>Order Summary</h5>
                        @foreach($cart as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <div>{{ $item['name'] }} x {{ $item['quantity'] }}</div>
                            <div>Ksh {{ number_format($item['price'] * $item['quantity']) }}</div>
                        </div>
                        @endforeach
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Subtotal</strong>
                            <strong>Ksh {{ number_format($subtotal) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <strong>Shipping</strong>
                            <strong id="shippingAmount">Ksh {{ number_format($shipping) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <strong>Tax</strong>
                            <strong>Ksh {{ number_format($tax) }}</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total</strong>
                            <strong id="totalAmount">Ksh {{ number_format($total) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mpesaDetails = document.getElementById('mpesaDetails');
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const mpesaInput = document.querySelector('input[name="mpesa_number"]');

    function toggleMpesa() {
        const selected = document.querySelector('input[name="payment_method"]:checked').value;
        if (selected === 'mpesa') {
            mpesaDetails.style.display = 'block';
            mpesaInput.required = true;
        } else {
            mpesaDetails.style.display = 'none';
            mpesaInput.required = false;
        }
    }

    paymentMethods.forEach(pm => pm.addEventListener('change', toggleMpesa));
    toggleMpesa();
});
</script>
@endsection
