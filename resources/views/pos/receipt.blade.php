<!DOCTYPE html>
<html>
<head>
    <title>Receipt #{{ $receipt['order_id'] ?? 'N/A' }}</title>
    <style>
        @media print { 
            body { margin: 0; font-size: 12px; padding: 10px; } 
            .no-print { display: none !important; }
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Courier New', monospace; font-size: 14px; line-height: 1.4; }
        .receipt { max-width: 320px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { font-size: 20px; margin-bottom: 5px; color: #2e7d32; }
        .branch { background: #e8f5e8; padding: 8px; border-radius: 5px; margin: 10px 0; font-weight: bold; }
        .phones { background: #e3f2fd; padding: 8px; border-radius: 5px; margin: 5px 0; font-size: 13px; }
        .item { display: flex; justify-content: space-between; margin: 6px 0; padding: 0 5px; border-bottom: 1px dotted #ccc; }
        .item-name { flex: 1; font-weight: bold; }
        .item-price { text-align: right; width: 80px; }
        .totals { border-top: 3px double #000; padding-top: 15px; margin-top: 15px; }
        .total-row { display: flex; justify-content: space-between; margin: 8px 0; font-weight: bold; font-size: 15px; }
        .grand-total { font-size: 18px !important; color: #d32f2f; border-top: 2px solid #000; padding-top: 10px; margin-top: 10px; }
        .mpesa-box { background: #fff3cd; border: 2px solid #f57c00; border-radius: 8px; padding: 12px; margin: 15px 0; }
        .mpesa-box strong { color: #e65100; }
        .cash-change { background: #e3f2fd; border: 2px solid #1976d2; border-radius: 8px; padding: 12px; margin: 15px 0; }
        .served-by { background: #f3e5f5; border: 1px solid #9c27b0; border-radius: 5px; padding: 10px; margin-top: 15px; text-align: center; font-weight: bold; color: #6a1b9a; }
        .footer { text-align: center; margin-top: 20px; font-size: 11px; color: #666; border-top: 1px dashed #ccc; padding-top: 10px; }
        .print-btn { background: #1976d2; color: white; border: none; padding: 12px 24px; border-radius: 5px; font-size: 16px; cursor: pointer; margin-top: 20px; }
        .no-print { text-align: center; margin: 20px; }
    </style>
</head>
<body onload="window.print()">
    <div class="receipt">
        <!-- ✅ COMPANY HEADER -->
        <div class="header">
            <h1>🐄 PREMIUM FARMING FEED</h1>
            <div class="branch">
                🏪 BRANCHES: Turitu | Githiga | Ikinu - Kiambu
            </div>
            <div class="phones">
                📞 0786571173 | 0708488688 | 0711633900
            </div>
            <p><strong>RECEIPT #{{ $receipt['order_id'] ?? 'N/A' }}</strong><br>
            {{ $receipt['date'] ?? now()->format('d/m/Y') }} {{ $receipt['time'] ?? now()->format('H:i') }}</p>
        </div>

        <!-- CASHIER & PAYMENT -->
        <div style="margin-bottom: 15px; font-size: 13px;">
            <strong>Cashier: {{ $receipt['cashier'] ?? 'Staff' }}</strong><br>
            <strong>Payment: {{ strtoupper($receipt['payment_method'] ?? 'N/A') }}</strong>
        </div>

        <!-- ✅ M-PESA DETAILS -->
        @if(($receipt['payment_method'] ?? '') == 'mpesa')
        <div class="mpesa-box">
            <div class="fw-bold mb-2" style="font-size: 15px;">📱 M-PESA PAYMENT</div>
            <div><i class="fas fa-building"></i> <strong>Paybill: 247247</strong></div>
            <div><i class="fas fa-hashtag"></i> <strong>Account: 470470</strong></div>
            <div>Phone: <strong>{{ $receipt['phone'] ?? 'N/A' }}</strong></div>
        </div>
        @endif

        <!-- ITEMS -->
        <div style="margin-bottom: 20px;">
            @if(isset($receipt['items']) && is_array($receipt['items']))
                @foreach($receipt['items'] as $item)
                <div class="item">
                    <span class="item-name">{{ $item['name'] ?? 'Item' }}<br>
                    <small style="font-weight: normal;">({{ $item['quantity'] ?? 1 }}{{ $item['unit'] ?? '' }})</small></span>
                    <span class="item-price">KSh {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1)) }}</span>
                </div>
                @endforeach
            @endif
        </div>

        <!-- TOTALS -->
        <div class="totals">
            <div class="total-row">
                <span>SUBTOTAL</span>
                <span>KSh {{ number_format($receipt['subtotal'] ?? 0) }}</span>
            </div>
            
            @if(($receipt['discount'] ?? 0) > 0)
            <div class="total-row">
                <span>DISCOUNT</span>
                <span>-KSh {{ number_format($receipt['discount'] ?? 0) }}</span>
            </div>
            @endif
            
            <div class="total-row">
                <span>VAT (16%)</span>
                <span>KSh {{ number_format($receipt['vat'] ?? 0) }}</span>
            </div>
            
            <div class="grand-total">
                <span>TOTAL</span>
                <span>KSh {{ number_format($receipt['grand_total'] ?? 0) }}</span>
            </div>
        </div>

        <!-- CASH CHANGE -->
        @if(($receipt['payment_method'] ?? '') == 'cash' && isset($receipt['change']))
        @if(($receipt['change'] ?? 0) > 0)
        <div class="cash-change">
            <strong>💵 CASH PAYMENT:</strong><br>
            Cash Tendered: <strong>KSh {{ number_format($receipt['amount_paid'] ?? 0) }}</strong><br>
            <strong>Change Given: KSh {{ number_format($receipt['change'] ?? 0) }}</strong>
        </div>
        @endif
        @endif

        <!-- ✅ SERVED BY CASHIER -->
        <div class="served-by">
            ✅ YOU WERE SERVED BY<br>
            <span style="font-size: 16px; color: #9c27b0;">{{ $receipt['cashier'] ?? 'Staff' }}</span>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            ════════════════════════════<br>
            <strong>PREMIUM FARMING FEED</strong><br>
            Turitu | Githiga | Ikinu - Kiambu<br>
            📞 0786571173 | 0708488688 | 0711633900<br>
            Paybill: 247247 | Account: 470470<br>
            THANK YOU FOR SHOPPING WITH US! 🐄✨
        </div>
    </div>

    <div class="no-print">
        <button onclick="window.print()" class="print-btn">
            🖨️ Print Receipt
        </button>
        <br><br>
        <a href="/sell" style="color: #1976d2; text-decoration: none; font-weight: bold;">← Back to POS</a>
    </div>
</body>
</html>
