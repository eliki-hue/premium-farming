<!DOCTYPE html>
<html>
<head>
    <title>Receipt #{{ $receipt['order_id'] }}</title>
    <style>
        @media print { body { margin: 0; font-size: 12px; } }
        .receipt { max-width: 300px; margin: 0 auto; font-family: monospace; padding: 20px; }
        .header { text-align: center; border-bottom: 2px dashed #000; padding-bottom: 10px; margin-bottom: 20px; }
        .item { display: flex; justify-content: space-between; margin: 5px 0; }
        .total { border-top: 2px dashed #000; padding-top: 10px; font-size: 14px; font-weight: bold; }
        .mpesa { background: #e8f5e8; padding: 10px; border-radius: 5px; margin: 10px 0; }
    </style>
</head>
<body onload="window.print()">
<div class="receipt">
    <div class="header">
        <h2>🐄 FARM FEED SHOP</h2>
        <p>Nairobi, Kenya<br>Tel: 07XX XXX XXX</p>
        <p><strong>RECEIPT #{{ $receipt['order_id'] }}</strong><br>{{ $receipt['date'] }} {{ $receipt['time'] }}</p>
    </div>

    <div class="customer">
        <strong>CASHIER: {{ $receipt['cashier'] }}</strong><br>
        <strong>PAYMENT: {{ strtoupper($receipt['payment_method']) }}</strong>
    </div>

    @if($receipt['payment_method'] == 'mpesa')
    <div class="mpesa">
        <strong>M-PESA DETAILS:</strong><br>
        Paybill: <strong>247247</strong><br>
        Account: <strong>470470</strong><br>
        Phone: {{ $receipt['phone'] ?? 'N/A' }}
    </div>
    @endif

    <div class="items">
        @foreach($receipt['items'] as $item)
        <div class="item">
            <span>{{ $item['name'] }} ({{ $item['quantity'] }})</span>
            <span>KSh {{ number_format($item['price'] * $item['quantity']) }}</span>
        </div>
        @endforeach
    </div>

    <div class="total">
        <div class="item"><span>SUBTOTAL</span><span>KSh {{ number_format($receipt['subtotal']) }}</span></div>
        @if($receipt['discount'] > 0)
        <div class="item"><span>DISCOUNT</span><span>-KSh {{ number_format($receipt['discount']) }}</span></div>
        @endif
        <div class="item"><span>VAT (16%)</span><span>KSh {{ number_format($receipt['vat']) }}</span></div>
        <div style="font-size: 16px; margin-top: 10px;">
            <strong>TOTAL: KSh {{ number_format($receipt['grand_total']) }}</strong>
        </div>
    </div>

    @if($receipt['payment_method'] == 'cash' && isset($receipt['change']))
    <div style="margin-top: 15px; font-size: 14px;">
        <strong>CASH TENDERED: KSh {{ number_format($receipt['amount_paid']) }}</strong><br>
        <strong>CHANGE: KSh {{ number_format($receipt['change']) }}</strong>
    </div>
    @endif

    <div style="text-align: center; margin-top: 20px; font-size: 10px;">
        THANK YOU FOR YOUR BUSINESS!<br>
        Visit us again 🐄
    </div>
</div>
</body>
</html>