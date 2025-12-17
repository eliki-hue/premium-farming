<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #000;
        }
        .center {
            text-align: center;
        }
        .line {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 4px 0;
            font-size: 13px;
        }
        .right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body onload="window.print()">

@php
    $receipt = session('receipt');
    $items = $receipt['items'] ?? [];
    $receiptNumber = 'PF-' . rand(10000,99999);
    $date = now()->format('d M Y, H:i');
    $servedBy = auth()->user()->name ?? 'Cashier';
@endphp

<div class="center">
    <h2>PREMIUM FARMING FEEDS</h2>
    <p>Branches: Turitu, Ikinu & Githiga - Kiambu</p>
    <p>Phone: 0790641428</p>
    <p>
        Paybill: <strong>247247</strong> |
        Account No: <strong>470470</strong>
    </p>
</div>

<div class="line"></div>

<p><strong>Receipt No:</strong> {{ $receiptNumber }}</p>
<p><strong>Date:</strong> {{ $date }}</p>
<p><strong>Served By:</strong> {{ $servedBy }}</p>
<p><strong>Payment Method:</strong> {{ $receipt['payment'] ?? 'Cash' }}</p>

<div class="line"></div>

<table>
    <thead>
        <tr class="bold">
            <th>Item</th>
            <th class="right">Qty</th>
            <th class="right">Price</th>
            <th class="right">Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
        <tr>
            <td>{{ $item['name'] }}</td>
            <td class="right">{{ $item['quantity'] }}</td>
            <td class="right">{{ number_format($item['price'], 2) }}</td>
            <td class="right">
                {{ number_format($item['price'] * $item['quantity'], 2) }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="line"></div>

<p class="right bold">Total: Ksh {{ number_format($receipt['total'], 2) }}</p>
<p class="right">Paid: Ksh {{ number_format($receipt['paid'], 2) }}</p>
<p class="right bold">
    Balance: Ksh {{ number_format($receipt['balance'], 2) }}
</p>

<div class="line"></div>

<p class="center">Goods once sold are not refundable</p>
<p class="center bold">Thank you & Welcome Again!</p>

</body>
</html>
