<?php

namespace App\Services;

use App\Models\TempOrder;

class WhatsAppService
{
    protected string $businessNumber;
    protected string $returnBaseUrl;
    
    public function __construct()
    {
        $this->businessNumber = env('WHATSAPP_NUMBER', '254712345678');
        $this->returnBaseUrl = env('APP_URL', 'http://localhost');
    }
    
    /**
     * Generate WhatsApp URL with cart items and return instructions
     */
    public function generateCartUrl(array $cartItems, ?array $customerInfo = null, ?int $tempOrderId = null): string
    {
        $message = $this->formatWhatsAppMessage($cartItems, $customerInfo, $tempOrderId);
        $encodedMessage = urlencode($message);
        
        return "https://wa.me/{$this->businessNumber}?text={$encodedMessage}";
    }
    
    /**
     * Format cart items into detailed WhatsApp message
     */
    protected function formatWhatsAppMessage(array $cartItems, ?array $customerInfo, ?int $tempOrderId): string
    {
        // Header with order reference
        $message = "🛒 *NEW ORDER INQUIRY*\n";
        $message .= "══════════════════════════\n\n";
        
        if ($tempOrderId) {
            $message .= "*Order Reference:* #{$tempOrderId}\n";
            $message .= "*Date:* " . now()->format('d/m/Y H:i') . "\n\n";
        }
        
        // Cart Items Section
        $message .= "*📦 ITEMS ORDERED*\n";
        $message .= "──────────────────────────\n";
        
        $total = 0;
        foreach ($cartItems as $index => $item) {
            $subtotal = $item['unit_price'] * $item['quantity'];
            $total += $subtotal;
            
            $message .= ($index + 1) . ". *{$item['product_name']}*\n";
            $message .= "   ├─ Qty: {$item['quantity']}\n";
            $message .= "   ├─ Price: KES " . number_format($item['unit_price'], 2) . " each\n";
            $message .= "   └─ Subtotal: KES " . number_format($subtotal, 2) . "\n\n";
        }
        
        $message .= "──────────────────────────\n";
        $message .= "*SUB TOTAL: KES " . number_format($total, 2) . "*\n\n";
        
        // Customer Details Section (if available)
        if ($customerInfo && !empty(array_filter($customerInfo))) {
            $message .= "*👤 CUSTOMER DETAILS*\n";
            $message .= "──────────────────────────\n";
            
            if (!empty($customerInfo['name'])) {
                $message .= "├─ Name: {$customerInfo['name']}\n";
            }
            if (!empty($customerInfo['phone'])) {
                $message .= "├─ Phone: {$customerInfo['phone']}\n";
            }
            if (!empty($customerInfo['email'])) {
                $message .= "├─ Email: {$customerInfo['email']}\n";
            }
            if (!empty($customerInfo['address'])) {
                $message .= "├─ Address: {$customerInfo['address']}\n";
            }
            if (!empty($customerInfo['county'])) {
                $message .= "├─ County: {$customerInfo['county']}\n";
            }
            if (!empty($customerInfo['town'])) {
                $message .= "└─ Town: {$customerInfo['town']}\n";
            }
            $message .= "\n";
        }
        
        // Delivery Information Request
        $message .= "*📍 DELIVERY INFORMATION NEEDED*\n";
        $message .= "──────────────────────────\n";
        $message .= "Please provide:\n";
        $message .= "├─ Delivery location (County/Town)\n";
        $message .= "├─ Delivery charges\n";
        $message .= "├─ Estimated delivery time\n";
        $message .= "└─ Any special instructions\n\n";
        
        // Return to Checkout Instructions
        if ($tempOrderId) {
            $message .= "*✅ TO COMPLETE ORDER*\n";
            $message .= "──────────────────────────\n";
            $message .= "1. Reply with delivery details above\n";
            $message .= "2. Click this link to return to checkout:\n";
            $returnUrl = "{$this->returnBaseUrl}/checkout/resume/{$tempOrderId}";
            $message .= "🔗 {$returnUrl}\n\n";
        }
        
        // Footer
        $message .= "──────────────────────────\n";
        $message .= "_Thank you for choosing our services!_\n";
        $message .= "⭐ Reply with delivery details to proceed.";
        
        return $message;
    }

    /**
     * Generate return to checkout URL
     */
    public function generateReturnUrl(int $tempOrderId): string
    {
        return route('checkout.resume', ['orderId' => $tempOrderId]);
    }
    
    /**
     * Format message for quick order (minimal version)
     */
    public function generateQuickOrderUrl(array $cartItems): string
    {
        $message = "I'd like to order:\n\n";
        
        foreach ($cartItems as $item) {
            $message .= "• {$item['product_name']} x {$item['quantity']} = KES " . 
                       number_format($item['unit_price'] * $item['quantity'], 2) . "\n";
        }
        
        $message .= "\nTotal: KES " . number_format(array_sum(array_map(function($item) {
            return $item['unit_price'] * $item['quantity'];
        }, $cartItems)), 2);
        
        $encodedMessage = urlencode($message);
        return "https://wa.me/{$this->businessNumber}?text={$encodedMessage}";
    }
}