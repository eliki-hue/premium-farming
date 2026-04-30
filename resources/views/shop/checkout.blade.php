@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container my-4">
    <h3>Checkout</h3>

    <form id="checkoutForm">
        <div class="mb-3">
            <label>Full Name *</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        <div class="mb-3">
            <label>Phone *</label>
            <input type="tel" class="form-control" name="phone" required>
        </div>

        <div class="mb-3">
            <label>Email *</label>
            <input type="email" class="form-control" name="email" required>
        </div>

        <div class="mb-3">
            <label>Address *</label>
            <textarea class="form-control" name="address" required></textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>County *</label>
                <input type="text" class="form-control" name="county" required>
            </div>
            <div class="col-md-6">
                <label>Town *</label>
                <input type="text" class="form-control" name="town" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Delivery Type *</label><br>
            <input type="radio" name="delivery_type" value="farm_delivery" checked> Farm Delivery
            <input type="radio" name="delivery_type" value="pickup_station"> Pickup Station
        </div>

        <input type="hidden" name="payment_method" value="mpesa">

        <div class="mb-3">
            <label>M-Pesa Number *</label>
            <input type="tel" class="form-control" name="mpesa_number" required>
        </div>

        <div class="mb-3">
            <label>Total (KES)</label>
            <input type="text" class="form-control" id="total" name="total" readonly>
        </div>

        <button class="btn btn-success w-100">Complete Order</button>
    </form>
</div>

<script>
async function loadTotal(){
    const res = await fetch('/proxy/cart');
    const cart = await res.json();
    document.getElementById('total').value = cart.subtotal;
}

document.getElementById('checkoutForm').addEventListener('submit', async function(e){
    e.preventDefault();

    const formData = new FormData(this);

    const res = await fetch('/proxy/checkout/mpesa', {
        method: 'POST',
        body: formData
    });

    if(!res.ok){
        alert("Checkout failed");
        return;
    }

    alert("Order placed successfully");
    window.location.href = "/orders";
});

document.addEventListener('DOMContentLoaded', loadTotal);
</script>
@endsection