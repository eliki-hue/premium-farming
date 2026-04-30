<?php

namespace App\Http\Controllers;

use App\Models\TempOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WhatsAppOrderController extends Controller
{
    protected string $djangoApiUrl;
    
    public function __construct()
    {
        $this->djangoApiUrl = env('DJANGO_API_URL', 'http://localhost:8000');
    }

    /**
     * Generate unique order reference
     */
    private function generateOrderRef()
    {
        $prefix = 'ORD';
        $random = strtoupper(Str::random(4));
        $timestamp = now()->format('ymd');
        return "{$prefix}-{$timestamp}-{$random}";
    }

    /**
     * Prepare and save order before WhatsApp redirect
     */
    public function prepareWhatsAppOrder(Request $request)
    {
        try {
            // Get cart from Django
            $cart = $this->getCartFromDjango();
            
            if (!$cart || empty($cart['items'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty'
                ], 400);
            }

            // Generate order reference
            $orderRef = $this->generateOrderRef();

            // Format WhatsApp message
            $whatsappMessage = $this->formatWhatsAppMessage(
                $cart['items'], 
                $cart['subtotal'], 
                $request->name ?? 'Customer',
                $orderRef
            );

            // Create temporary order
            $tempOrder = TempOrder::create([
                'session_id' => session()->getId(),
                'order_ref' => $orderRef,
                'django_user_id' => session('django_user.id'),
                'cart_items' => $cart['items'],
                'subtotal' => $cart['subtotal'],
                'customer_name' => $request->name,
                'customer_phone' => $request->phone,
                'customer_email' => $request->email,
                'delivery_address' => $request->address,
                'county' => $request->county,
                'town' => $request->town,
                'delivery_type' => $request->delivery_type,
                'whatsapp_message' => $whatsappMessage,
                'status' => TempOrder::STATUS_WHATSAPP_INITIATED,
                'expires_at' => now()->addHours(24), // Order expires in 24 hours
                'whatsapp_sent_at' => now()
            ]);

            // Store in session
            session([
                'temp_order_id' => $tempOrder->id,
                'temp_order_ref' => $orderRef
            ]);

            // Format phone for WhatsApp
            $whatsappNumber = $this->formatWhatsAppNumber('0700680017');
            $encodedMessage = urlencode($whatsappMessage);
            $whatsappUrl = "https://wa.me/{$whatsappNumber}?text={$encodedMessage}";

            // Return success with redirect URL and order info
            return response()->json([
                'success' => true,
                'whatsapp_url' => $whatsappUrl,
                'order_ref' => $orderRef,
                'temp_order_id' => $tempOrder->id,
                'checkout_return_url' => route('checkout.resume', ['orderRef' => $orderRef]),
                'message' => 'Order prepared successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('WhatsApp order preparation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to prepare order'
            ], 500);
        }
    }

    /**
     * Resume checkout after WhatsApp
     */
    public function resumeCheckout($orderRef)
    {
        try {
            // Find the temp order
            $tempOrder = TempOrder::where('order_ref', $orderRef)
                ->where('session_id', session()->getId())
                ->first();

            if (!$tempOrder) {
                return redirect()->route('cart.view')
                    ->with('error', 'Order not found. Please start again.');
            }

            // Check if order expired
            if (!$tempOrder->isValid()) {
                $tempOrder->update(['status' => TempOrder::STATUS_EXPIRED]);
                return redirect()->route('cart.view')
                    ->with('error', 'Your order session has expired. Please start again.');
            }

            // Update status
            $tempOrder->update([
                'status' => TempOrder::STATUS_RETURNED_FOR_CHECKOUT
            ]);

            // Restore cart items in Django (optional)
            $this->restoreCartInDjango($tempOrder);

            // Redirect to checkout with pre-filled data
            return redirect()->route('cart.view', ['resume' => $orderRef]);

        } catch (\Exception $e) {
            Log::error('Resume checkout error: ' . $e->getMessage());
            return redirect()->route('cart.view')
                ->with('error', 'Failed to resume checkout. Please try again.');
        }
    }

    /**
     * Complete checkout after WhatsApp
     */
    public function completeCheckout(Request $request)
    {
        try {
            $tempOrderId = session('temp_order_id');
            
            if (!$tempOrderId) {
                // Try to find by order ref
                $tempOrder = TempOrder::where('order_ref', $request->order_ref)
                    ->where('session_id', session()->getId())
                    ->first();
            } else {
                $tempOrder = TempOrder::find($tempOrderId);
            }

            if (!$tempOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            // Prepare data for Django M-Pesa checkout
            $mpesaData = [
                'name' => $tempOrder->customer_name,
                'phone' => $tempOrder->customer_phone,
                'email' => $tempOrder->customer_email,
                'address' => $request->address ?? $tempOrder->delivery_address,
                'county' => $request->county ?? $tempOrder->county,
                'town' => $request->town ?? $tempOrder->town,
                'delivery_type' => $request->delivery_type ?? $tempOrder->delivery_type,
                'mpesa_number' => $request->mpesa_number,
                'total' => $tempOrder->total,
                'delivery_charge' => $tempOrder->delivery_charge ?? 0,
                'order_ref' => $tempOrder->order_ref,
                'cart_items' => $tempOrder->cart_items
            ];

            // Forward to Django M-Pesa endpoint
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . session('django_token'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->djangoApiUrl . '/api/checkout/mpesa/', $mpesaData);

            if ($response->successful()) {
                // Update temp order status
                $tempOrder->update([
                    'status' => TempOrder::STATUS_COMPLETED
                ]);

                // Clear session
                session()->forget(['temp_order_id', 'temp_order_ref']);

                return response()->json([
                    'success' => true,
                    'message' => 'Order completed successfully',
                    'redirect_url' => '/orders?order=' . $tempOrder->order_ref
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'M-Pesa checkout failed'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Complete checkout error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Checkout failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Get cart from Django
     */
    private function getCartFromDjango()
    {
        $djangoToken = session('django_token');
        
        if (!$djangoToken) {
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $djangoToken,
                'Accept' => 'application/json',
            ])->get($this->djangoApiUrl . '/api/cart/');
            
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error('Failed to fetch cart from Django: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Restore cart in Django
     */
    private function restoreCartInDjango($tempOrder)
    {
        try {
            foreach ($tempOrder->cart_items as $item) {
                Http::withHeaders([
                    'Authorization' => 'Bearer ' . session('django_token'),
                    'Content-Type' => 'application/json',
                ])->post($this->djangoApiUrl . '/api/cart/add/', [
                    'product' => $item['product'],
                    'quantity' => $item['quantity']
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to restore cart: ' . $e->getMessage());
        }
    }

    /**
     * Format WhatsApp message
     */
    private function formatWhatsAppMessage($items, $subtotal, $customerName, $orderRef)
    {
        $message = "Hello, I would like to order the following items:\n\n";
        $message .= "Order Ref: {$orderRef}\n\n";
        
        foreach ($items as $index => $item) {
            $itemNumber = $index + 1;
            $itemTotal = $item['unit_price'] * $item['quantity'];
            $message .= "{$itemNumber}. {$item['product_name']} – {$item['quantity']} pcs – KES " . number_format($itemTotal) . "\n";
        }
        
        $message .= "\nTotal: KES " . number_format($subtotal) . "\n\n";
        $message .= "Customer: {$customerName}\n\n";
        $message .= "Please advise on delivery and transport options.\n\n";
        
        // Add return URL
        $returnUrl = route('checkout.resume', ['orderRef' => $orderRef]);
        $message .= "After we discuss delivery, return here to complete payment:\n";
        $message .= $returnUrl;
        
        return $message;
    }

    /**
     * Format phone number for WhatsApp
     */
    private function formatWhatsAppNumber($phone)
    {
        $clean = preg_replace('/\D/', '', $phone);
        if (str_starts_with($clean, '0')) {
            $clean = '254' . substr($clean, 1);
        }
        return $clean;
    }
}