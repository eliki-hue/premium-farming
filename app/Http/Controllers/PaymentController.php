<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Show payment page
     */
    public function showPaymentPage($orderId, Request $request)
    {
        $token = $request->query('token');
        
        if (!$token) {
            abort(400, 'Payment token is required');
        }
        
        return view('payment', [
            'orderId' => $orderId,
            'token' => $token
        ]);
    }
    
    /**
     * Check payment status endpoint
     */
    public function checkPaymentStatus($orderId)
    {
        try {
            // Forward to your Django backend
            $response = Http::timeout(10)->get(config('services.ecommerce.api_url') . "/api/ecommerce/payment/status/{$orderId}");
            
            if ($response->successful()) {
                return response()->json($response->json());
            }
            
            return response()->json([
                'status' => 'pending',
                'message' => 'Payment status pending'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Payment status check failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to check payment status'
            ], 500);
        }
    }
}