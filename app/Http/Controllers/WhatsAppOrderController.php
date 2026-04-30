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
    protected string $whatsappNumber;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->djangoApiUrl = env('DJANGO_API_URL', 'http://localhost:8000');
        $this->whatsappNumber = env('WHATSAPP_NUMBER', '0700680017');
    }

    /**
     * Prepare order before WhatsApp redirect
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function prepareWhatsAppOrder(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'email' => 'required|email|max:255',
                'address' => 'nullable|string',
                'county' => 'nullable|string',
                'town' => 'nullable|string',
                'delivery_type' => 'nullable|string|in:farm_delivery,pickup_station'
            ]);

            // Get cart from Django
            $cart = $this->getCartFromDjango();
            
            if (!$cart) {
                return response()->json([
                    'success' => false,
                    'message' => 'Could not load your cart. Please try again.'
                ], 400);
            }

            if (empty($cart['items'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty. Add items before proceeding.'
                ], 400);
            }

            // Generate unique order reference
            $orderRef = $this->generateOrderRef();

            // Format WhatsApp message with return URL
            $whatsappMessage = $this->formatWhatsAppMessage(
                $cart['items'],
                $cart['subtotal'],
                $validated['name'],
                $orderRef
            );

            // Create temporary order
            $tempOrder = TempOrder::create([
                'session_id' => session()->getId(),
                'order_ref' => $orderRef,
                'django_user_id' => session('django_user.id'),
                'django_token' => session('django_token'),
                'cart_items' => $cart['items'],
                'subtotal' => $cart['subtotal'],
                'customer_name' => $validated['name'],
                'customer_phone' => $validated['phone'],
                'customer_email' => $validated['email'],
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

            // Format WhatsApp number
            $formattedNumber = $this->formatWhatsAppNumber($this->whatsappNumber);
            
            // Encode message for URL
            $encodedMessage = urlencode($whatsappMessage);
            
            // Generate WhatsApp URL
            $whatsappUrl = "https://wa.me/{$formattedNumber}?text={$encodedMessage}";

            // Generate return URL for checkout
            $returnUrl = route('checkout.resume', ['orderRef' => $orderRef]);

            // Log the action
            Log::info('WhatsApp order prepared', [
                'order_ref' => $orderRef,
                'user_id' => session('django_user.id'),
                'item_count' => count($cart['items']),
                'subtotal' => $cart['subtotal']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order prepared successfully',
                'whatsapp_url' => $whatsappUrl,
                'order_ref' => $orderRef,
                'temp_order_id' => $tempOrder->id,
                'return_url' => $returnUrl,
                'item_count' => count($cart['items']),
                'subtotal' => $cart['subtotal']
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('WhatsApp order preparation error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to prepare order. Please try again.'
            ], 500);
        }
    }

    /**
     * Resume checkout after WhatsApp discussion
     * 
     * @param string $orderRef
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resumeCheckout($orderRef)
    {
        try {
            // Find the temp order
            $tempOrder = TempOrder::where('order_ref', $orderRef)
                ->where(function($query) {
                    $query->where('session_id', session()->getId())
                          ->orWhere('django_user_id', session('django_user.id'));
                })
                ->first();

            if (!$tempOrder) {
                Log::warning('Order not found for resume', ['order_ref' => $orderRef]);
                return redirect()->route('cart.view')
                    ->with('error', 'Order not found. Please start again.');
            }

            // Check if order expired
            if (!$this->isOrderValid($tempOrder)) {
                $tempOrder->update(['status' => TempOrder::STATUS_EXPIRED]);
                return redirect()->route('cart.view')
                    ->with('error', 'Your order session has expired. Please start again.');
            }

            // Update status
            $tempOrder->update([
                'status' => TempOrder::STATUS_RETURNED_FOR_CHECKOUT
            ]);

            // Store in session
            session([
                'temp_order_id' => $tempOrder->id,
                'temp_order_ref' => $tempOrder->order_ref
            ]);

            // Restore cart items in Django
            $this->restoreCartInDjango($tempOrder);

            // Log the return
            Log::info('User returned from WhatsApp', [
                'order_ref' => $orderRef,
                'user_id' => session('django_user.id')
            ]);

            // Redirect to cart with resume parameter
            return redirect()->route('cart.view', ['resume' => $orderRef])
                ->with('success', 'Welcome back! Complete your payment to place the order.');

        } catch (\Exception $e) {
            Log::error('Resume checkout error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('cart.view')
                ->with('error', 'Failed to resume checkout. Please try again.');
        }
    }

    /**
     * Get order details for returning customer
     * 
     * @param string $orderRef
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrderDetails($orderRef)
    {
        try {
            $tempOrder = TempOrder::where('order_ref', $orderRef)
                ->where(function($query) {
                    $query->where('session_id', session()->getId())
                          ->orWhere('django_user_id', session('django_user.id'));
                })
                ->first();

            if (!$tempOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            if (!$this->isOrderValid($tempOrder)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order has expired'
                ], 410);
            }

            return response()->json([
                'success' => true,
                'order' => [
                    'order_ref' => $tempOrder->order_ref,
                    'customer_name' => $tempOrder->customer_name,
                    'customer_phone' => $tempOrder->customer_phone,
                    'customer_email' => $tempOrder->customer_email,
                    'delivery_address' => $tempOrder->delivery_address,
                    'county' => $tempOrder->county,
                    'town' => $tempOrder->town,
                    'delivery_type' => $tempOrder->delivery_type,
                    'subtotal' => $tempOrder->subtotal,
                    'items' => $tempOrder->cart_items,
                    'created_at' => $tempOrder->created_at,
                    'expires_at' => $tempOrder->expires_at
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Get order details error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get order details'
            ], 500);
        }
    }

    /**
     * Update order with delivery information from WhatsApp
     * 
     * @param Request $request
     * @param string $orderRef
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDeliveryInfo(Request $request, $orderRef)
    {
        try {
            $validated = $request->validate([
                'delivery_charge' => 'required|numeric|min:0',
                'delivery_address' => 'required|string',
                'county' => 'required|string',
                'town' => 'required|string',
                'delivery_type' => 'required|in:farm_delivery,pickup_station',
                'whatsapp_conversation' => 'nullable|string'
            ]);

            $tempOrder = TempOrder::where('order_ref', $orderRef)
                ->where('status', TempOrder::STATUS_WHATSAPP_SENT)
                ->first();

            if (!$tempOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found or cannot be updated'
                ], 404);
            }

            $tempOrder->update([
                'delivery_charge' => $validated['delivery_charge'],
                'delivery_address' => $validated['delivery_address'],
                'county' => $validated['county'],
                'town' => $validated['town'],
                'delivery_type' => $validated['delivery_type'],
                'whatsapp_conversation' => $validated['whatsapp_conversation'] ?? $tempOrder->whatsapp_conversation,
                'status' => TempOrder::STATUS_DELIVERY_UPDATED
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Delivery information updated successfully',
                'order' => [
                    'order_ref' => $tempOrder->order_ref,
                    'total' => $tempOrder->total
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Update delivery info error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update delivery information'
            ], 500);
        }
    }

    /**
     * Complete checkout after WhatsApp discussion
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function completeCheckout(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_ref' => 'required|string',
                'mpesa_number' => 'required|string'
            ]);

            $tempOrder = TempOrder::where('order_ref', $validated['order_ref'])
                ->where(function($query) {
                    $query->where('session_id', session()->getId())
                          ->orWhere('django_user_id', session('django_user.id'));
                })
                ->first();

            if (!$tempOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            if (!$this->isOrderValid($tempOrder)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order has expired'
                ], 410);
            }

            // Prepare data for Django M-Pesa checkout
            $mpesaData = [
                'name' => $tempOrder->customer_name,
                'phone' => $tempOrder->customer_phone,
                'email' => $tempOrder->customer_email,
                'address' => $tempOrder->delivery_address ?? $request->address,
                'county' => $tempOrder->county ?? $request->county,
                'town' => $tempOrder->town ?? $request->town,
                'delivery_type' => $tempOrder->delivery_type ?? $request->delivery_type,
                'mpesa_number' => $validated['mpesa_number'],
                'total' => $tempOrder->total,
                'delivery_charge' => $tempOrder->delivery_charge ?? 0,
                'order_ref' => $tempOrder->order_ref,
                'cart_items' => $tempOrder->cart_items
            ];

            // Forward to Django M-Pesa endpoint
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . ($tempOrder->django_token ?? session('django_token')),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->djangoApiUrl . '/api/checkout/mpesa/', $mpesaData);

            $responseData = $response->json();

            if ($response->successful()) {
                // Update temp order status
                $tempOrder->update([
                    'status' => TempOrder::STATUS_COMPLETED,
                    'django_response' => $responseData
                ]);

                // Clear session
                session()->forget(['temp_order_id', 'temp_order_ref']);

                Log::info('Order completed successfully', [
                    'order_ref' => $tempOrder->order_ref,
                    'user_id' => session('django_user.id')
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Order completed successfully',
                    'redirect_url' => route('orders') . '?order=' . $tempOrder->order_ref,
                    'order_ref' => $tempOrder->order_ref
                ]);
            }

            Log::error('Django checkout failed', [
                'order_ref' => $tempOrder->order_ref,
                'response' => $responseData
            ]);

            return response()->json([
                'success' => false,
                'message' => $responseData['message'] ?? 'M-Pesa checkout failed. Please try again.'
            ], 400);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Complete checkout error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Checkout failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Cancel WhatsApp order
     * 
     * @param string $orderRef
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelOrder($orderRef)
    {
        try {
            $tempOrder = TempOrder::where('order_ref', $orderRef)
                ->where('session_id', session()->getId())
                ->first();

            if (!$tempOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            $tempOrder->update([
                'status' => TempOrder::STATUS_CANCELLED
            ]);

            session()->forget(['temp_order_id', 'temp_order_ref']);

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Cancel order error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel order'
            ], 500);
        }
    }

    /**
     * Webhook for Django to update order status
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function webhook(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_ref' => 'required|string',
                'status' => 'required|string',
                'payment_status' => 'nullable|string',
                'delivery_info' => 'nullable|array'
            ]);

            $tempOrder = TempOrder::where('order_ref', $validated['order_ref'])->first();

            if (!$tempOrder) {
                return response()->json(['error' => 'Order not found'], 404);
            }

            $updateData = [
                'status' => $this->mapDjangoStatus($validated['status'])
            ];

            if (isset($validated['delivery_info'])) {
                $updateData['delivery_charge'] = $validated['delivery_info']['delivery_charge'] ?? $tempOrder->delivery_charge;
                $updateData['delivery_address'] = $validated['delivery_info']['address'] ?? $tempOrder->delivery_address;
                $updateData['county'] = $validated['delivery_info']['county'] ?? $tempOrder->county;
                $updateData['town'] = $validated['delivery_info']['town'] ?? $tempOrder->town;
            }

            $tempOrder->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    /**
     * Get cart from Django
     * 
     * @return array|null
     */
    private function getCartFromDjango()
    {
        $djangoToken = session('django_token');
        
        if (!$djangoToken) {
            Log::warning('No Django token found in session');
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $djangoToken,
                'Accept' => 'application/json',
            ])->timeout(10)->get($this->djangoApiUrl . '/api/cart/');
            
            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('Failed to fetch cart from Django', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Exception fetching cart from Django: ' . $e->getMessage());
        }
        
        return null;
    }

    /**
     * Restore cart in Django
     * 
     * @param TempOrder $tempOrder
     * @return void
     */
    private function restoreCartInDjango($tempOrder)
    {
        try {
            $token = $tempOrder->django_token ?? session('django_token');
            
            if (!$token) {
                Log::warning('No token for cart restore');
                return;
            }

            foreach ($tempOrder->cart_items as $item) {
                Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                ])->post($this->djangoApiUrl . '/api/cart/add/', [
                    'product' => $item['product'],
                    'quantity' => $item['quantity']
                ]);
            }
            
            Log::info('Cart restored for order', ['order_ref' => $tempOrder->order_ref]);
            
        } catch (\Exception $e) {
            Log::error('Failed to restore cart: ' . $e->getMessage());
        }
    }

    /**
     * Generate unique order reference
     * 
     * @return string
     */
    private function generateOrderRef(): string
    {
        $prefix = 'ORD';
        $date = now()->format('ymd');
        $random = strtoupper(Str::random(4));
        $unique = uniqid();
        
        return "{$prefix}-{$date}-{$random}-{$unique}";
    }

    /**
     * Format WhatsApp message
     * 
     * @param array $items
     * @param float $subtotal
     * @param string $customerName
     * @param string $orderRef
     * @return string
     */
    private function formatWhatsAppMessage(array $items, float $subtotal, string $customerName, string $orderRef): string
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
     * 
     * @param string $phone
     * @return string
     */
    private function formatWhatsAppNumber(string $phone): string
    {
        // Remove any non-digit characters
        $clean = preg_replace('/\D/', '', $phone);
        
        // If starts with 0, replace with 254
        if (str_starts_with($clean, '0')) {
            $clean = '254' . substr($clean, 1);
        }
        
        // If starts with 7, add 254
        if (str_starts_with($clean, '7')) {
            $clean = '254' . $clean;
        }
        
        return $clean;
    }

    /**
     * Check if order is still valid
     * 
     * @param TempOrder $tempOrder
     * @return bool
     */
    private function isOrderValid($tempOrder): bool
    {
        return $tempOrder->expires_at && $tempOrder->expires_at->isFuture();
    }

    /**
     * Map Django status to local status
     * 
     * @param string $djangoStatus
     * @return string
     */
    private function mapDjangoStatus(string $djangoStatus): string
    {
        return match(strtolower($djangoStatus)) {
            'paid', 'completed' => TempOrder::STATUS_COMPLETED,
            'cancelled' => TempOrder::STATUS_CANCELLED,
            'pending' => TempOrder::STATUS_WHATSAPP_SENT,
            default => $djangoStatus
        };
    }

    /**
     * Clean up expired orders (can be run as scheduled task)
     * 
     * @return void
     */
    public function cleanupExpiredOrders()
    {
        try {
            $expiredOrders = TempOrder::where('expires_at', '<', now())
                ->whereIn('status', [
                    TempOrder::STATUS_WHATSAPP_INITIATED,
                    TempOrder::STATUS_WHATSAPP_SENT,
                    TempOrder::STATUS_RETURNED_FOR_CHECKOUT
                ])
                ->update(['status' => TempOrder::STATUS_EXPIRED]);
            
            Log::info('Cleaned up expired orders', ['count' => $expiredOrders]);
            
        } catch (\Exception $e) {
            Log::error('Cleanup expired orders error: ' . $e->getMessage());
        }
    }
}