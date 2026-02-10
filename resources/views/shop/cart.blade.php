@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<script>
const TOKEN = "{{ session('django_token') }}";
</script>

<div class="container my-4">
    <h3>🛒 Cart</h3>
    <div id="msg" class="fw-bold"></div>
    <div id="cart"></div>
</div>

<!-- Receipt Modal -->
<div id="receiptModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.55); z-index:9999;">
  <div class="card p-3" style="max-width:600px;margin:50px auto;">
    <h4>🧾 Receipt</h4>
    <div id="receiptBody"></div>
    <button onclick="closeReceipt()" class="btn btn-danger">Close</button>
    <button onclick="window.print()" class="btn btn-primary">Print</button>
  </div>
</div>

<script>
let cart = null;

async function loadCart(){
    const res = await fetch('/cart/load');
    cart = await res.json();
    render();
}

function render(){
    const items = cart?.items || [];
    let html = '';

    if(!items.length){
        html = '<p class="text-muted">No items in cart</p>';
    } else {
        html = `
        <table class="table">
          <thead>
            <tr>
              <th>Product</th><th>Qty</th><th>Price</th><th>Total</th><th></th>
            </tr>
          </thead><tbody>`;

        items.forEach(i=>{
            html += `
            <tr>
              <td>${i.product_name}</td>
              <td>
                <input type="number" min="1" value="${i.quantity}"
                  onchange="updateItem(${i.product},this.value)"
                  class="form-control">
              </td>
              <td>KES ${i.unit_price}</td>
              <td>KES ${(i.unit_price*i.quantity).toFixed(2)}</td>
              <td>
                <button onclick="removeItem(${i.product})" class="btn btn-danger btn-sm">Remove</button>
              </td>
            </tr>`;
        });

        html += `
        </tbody></table>
        <div class="d-flex justify-content-between">
          <b>Subtotal: KES ${cart.subtotal}</b>
          <button onclick="checkout()" class="btn btn-success">Checkout</button>
        </div>`;
    }

    document.getElementById('cart').innerHTML = html;
}

async function updateItem(product, quantity){
    await fetch('/cart/update', {
        method:'PATCH',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify({product, quantity})
    });
    loadCart();
}

async function removeItem(product){
    await fetch('/cart/remove', {
        method:'DELETE',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify({product})
    });
    loadCart();
}

async function checkout(){
    const res = await fetch('/cart/checkout', {method:'POST'});
    const data = await res.json();

    if(data.receipt){
        showReceipt(data.receipt);
    }
    loadCart();
}

function showReceipt(r){
    let html = `<p><b>Date:</b> ${new Date(r.created_at).toLocaleString()}</p>
    <table class="table"><tr><th>Item</th><th>Qty</th><th>Total</th></tr>`;

    r.items.forEach(i=>{
        html+=`<tr><td>${i.product_name}</td><td>${i.quantity}</td><td>KES ${i.subtotal}</td></tr>`;
    });

    html+=`</table><h5>Total: KES ${r.total}</h5>`;
    document.getElementById('receiptBody').innerHTML = html;
    document.getElementById('receiptModal').style.display='block';
}

function closeReceipt(){
    document.getElementById('receiptModal').style.display='none';
}

loadCart();
</script>
@endsection
