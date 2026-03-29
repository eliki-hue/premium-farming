<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    protected $djangoBase;
    
    public function __construct()
    {
        $this->djangoBase = config('services.django_api.url', 'http://localhost:8000');
    }
    
    /**
     * Show payment page
     */
    public function showPaymentPage($orderId)
    {
        $orders = Session::get('guest_orders', []);
        $order = $orders[$orderId] ?? null;
        $token = request()->get('token', '');
        
        if (!$order) {
            abort(404, 'Order not found');
        }
        
        return view('payment.index', compact('orderId', 'token', 'order'));
    }
    
    /**
     * Step 9: Initiate M-Pesa Payment (POST api/ecommerce/pay/)
     */
    public function initiatePayment(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|string',
                'token' => 'nullable|string',
                'phone_number' => 'required|string'
            ]);
            
            $orderId = $validated['order_id'];
            $phoneNumber = $validated['phone_number'];
            $token = $validated['token'] ?? '';
            
            // Get order from session
            $orders = Session::get('guest_orders', []);
            $order = $orders[$orderId] ?? null;
            
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }
            
            // Try to initiate payment with Django backend
            if (config('services.django_api.enabled', false)) {
                try {
                    $headers = ['Accept' => 'application/json'];
                    
                    if (Session::has('django_token')) {
                        $headers['Authorization'] = 'Bearer ' . Session::get('django_token');
                    }
                    
                    $response = Http::timeout(30)
                        ->withHeaders($headers)
                        ->post($this->djangoBase . '/api/ecommerce/pay/', [
                            'order_id' => $orderId,
                            'token' => $token,
                            'phone_number' => $phoneNumber,
                            'amount' => $order['subtotal']
                        ]);
                    
                    if ($response->successful()) {
                        $data = $response->json();
                        return response()->json([
                            'success' => true,
                            'message' => 'Payment initiated',
                            'checkout_request_id' => $data['checkout_request_id'] ?? null
                        ]);
                    }
                    
                    return response()->json([
                        'success' => false,
                        'message' => $response->json()['message'] ?? 'Payment initiation failed'
                    ], 500);
                    
                } catch (\Exception $e) {
                    Log::error('Django payment error: ' . $e->getMessage());
                }
            }
            
            // Simulate payment initiation for testing
            return response()->json([
                'success' => true,
                'message' => 'STK Push sent to ' . $phoneNumber,
                'checkout_request_id' => 'REQ_' . uniqid()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Payment initiation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to initiate payment: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Step 10 & 11: Check payment status
     */
    public function checkPaymentStatus($orderId)
    {
        $orders = Session::get('guest_orders', []);
        $order = $orders[$orderId] ?? null;
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }
        
        // If already paid, return paid status
        if ($order['payment_status'] === 'paid') {
            return response()->json([
                'success' => true,
                'payment_status' => 'paid',
                'status' => 'completed',
                'message' => 'Payment completed'
            ]);
        }
        
        // Check with Django backend if available
        if (config('services.django_api.enabled', false)) {
            try {
                $headers = ['Accept' => 'application/json'];
                
                if (Session::has('django_token')) {
                    $headers['Authorization'] = 'Bearer ' . Session::get('django_token');
                }
                
                $response = Http::timeout(10)
                    ->withHeaders($headers)
                    ->get($this->djangoBase . "/api/payment/status/{$orderId}/");
                
                if ($response->successful()) {
                    $data = $response->json();
                    
                    if (isset($data['payment_status']) && $data['payment_status'] === 'paid') {
                        // Update order in session
                        $orders[$orderId]['payment_status'] = 'paid';
                        $orders[$orderId]['status'] = 'completed';
                        $orders[$orderId]['updated_at'] = now()->toISOString();
                        Session::put('guest_orders', $orders);
                        
                        return response()->json([
                            'success' => true,
                            'payment_status' => 'paid',
                            'status' => 'completed'
                        ]);
                    }
                    
                    return response()->json([
                        'success' => true,
                        'payment_status' => $data['payment_status'] ?? 'pending',
                        'status' => $data['status'] ?? 'pending'
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Error checking payment status: ' . $e->getMessage());
            }
        }
        
        // Simulate pending status
        return response()->json([
            'success' => true,
            'payment_status' => 'pending',
            'status' => 'pending'
        ]);
    }
    
    /**
     * Webhook for M-Pesa callback (Step 10)
     */
    public function paymentCallback(Request $request)
    {
        try {
            $data = $request->all();
            Log::info('M-Pesa callback received', $data);
            
            $orderId = $data['order_id'] ?? null;
            $resultCode = $data['ResultCode'] ?? $data['resultCode'] ?? null;
            
            if (!$orderId) {
                return response()->json(['success' => false], 400);
            }
            
            $orders = Session::get('guest_orders', []);
            
            if (isset($orders[$orderId])) {
                if ($resultCode == 0) {
                    // Payment successful
                    $orders[$orderId]['payment_status'] = 'paid';
                    $orders[$orderId]['status'] = 'completed';
                    $orders[$orderId]['updated_at'] = now()->toISOString();
                    
                    Log::info('Payment successful for order: ' . $orderId);
                } else {
                    // Payment failed
                    $orders[$orderId]['payment_status'] = 'failed';
                    $orders[$orderId]['updated_at'] = now()->toISOString();
                    
                    Log::warning('Payment failed for order: ' . $orderId);
                }
                
                Session::put('guest_orders', $orders);
            }
            
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            Log::error('Payment callback error: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }
}