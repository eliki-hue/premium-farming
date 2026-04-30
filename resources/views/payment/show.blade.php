<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Complete Payment - {{ $order['order_number'] }}</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 500px;
            margin: 0 auto;
        }
        
        .card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            animation: slideUp 0.5s ease;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .card-header {
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            color: white;
            padding: 30px 24px;
            text-align: center;
        }
        
        .card-header h2 {
            font-size: 28px;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .card-header p {
            opacity: 0.9;
            font-size: 14px;
        }
        
        .card-body {
            padding: 32px 24px;
        }
        
        .order-info {
            background: #f8f9fa;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 24px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 500;
            color: #6c757d;
        }
        
        .info-value {
            font-weight: 600;
            color: #212529;
        }
        
        .total-row {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 2px solid #dee2e6;
        }
        
        .total-row .info-value {
            font-size: 24px;
            color: #25D366;
        }
        
        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .alert-success {
            background: #d4edda;
            border-left: 4px solid #28a745;
            color: #155724;
        }
        
        .alert-error {
            background: #f8d7da;
            border-left: 4px solid #dc3545;
            color: #721c24;
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
        }
        
        .btn-pay {
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            color: white;
            margin-bottom: 12px;
            box-shadow: 0 4px 15px rgba(37,211,102,0.3);
        }
        
        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37,211,102,0.4);
        }
        
        .btn-confirm {
            background: #6c757d;
            color: white;
        }
        
        .btn-confirm:hover {
            background: #5a6268;
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .whatsapp-support {
            margin-top: 20px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }
        
        .whatsapp-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #25D366;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .whatsapp-link:hover {
            gap: 12px;
        }
        
        .loader {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.6s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 12px;
            }
            
            .card-body {
                padding: 24px 16px;
            }
            
            .info-value {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>💳 Complete Payment</h2>
                <p>Secure payment via M-Pesa</p>
            </div>
            
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        <span style="font-size: 20px;">✅</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-error">
                        <span style="font-size: 20px;">❌</span>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                
                <div class="order-info">
                    <div class="info-row">
                        <span class="info-label">Order Number</span>
                        <span class="info-value">{{ $order['order_number'] }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Customer</span>
                        <span class="info-value">{{ $order['customer'] ?? 'Guest' }}</span>
                    </div>
                    <div class="info-row total-row">
                        <span class="info-label">Total Amount</span>
                        <span class="info-value">KES {{ number_format($order['total'], 2) }}</span>
                    </div>
                </div>
                
                {{-- Payment Button --}}
                <a href="{{ $paymentLink }}" target="_blank" id="paymentLink">
                    <button class="btn btn-pay" id="payButton">
                        💳 Pay Now with M-Pesa
                    </button>
                </a>
                
                {{-- Optional confirm button --}}
                <form method="POST" action="{{ route('payment.confirm', $order['id'] ?? $order['order_number']) }}" id="confirmForm">
                    @csrf
                    <button type="submit" class="btn btn-confirm" id="confirmButton">
                        ✅ I Have Completed Payment
                    </button>
                </form>
                
                <div class="whatsapp-support">
                    <a href="https://wa.me/254700680017?text=Hello%2C%20I%20need%20help%20with%20order%20{{ urlencode($order['order_number']) }}" 
                       class="whatsapp-link" target="_blank">
                        <span>💬</span>
                        <span>Need help? Chat with us on WhatsApp</span>
                        <span>→</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const payButton = document.getElementById('payButton');
            const confirmButton = document.getElementById('confirmButton');
            const paymentLink = document.getElementById('paymentLink');
            
            // Track payment button click
            if (payButton) {
                payButton.addEventListener('click', function(e) {
                    // Store in session that payment was initiated
                    sessionStorage.setItem('payment_initiated', 'true');
                    sessionStorage.setItem('order_number', '{{ $order['order_number'] }}');
                });
            }
            
            // Add confirmation tracking
            const confirmForm = document.getElementById('confirmForm');
            if (confirmForm) {
                confirmForm.addEventListener('submit', function(e) {
                    const confirmBtn = document.getElementById('confirmButton');
                    confirmBtn.disabled = true;
                    confirmBtn.innerHTML = '<span class="loader"></span> Processing...';
                });
            }
        });
    </script>
</body>
</html>