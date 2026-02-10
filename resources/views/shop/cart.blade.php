@extends('layouts.app')

@section('title', 'My Cart')

@section('content')

<script>
    const DJANGO_API = "{{ config('services.django_api.url') }}";
    const DJANGO_TOKEN = "{{ session('django_token') }}";
</script>

<div class="container my-5">

    <h2 class="mb-3">🛒 My Cart</h2>
    <div id="msg" class="fw-bold mb-3"></div>

    <div id="cart-area"></div>

    <!-- Receipt Modal -->
    <div id="receiptModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:9999;">
        <div class="card p-3" style="max-width:600px;margin:50px auto;">
            <h4>🧾 Receipt</h4>
            <div id="receiptBody"></div>
            <button onclick="closeReceipt()" class="btn btn-danger mt-2">Close</button>
            <button onclick="window.print()" class="btn btn-primary mt-2">Print</button>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
const DJANGO_API = "http://127.0.0.1:8000"; // change if needed
let cart = null;

async function loadCart(){
    try{
       const res = await fetch(DJANGO_API + "/cart/items/", {
    headers: {
        "Authorization": "Bearer " + DJANGO_TOKEN
    }
});

        cart = await res.json();
        renderCart();
    }catch(err){
        document.getElementById("msg").innerText = "❌ Failed to load cart";
    }
}

function renderCart(){
    let html = '';
    const items = cart?.items || [];

    if(items.length === 0){
        html = '<p class="text-muted">No items in cart.</p>';
    } else {
        html = `
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th width="120">Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
        `;

        items.forEach(i => {
            html += `
            <tr>
                <td>${i.product_name || i.product}</td>
                <td>
                    <input type="number" min="1" value="${i.quantity}"
                        onchange="updateItem(${i.product}, this.value)"
                        class="form-control">
                </td>
                <td>KES ${i.unit_price}</td>
                <td>KES ${(i.unit_price * i.quantity).toFixed(2)}</td>
                <td>
                    <button onclick="removeItem(${i.product})" class="btn btn-danger btn-sm">Remove</button>
                </td>
            </tr>
            `;
        });

        html += `
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <h5>Subtotal: KES ${cart.subtotal}</h5>
            <button onclick="checkout()" class="btn btn-success">Checkout</button>
        </div>
        `;
    }

    document.getElementById("cart-area").innerHTML = html;
}

async function updateItem(productId, qty){
    try{
        await fetch(DJANGO_API + "/cart/items/update/", {
    method: "PATCH",
    headers: {
        "Content-Type":"application/json",
        "Authorization": "Bearer " + DJANGO_TOKEN
    },
    body: JSON.stringify({
        product: productId,
        quantity: Math.max(1, qty)
    })
});

        loadCart();
    }catch(err){
        alert("Failed to update item");
    }
}

async function removeItem(productId){
    try{
        await fetch(DJANGO_API + "/cart/items/remove/", {
    method: "DELETE",
    headers: {
        "Content-Type":"application/json",
        "Authorization": "Bearer " + DJANGO_TOKEN
    },
    body: JSON.stringify({ product: productId })
});

        loadCart();
    }catch(err){
        alert("Failed to remove item");
    }
}

async function checkout(){
    try{
        const res = await fetch(DJANGO_API + "/checkout/mpesa/", {
    method: "POST",
    headers: {
        "Authorization": "Bearer " + DJANGO_TOKEN
    }
});


        const data = await res.json();

        if(data.receipt){
            showReceipt(data.receipt);
        } else if(data.message){
            alert(data.message);
        }

        loadCart();
    }catch(err){
        alert("Checkout failed");
    }
}

function showReceipt(r){
    let html = `
        <p><b>Date:</b> ${new Date(r.created_at).toLocaleString()}</p>

        <table class="table">
            <tr><th>Item</th><th>Qty</th><th>Total</th></tr>
    `;

    r.items.forEach(i=>{
        html += `<tr>
            <td>${i.product_name}</td>
            <td>${i.quantity}</td>
            <td>KES ${i.subtotal}</td>
        </tr>`;
    });

    html += `</table>
        <h5>Total: KES ${r.total}</h5>
    `;

    document.getElementById("receiptBody").innerHTML = html;
    document.getElementById("receiptModal").style.display = "block";
}

function closeReceipt(){
    document.getElementById("receiptModal").style.display = "none";
}

loadCart();
</script>
@endpush
