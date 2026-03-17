<?php

namespace App\Http\Controllers;

use App\Models\TempOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CheckoutResumeController extends Controller
{
    protected string $djangoApiUrl;
    
    public function __construct()
    {
        $this->djangoApiUrl = env('DJANGO_API_URL', 'http://localhost:8000');
    }
    
    /**
     * Resume checkout after WhatsApp discussion
     */
    public function resumeCheckout($orderId)
    {
        try {
            $tempOrder = TempOrder::where('id', $orderId)
                ->where('session_id', session()->getId())
                ->first();
            
            if (!$tempOrder) {
                return redirect()->route('cart.view')
                    ->with('error', 'Order not found or session expired.');
            }
            
            // Check if order expired (24 hours)
            if ($tempOrder->isExpired()) {
                $tempOrder->update(['status' => TempOrder::STATUS_EXPIRED]);
                return redirect()->route('cart.view')
                    ->with('error', 'Your order session has expired. Please start over.');
            }
            
            // Update status - FIXED: Removed whatsapp_returned_at as it doesn't exist in migration
            $tempOrder->update([
                'status' => TempOrder::STATUS_RETURNED_FROM_WHATSAPP,
                // 'whatsapp_returned_at' => now() // This field doesn't exist
            ]);
            
            // Store temp order ID in session for later use
            session(['temp_order_id' => $tempOrder->id]);
            
            // Get delivery info from session if available
            $deliveryInfo = session('whatsapp_delivery_info_' . $orderId, []);
            
            // FIXED: Decode cart_items if it's JSON string
            $cartItems = is_string($tempOrder->cart_items) 
                ? json_decode($tempOrder->cart_items, true) 
                : $tempOrder->cart_items;
            
            return view('shop.checkout-resume', [
                'tempOrder' => $tempOrder,
                'deliveryInfo' => $deliveryInfo,
                'cartItems' => $cartItems,
                'subtotal' => $tempOrder->subtotal
            ]);
            
        } catch (\Exception $e) {
            Log::error('Resume checkout error: ' . $e->getMessage());
            return redirect()->route('cart.view')
                ->with('error', 'Failed to resume checkout. Please try again.');
        }
    }
    
    /**
     * Complete order with M-Pesa via Django
     */
    public function completeCheckout(Request $request)
    {
        try {
            $validated = $request->validate([
                'mpesa_number' => 'required|string',
                'address' => 'nullable|string',
                'county' => 'nullable|string',
                'town' => 'nullable|string',
                'delivery_type' => 'nullable|string',
            ]);
            
            $tempOrderId = session('temp_order_id');
            
            if (!$tempOrderId) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active order found'
                ], 400);
            }
            
            $tempOrder = TempOrder::find($tempOrderId);
            
            if (!$tempOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }
            
            // FIXED: Get Django token from session
            $djangoToken = session('django_token');
            
            if (!$djangoToken) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required',
                    'redirect' => route('login')
                ], 401);
            }
            
            // Prepare data for Django M-Pesa checkout
            $mpesaData = [
                'name' => $tempOrder->customer_name,
                'phone' => $tempOrder->customer_phone,
                'email' => $tempOrder->customer_email,
                'address' => $validated['address'] ?? $tempOrder->delivery_address,
                'county' => $validated['county'] ?? $tempOrder->county,
                'town' => $validated['town'] ?? $tempOrder->town,
                'delivery_type' => $validated['delivery_type'] ?? $tempOrder->delivery_type,
                'mpesa_number' => $validated['mpesa_number'],
                'total' => $tempOrder->subtotal + ($tempOrder->delivery_charge ?? 0),
                'delivery_charge' => $tempOrder->delivery_charge ?? 0,
                'temp_order_id' => $tempOrder->id,
                // FIXED: Ensure cart_items is array
                'cart_items' => is_string($tempOrder->cart_items) 
                    ? json_decode($tempOrder->cart_items, true) 
                    : $tempOrder->cart_items,
                'order_ref' => $tempOrder->order_ref
            ];
            
            // Forward to Django M-Pesa endpoint
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $djangoToken,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->timeout(30) // Add timeout
              ->post($this->djangoApiUrl . '/api/checkout/mpesa/', $mpesaData);
            
            $responseData = $response->json();
            
            if ($response->successful()) {
                // Update temp order
                $tempOrder->update([
                    'status' => TempOrder::STATUS_COMPLETED,
                    'django_response' => json_encode($responseData) // FIXED: Convert to JSON string
                ]);
                
                // Clear session data
                session()->forget('temp_order_id');
                session()->forget('whatsapp_delivery_info_' . $tempOrderId);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Order completed successfully',
                    'redirect_url' => route('orders'),
                    'order_data' => $responseData
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => $responseData['message'] ?? 'M-Pesa checkout failed',
                'details' => $responseData ?? null
            ], 400);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Django connection error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Unable to connect to payment service. Please try again.'
            ], 503);
        } catch (\Exception $e) {
            Log::error('Complete checkout error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Checkout failed. Please try again.'
            ], 500);
        }
    }
    
    /**
     * Webhook for Django to update delivery info
     */
    public function webhookUpdateDelivery(Request $request)
    {
        try {
            $validated = $request->validate([
                'temp_order_id' => 'required|integer',
                'delivery_charge' => 'required|numeric',
                'delivery_address' => 'required|string',
                'county' => 'required|string',
                'town' => 'required|string',
                'delivery_type' => 'required|string',
                'whatsapp_conversation' => 'nullable|string'
            ]);
            
            $tempOrder = TempOrder::find($validated['temp_order_id']);
            
            if (!$tempOrder) {
                return response()->json(['error' => 'Order not found'], 404);
            }
            
            $tempOrder->update([
                'delivery_charge' => $validated['delivery_charge'],
                'delivery_address' => $validated['delivery_address'],
                'county' => $validated['county'],
                'town' => $validated['town'],
                'delivery_type' => $validated['delivery_type'],
                'whatsapp_message' => $validated['whatsapp_conversation'] ?? null, // FIXED: Use whatsapp_message instead of whatsapp_conversation
                'status' => TempOrder::STATUS_DELIVERY_UPDATED
            ]);
            
            // Store in session for later use
            session(['whatsapp_delivery_info_' . $validated['temp_order_id'] => $validated]);
            
            return response()->json([
                'success' => true,
                'message' => 'Delivery information updated'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }
}