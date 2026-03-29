<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Complete Payment - Your Order #{{order_id}}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding: 20px 0;
        }

        .header h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 8px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        /* Payment Card */
        .payment-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        /* Order Summary Section */
        .order-summary {
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
        }

        .order-summary h3 {
            font-size: 16px;
            color: #333;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .order-id-badge {
            background: #f0f0f0;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-family: monospace;
            color: #666;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f5f5f5;
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-label {
            color: #666;
            font-size: 14px;
        }

        .summary-value {
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .total-row {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 2px solid #e0e0e0;
            font-weight: 600;
        }

        .total-row .summary-label,
        .total-row .summary-value {
            font-size: 18px;
            font-weight: 700;
            color: #2c3e50;
        }

        /* Payment Methods */
        .payment-methods {
            padding: 20px;
        }

        .payment-methods h3 {
            font-size: 16px;
            color: #333;
            margin-bottom: 15px;
        }

        .method-option {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .method-option:hover {
            border-color: #25D366;
            background: #f0fdf4;
        }

        .method-option.selected {
            border-color: #25D366;
            background: #f0fdf4;
        }

        .method-radio {
            width: 20px;
            height: 20px;
            accent-color: #25D366;
        }

        .method-icon {
            font-size: 28px;
        }

        .method-info {
            flex: 1;
        }

        .method-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 2px;
        }

        .method-description {
            font-size: 12px;
            color: #666;
        }

        /* M-Pesa Phone Input */
        .phone-section {
            padding: 0 20px 20px 20px;
            display: none;
        }

        .phone-section.show {
            display: block;
        }

        .phone-input-group {
            background: #f9fafb;
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #e5e7eb;
        }

        .phone-input-group label {
            display: block;
            font-size: 13px;
            color: #666;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .phone-input-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .country-code {
            background: white;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            font-weight: 500;
            color: #333;
        }

        .phone-input-wrapper input {
            flex: 1;
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            font-size: 16px;
            font-family: monospace;
        }

        .phone-input-wrapper input:focus {
            outline: none;
            border-color: #25D366;
        }

        .phone-hint {
            font-size: 11px;
            color: #999;
            margin-top: 6px;
        }

        /* Pay Button */
        .pay-button-container {
            padding: 20px;
            border-top: 1px solid #f0f0f0;
        }

        .pay-btn {
            width: 100%;
            padding: 16px;
            background: #25D366;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .pay-btn:hover:not(:disabled) {
            background: #128C7E;
            transform: translateY(-1px);
        }

        .pay-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Alert Messages */
        .alert {
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 16px;
            display: none;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.3s ease;
        }

        .alert.show {
            display: flex;
        }

        .alert-error {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            color: #dc2626;
        }

        .alert-success {
            background: #f0fdf4;
            border-left: 4px solid #22c55e;
            color: #16a34a;
        }

        .alert-info {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            color: #2563eb;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Loading Spinner */
        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 20px;
            color: #999;
            font-size: 12px;
        }

        /* Utility Classes */
        .text-center {
            text-align: center;
        }

        .mt-2 {
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💳 Complete Payment</h1>
            <p>Review your order and complete payment</p>
        </div>

        <div class="payment-card">
            <!-- Alert Container -->
            <div id="alertContainer" style="padding: 0 20px; margin-top: 20px;"></div>

            <!-- Order Summary -->
            <div class="order-summary">
                <h3>
                    📋 Order Summary
                    <span id="orderIdBadge" class="order-id-badge">Loading...</span>
                </h3>
                <div id="orderSummaryContent">
                    <div class="summary-row">
                        <span class="summary-label">Loading order details...</span>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="payment-methods">
                <h3>💰 Select Payment Method</h3>
                
                <div class="method-option" data-method="mpesa">
                    <input type="radio" name="paymentMethod" value="mpesa" id="mpesa" class="method-radio" checked>
                    <div class="method-icon">📱</div>
                    <div class="method-info">
                        <div class="method-name">M-Pesa</div>
                        <div class="method-description">Pay using M-Pesa STK Push</div>
                    </div>
                </div>

                <div class="method-option" data-method="card">
                    <input type="radio" name="paymentMethod" value="card" id="card" class="method-radio">
                    <div class="method-icon">💳</div>
                    <div class="method-info">
                        <div class="method-name">Card Payment</div>
                        <div class="method-description">Visa, Mastercard, American Express</div>
                    </div>
                </div>

                <div class="method-option" data-method="bank">
                    <input type="radio" name="paymentMethod" value="bank" id="bank" class="method-radio">
                    <div class="method-icon">🏦</div>
                    <div class="method-info">
                        <div class="method-name">Bank Transfer</div>
                        <div class="method-description">Direct bank transfer</div>
                    </div>
                </div>
            </div>

            <!-- M-Pesa Phone Input -->
            <div id="phoneSection" class="phone-section">
                <div class="phone-input-group">
                    <label>📞 M-Pesa Phone Number</label>
                    <div class="phone-input-wrapper">
                        <span class="country-code">+254</span>
                        <input type="tel" id="phoneNumber" placeholder="712 345 678" autocomplete="off">
                    </div>
                    <div class="phone-hint">Enter the phone number registered with M-Pesa</div>
                </div>
            </div>

            <!-- Pay Button -->
            <div class="pay-button-container">
                <button id="payButton" class="pay-btn">
                    💳 Pay Now
                </button>
            </div>
        </div>

        <div class="footer">
            🔒 Secure payment powered by M-Pesa
        </div>
    </div>

    <script>
        // Get order ID and token from URL
        const urlParams = new URLSearchParams(window.location.search);
        const orderId = urlParams.get('order_id');
        const token = urlParams.get('token');
        
        // Use order_id if available, otherwise use token
        const orderIdentifier = orderId || token;
        
        // State
        let orderData = null;
        let selectedMethod = 'mpesa';
        let isProcessing = false;
        
        // DOM Elements
        const alertContainer = document.getElementById('alertContainer');
        const orderIdBadge = document.getElementById('orderIdBadge');
        const orderSummaryContent = document.getElementById('orderSummaryContent');
        const phoneSection = document.getElementById('phoneSection');
        const phoneNumberInput = document.getElementById('phoneNumber');
        const payButton = document.getElementById('payButton');
        const methodOptions = document.querySelectorAll('.method-option');
        
        // Show alert message
        function showAlert(message, type = 'error') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} show`;
            
            const icon = type === 'success' ? '✅' : (type === 'info' ? 'ℹ️' : '⚠️');
            alertDiv.innerHTML = `${icon} ${message}`;
            
            alertContainer.innerHTML = '';
            alertContainer.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.classList.remove('show');
                setTimeout(() => {
                    if (alertContainer.contains(alertDiv)) {
                        alertContainer.removeChild(alertDiv);
                    }
                }, 300);
            }, 5000);
        }
        
        // Format currency
        function formatCurrency(amount) {
            return `KES ${parseFloat(amount).toLocaleString('en-KE')}`;
        }
        
        // Format phone number for display
        function formatPhoneNumber(phone) {
            if (!phone) return '';
            let cleaned = phone.replace(/\D/g, '');
            if (cleaned.startsWith('0')) {
                cleaned = '254' + cleaned.substring(1);
            }
            if (!cleaned.startsWith('254')) {
                cleaned = '254' + cleaned;
            }
            return cleaned;
        }
        
        // Load order details
        async function loadOrderDetails() {
            if (!orderIdentifier) {
                showAlert('Order ID not found. Please check your payment link.', 'error');
                orderIdBadge.textContent = 'Error';
                orderSummaryContent.innerHTML = `
                    <div class="summary-row">
                        <span class="summary-label" style="color: #ef4444;">Invalid payment link</span>
                    </div>
                `;
                payButton.disabled = true;
                return;
            }
            
            orderIdBadge.textContent = `#${orderIdentifier}`;
            
            try {
                // Fetch order details from your backend
                // Replace this URL with your actual API endpoint
                const response = await fetch(`/api/orders/${orderIdentifier}/`);
                
                if (!response.ok) {
                    throw new Error('Order not found');
                }
                
                orderData = await response.json();
                displayOrderSummary();
                
                // Pre-fill phone if available
                if (orderData.customer_phone) {
                    let phone = orderData.customer_phone.replace(/\D/g, '');
                    if (phone.startsWith('254')) {
                        phone = phone.substring(3);
                    }
                    phoneNumberInput.value = phone;
                }
                
            } catch (error) {
                console.error('Error loading order:', error);
                showAlert('Unable to load order details. Please try again.', 'error');
                orderIdBadge.textContent = '#Error';
                orderSummaryContent.innerHTML = `
                    <div class="summary-row">
                        <span class="summary-label" style="color: #ef4444;">Failed to load order details</span>
                    </div>
                `;
                payButton.disabled = true;
            }
        }
        
        // Display order summary
        function displayOrderSummary() {
            if (!orderData) return;
            
            let itemsHtml = '';
            
            // Display items
            if (orderData.items && orderData.items.length > 0) {
                orderData.items.forEach(item => {
                    const itemTotal = (item.price || 0) * (item.quantity || 1);
                    itemsHtml += `
                        <div class="summary-row">
                            <span class="summary-label">${item.name || 'Item'} x ${item.quantity || 1}</span>
                            <span class="summary-value">${formatCurrency(itemTotal)}</span>
                        </div>
                    `;
                });
            }
            
            // Subtotal
            const subtotal = orderData.subtotal || orderData.total_amount || 0;
            itemsHtml += `
                <div class="summary-row">
                    <span class="summary-label">Subtotal</span>
                    <span class="summary-value">${formatCurrency(subtotal)}</span>
                </div>
            `;
            
            // Delivery fee
            const deliveryFee = orderData.delivery_fee || 0;
            if (deliveryFee > 0) {
                itemsHtml += `
                    <div class="summary-row">
                        <span class="summary-label">Delivery Fee</span>
                        <span class="summary-value">${formatCurrency(deliveryFee)}</span>
                    </div>
                `;
            }
            
            // Total
            const total = orderData.total || orderData.total_amount || subtotal + deliveryFee;
            itemsHtml += `
                <div class="summary-row total-row">
                    <span class="summary-label">Total Amount</span>
                    <span class="summary-value">${formatCurrency(total)}</span>
                </div>
            `;
            
            // Customer info
            if (orderData.customer_name) {
                itemsHtml = `
                    <div class="summary-row">
                        <span class="summary-label">Customer</span>
                        <span class="summary-value">${orderData.customer_name}</span>
                    </div>
                ` + itemsHtml;
            }
            
            orderSummaryContent.innerHTML = itemsHtml;
        }
        
        // Handle payment method selection
        function initPaymentMethods() {
            methodOptions.forEach(option => {
                option.addEventListener('click', () => {
                    const radio = option.querySelector('.method-radio');
                    radio.checked = true;
                    selectedMethod = radio.value;
                    
                    // Update selected style
                    methodOptions.forEach(opt => opt.classList.remove('selected'));
                    option.classList.add('selected');
                    
                    // Show/hide phone section
                    if (selectedMethod === 'mpesa') {
                        phoneSection.classList.add('show');
                    } else {
                        phoneSection.classList.remove('show');
                    }
                });
            });
        }
        
        // Validate phone number
        function validatePhoneNumber(phone) {
            const cleaned = phone.replace(/\D/g, '');
            if (cleaned.length === 9) {
                return `254${cleaned}`;
            } else if (cleaned.length === 10 && cleaned.startsWith('0')) {
                return `254${cleaned.substring(1)}`;
            } else if (cleaned.length === 12 && cleaned.startsWith('254')) {
                return cleaned;
            }
            return null;
        }
        
        // Process payment
        async function processPayment() {
            if (isProcessing) return;
            
            // Validate based on payment method
            if (selectedMethod === 'mpesa') {
                const phoneRaw = phoneNumberInput.value.trim();
                if (!phoneRaw) {
                    showAlert('Please enter your M-Pesa phone number', 'error');
                    phoneNumberInput.focus();
                    return;
                }
                
                const formattedPhone = validatePhoneNumber(phoneRaw);
                if (!formattedPhone) {
                    showAlert('Please enter a valid phone number (e.g., 712345678 or 0712345678)', 'error');
                    phoneNumberInput.focus();
                    return;
                }
                
                // Store formatted phone for API call
                var mpesaPhone = formattedPhone;
            }
            
            isProcessing = true;
            payButton.disabled = true;
            const originalButtonText = payButton.innerHTML;
            payButton.innerHTML = '<span class="spinner"></span> Processing...';
            
            try {
                // Prepare payment data
                const paymentData = {
                    order_id: orderIdentifier,
                    token: token,
                    payment_method: selectedMethod,
                    amount: orderData?.total || orderData?.total_amount || 0
                };
                
                // Add phone number for M-Pesa
                if (selectedMethod === 'mpesa') {
                    paymentData.phone_number = mpesaPhone;
                }
                
                // Send payment request to your backend
                // Replace this URL with your actual API endpoint
                const response = await fetch('/api/ecommerce/pay/', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(paymentData)
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    showAlert(result.message || 'Payment initiated successfully!', 'success');
                    
                    // Handle based on payment method response
                    if (selectedMethod === 'mpesa' && result.checkout_request_id) {
                        // Poll for payment status
                        pollPaymentStatus(result.checkout_request_id);
                    } else if (result.redirect_url) {
                        // Redirect to payment gateway
                        setTimeout(() => {
                            window.location.href = result.redirect_url;
                        }, 1500);
                    } else {
                        // Payment completed or waiting for confirmation
                        showAlert('Please check your phone to complete the payment', 'info');
                        setTimeout(() => {
                            window.location.href = `/payment-status.html?order_id=${orderIdentifier}&status=processing`;
                        }, 3000);
                    }
                } else {
                    showAlert(result.message || 'Payment failed. Please try again.', 'error');
                    resetPayButton(originalButtonText);
                }
                
            } catch (error) {
                console.error('Payment error:', error);
                showAlert('Network error. Please check your connection and try again.', 'error');
                resetPayButton(originalButtonText);
            }
        }
        
        // Poll payment status for M-Pesa STK Push
        async function pollPaymentStatus(checkoutRequestId) {
            let attempts = 0;
            const maxAttempts = 30; // 30 seconds
            const interval = setInterval(async () => {
                attempts++;
                
                try {
                    // Replace with your actual status check endpoint
                    const response = await fetch(`/api/ecommerce/payment-status/${checkoutRequestId}/`);
                    const result = await response.json();
                    
                    if (result.status === 'completed') {
                        clearInterval(interval);
                        showAlert('✅ Payment successful! Redirecting...', 'success');
                        setTimeout(() => {
                            window.location.href = `/payment-success.html?order_id=${orderIdentifier}`;
                        }, 1500);
                    } else if (result.status === 'failed') {
                        clearInterval(interval);
                        showAlert('❌ Payment failed. Please try again.', 'error');
                        resetPayButton('Pay Now');
                    }
                    
                    if (attempts >= maxAttempts) {
                        clearInterval(interval);
                        showAlert('Payment confirmation timeout. Please check your payment status later.', 'info');
                        resetPayButton('Check Status');
                        payButton.onclick = () => {
                            window.location.href = `/order-status.html?order_id=${orderIdentifier}`;
                        };
                    }
                    
                } catch (error) {
                    console.error('Error checking payment status:', error);
                }
            }, 1000);
        }
        
        // Reset pay button state
        function resetPayButton(text = 'Pay Now') {
            isProcessing = false;
            payButton.disabled = false;
            payButton.innerHTML = text;
        }
        
        // Initialize page
        function init() {
            initPaymentMethods();
            
            // Set default selected method
            document.querySelector('[data-method="mpesa"]').classList.add('selected');
            phoneSection.classList.add('show');
            
            // Load order details
            loadOrderDetails();
            
            // Pay button click handler
            payButton.addEventListener('click', processPayment);
            
            // Enter key in phone input
            phoneNumberInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    processPayment();
                }
            });
        }
        
        // Start the app
        init();
    </script>
</body>
</html>