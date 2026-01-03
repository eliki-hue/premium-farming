<!DOCTYPE html>
<html>
<head>
    <title>Receipt #{{ $order['order_id'] ?? 'N/A' }}</title>
    <style>
        @media print { 
            body { margin: 0; font-size: 12px; padding: 10px; } 
            .no-print { display: none !important; }
            .receipt { border: none !important; box-shadow: none !important; }
            @page { margin: 0; }
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Courier New', monospace, sans-serif; font-size: 14px; line-height: 1.4; background: #f5f5f5; }
        .receipt { max-width: 320px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; background: white; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { font-size: 20px; margin-bottom: 5px; color: #2a6e3f; }
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
        .customer-info { background: #f8f9fa; padding: 10px; border-radius: 5px; margin: 10px 0; border: 1px solid #dee2e6; }
        .delivery-info { background: #e8f5e8; padding: 10px; border-radius: 5px; margin: 10px 0; border: 1px solid #c3e6cb; }
        .status-badge { display: inline-block; padding: 3px 8px; border-radius: 3px; font-size: 12px; font-weight: bold; margin-left: 5px; }
        .status-processing { background: #ffc107; color: #000; }
        .status-completed { background: #28a745; color: white; }
        .status-pending { background: #6c757d; color: white; }
        .separator { border-top: 2px dashed #ccc; margin: 15px 0; }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
            <p><strong>ONLINE ORDER RECEIPT #{{ $order['order_id'] ?? 'ORD-' . date('YmdHis') }}</strong><br>
            {{ date('d/m/Y', strtotime($order['order_date'])) }} {{ date('H:i', strtotime($order['order_date'])) }}</p>
        </div>

        <!-- ORDER STATUS -->
        <div style="margin-bottom: 15px; text-align: center;">
            <span class="status-badge status-{{ $order['status'] ?? 'processing' }}">
                {{ strtoupper($order['status'] ?? 'PROCESSING') }}
            </span>
            <span class="status-badge status-{{ $order['payment']['status'] ?? 'pending' }}">
                {{ strtoupper($order['payment']['status'] ?? 'PENDING') }} PAYMENT
            </span>
        </div>

        <!-- CUSTOMER INFORMATION -->
        <div class="customer-info">
            <div style="font-weight: bold; margin-bottom: 5px;">👤 CUSTOMER DETAILS</div>
            <div><strong>Name:</strong> {{ $order['customer']['name'] ?? 'N/A' }}</div>
            <div><strong>Phone:</strong> {{ $order['customer']['phone'] ?? 'N/A' }}</div>
            <div><strong>Email:</strong> {{ $order['customer']['email'] ?? 'N/A' }}</div>
        </div>

        <!-- DELIVERY INFORMATION -->
        <div class="delivery-info">
            <div style="font-weight: bold; margin-bottom: 5px;">🚚 DELIVERY INFORMATION</div>
            <div><strong>Address:</strong> {{ $order['customer']['address'] ?? 'N/A' }}</div>
            <div><strong>Town:</strong> {{ $order['customer']['town'] ?? 'N/A' }}, {{ $order['customer']['county'] ?? 'N/A' }} County</div>
            <div><strong>Type:</strong> {{ strtoupper(str_replace('_', ' ', $order['delivery']['type'] ?? 'farm_delivery')) }}</div>
            @if(isset($order['delivery']['instructions']) && !empty($order['delivery']['instructions']))
            <div><strong>Instructions:</strong> {{ $order['delivery']['instructions'] }}</div>
            @endif
        </div>

        <!-- CASHIER & PAYMENT -->
        <div style="margin-bottom: 15px; font-size: 13px;">
            <div><strong>Order Date:</strong> {{ date('F d, Y H:i', strtotime($order['order_date'])) }}</div>
            <div><strong>Payment Method:</strong> {{ strtoupper($order['payment']['method'] ?? 'N/A') }}</div>
            @if(isset($order['payment']['mpesa_number']))
            <div><strong>M-Pesa Phone:</strong> {{ $order['payment']['mpesa_number'] }}</div>
            @endif
        </div>

        <!-- ✅ M-PESA DETAILS -->
        @if(($order['payment']['method'] ?? '') == 'mpesa')
        <div class="mpesa-box">
            <div style="font-weight: bold; margin-bottom: 5px; font-size: 15px;">📱 M-PESA PAYMENT DETAILS</div>
            <div>🏦 <strong>Paybill: 247247</strong></div>
            <div>🔢 <strong>Account: 470470</strong></div>
            <div>📞 <strong>Phone: {{ $order['payment']['mpesa_number'] ?? 'N/A' }}</strong></div>
            <div style="margin-top: 5px; font-size: 12px; color: #666;">
                <em>Please check your phone for M-Pesa prompt</em>
            </div>
        </div>
        @endif

        <!-- ITEMS -->
        <div style="margin-bottom: 20px;">
            <div style="font-weight: bold; margin-bottom: 10px; border-bottom: 2px solid #000; padding-bottom: 5px;">
                ORDER ITEMS ({{ count($order['items'] ?? []) }})
            </div>
            
            @if(isset($order['items']) && is_array($order['items']) && count($order['items']) > 0)
                @foreach($order['items'] as $item)
                <div class="item">
                    <span class="item-name">
                        {{ $item['name'] ?? 'Item' }}
                        <br>
                        <small style="font-weight: normal;">
                            Qty: {{ $item['quantity'] ?? 1 }} × KSh {{ number_format($item['price'] ?? 0) }}
                            @if(isset($item['unit']) && $item['unit'])
                            ({{ $item['unit'] }})
                            @endif
                        </small>
                    </span>
                    <span class="item-price">KSh {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1)) }}</span>
                </div>
                @endforeach
            @else
                <div class="item">
                    <span class="item-name">No items in order</span>
                    <span class="item-price">KSh 0</span>
                </div>
            @endif
        </div>

        <!-- TOTALS -->
        <div class="totals">
            <div class="total-row">
                <span>SUBTOTAL</span>
                <span>KSh {{ number_format($order['totals']['subtotal'] ?? 0) }}</span>
            </div>
            
            <div class="total-row">
                <span>SHIPPING</span>
                <span>KSh {{ number_format($order['totals']['shipping'] ?? 0) }}</span>
            </div>
            
            <div class="total-row">
                <span>VAT (16%)</span>
                <span>KSh {{ number_format($order['totals']['tax'] ?? 0) }}</span>
            </div>
            
            <div class="separator"></div>
            
            <div class="grand-total total-row">
                <span>TOTAL AMOUNT</span>
                <span>KSh {{ number_format($order['totals']['total'] ?? 0) }}</span>
            </div>
            
            @if(($order['payment']['method'] ?? '') == 'cash')
            <div class="separator"></div>
            <div class="total-row">
                <span>AMOUNT PAID</span>
                <span>KSh {{ number_format($order['payment']['amount_paid'] ?? $order['totals']['total'] ?? 0) }}</span>
            </div>
            @if(($order['payment']['change'] ?? 0) > 0)
            <div class="total-row">
                <span>CHANGE</span>
                <span>KSh {{ number_format($order['payment']['change'] ?? 0) }}</span>
            </div>
            @endif
            @endif
        </div>

        <!-- CASH CHANGE SECTION -->
        @if(($order['payment']['method'] ?? '') == 'cash' && isset($order['payment']['change']))
        @if(($order['payment']['change'] ?? 0) > 0)
        <div class="cash-change">
            <div style="font-weight: bold; margin-bottom: 5px;">💵 CASH PAYMENT DETAILS</div>
            <div>Cash Tendered: <strong>KSh {{ number_format($order['payment']['amount_paid'] ?? 0) }}</strong></div>
            <div>Amount Due: <strong>KSh {{ number_format($order['totals']['total'] ?? 0) }}</strong></div>
            <div style="margin-top: 5px; font-size: 15px;">
                <strong>Change Given: KSh {{ number_format($order['payment']['change'] ?? 0) }}</strong>
            </div>
        </div>
        @endif
        @endif

        <!-- ORDER NOTES -->
        <div style="margin: 15px 0; padding: 10px; background: #fff8e1; border: 1px solid #ffd54f; border-radius: 5px; font-size: 12px;">
            <div style="font-weight: bold; margin-bottom: 5px;">📝 ORDER NOTES</div>
            <div>• Delivery within 2-3 business days</div>
            <div>• Contact us for any inquiries: 0700 000 000</div>
            <div>• Keep this receipt for reference</div>
            <div>• Thank you for choosing Premium Farming Feed!</div>
        </div>

        <!-- ✅ SERVED BY -->
        <div class="served-by">
            ✅ ONLINE ORDER CONFIRMED<br>
            <span style="font-size: 16px; color: #9c27b0;">Premium Farming Feed Team</span><br>
            <small style="font-weight: normal;">Your order will be processed shortly</small>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            ════════════════════════════<br>
            <strong>PREMIUM FARMING FEED</strong><br>
            Turitu | Githiga | Ikinu - Kiambu<br>
            📞 0786571173 | 0708488688 | 0711633900<br>
            Paybill: 247247 | Account: 470470<br>
            Email: info@premiumfarmingfeed.com<br>
            Website: www.premiumfarmingfeed.com<br>
            ════════════════════════════<br>
            <strong>THANK YOU FOR SHOPPING WITH US! 🐄✨</strong><br>
            <small>This is a computer-generated receipt</small>
        </div>
    </div>

    <div class="no-print">
        <div style="text-align: center; margin: 30px;">
            <button onclick="window.print()" class="print-btn">
                🖨️ Print Receipt
            </button>
            <br><br>
            <div style="display: flex; justify-content: center; gap: 10px;">
                <a href="/shop/products" style="color: #1976d2; text-decoration: none; font-weight: bold; padding: 10px 20px; border: 1px solid #1976d2; border-radius: 5px;">
                    ← Continue Shopping
                </a>
                <a href="{{ route('checkout.orders') }}" style="color: #28a745; text-decoration: none; font-weight: bold; padding: 10px 20px; border: 1px solid #28a745; border-radius: 5px;">
                    📋 View All Orders
                </a>
                <a href="/" style="color: #6c757d; text-decoration: none; font-weight: bold; padding: 10px 20px; border: 1px solid #6c757d; border-radius: 5px;">
                    🏠 Return Home
                </a>
            </div>
        </div>
    </div>

    <script>
        // Auto-print when page loads
        window.onload = function() {
            window.print();
        };
        
        // After printing, show a message
        window.onafterprint = function() {
            alert("Receipt printed successfully! Keep this copy for your records.");
        };
    </script>
</body>
</html>