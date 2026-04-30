<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppPaymentController extends Controller
{
    /**
     * Send payment link via WhatsApp
     */
    public function sendPaymentLink(Request $request)
    {
        try {
            $request->validate([
                'order_ref' => 'required|string',
                'customer_phone' => 'required|string',
                'customer_name' => 'required|string',
                'whatsapp_message' => 'required|string',
                'payment_link' => 'required|url',
                'total' => 'required|numeric',
                'items' => 'required|array',
                'delivery_details' => 'required|array'
            ]);

            // Store order in database (you'll need to create this model)
            $order = $this->createOrder($request);

            // Send WhatsApp message
            $sent = $this->sendWhatsAppMessage(
                $request->customer_phone,
                $request->whatsapp_message
            );

            if (!$sent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send WhatsApp message. Please try again.'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Payment link sent successfully',
                'order_ref' => $request->order_ref,
                'payment_link' => $request->payment_link
            ]);

        } catch (\Exception $e) {
            Log::error('WhatsApp payment link error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order details for payment page
     */
    public function getOrder(Request $request, $orderRef)
    {
        try {
            // Retrieve order from database
            $order = \App\Models\Order::where('order_ref', $orderRef)
                ->where('status', 'pending')
                ->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found or expired'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'order_ref' => $order->order_ref,
                'customer_name' => $order->customer_name,
                'customer_phone' => $order->customer_phone,
                'total' => $order->total,
                'items' => json_decode($order->items),
                'delivery_details' => json_decode($order->delivery_details)
            ]);

        } catch (\Exception $e) {
            Log::error('Get order error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred'
            ], 500);
        }
    }

    /**
     * Create order in database
     */
    private function createOrder($request)
    {
        // You'll need to create an Order model and migration
        return \App\Models\Order::create([
            'order_ref' => $request->order_ref,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email ?? null,
            'total' => $request->total,
            'items' => json_encode($request->items),
            'delivery_details' => json_encode($request->delivery_details),
            'payment_link' => $request->payment_link,
            'status' => 'pending',
            'expires_at' => now()->addHours(24)
        ]);
    }

    /**
     * Send WhatsApp message using your preferred WhatsApp API
     * This example uses Twilio, but you can use any provider
     */
    private function sendWhatsAppMessage($phone, $message)
    {
        try {
            // Format phone number (remove 0 and add country code if needed)
            $phone = $this->formatPhoneNumber($phone);

            // Example using Twilio WhatsApp API
            // $twilio = new \Twilio\Rest\Client(
            //     env('TWILIO_SID'),
            //     env('TWILIO_AUTH_TOKEN')
            // );
            
            // $twilio->messages->create(
            //     "whatsapp:{$phone}",
            //     [
            //         "from" => "whatsapp:" . env('TWILIO_WHATSAPP_NUMBER'),
            //         "body" => $message
            //     ]
            // );

            // For now, we'll log the message
            Log::info('WhatsApp message would be sent:', [
                'to' => $phone,
                'message' => $message
            ]);

            // Return true for development
            return true;

        } catch (\Exception $e) {
            Log::error('WhatsApp send error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Format phone number for WhatsApp
     */
    private function formatPhoneNumber($phone)
    {
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // If starts with 0, replace with 254
        if (substr($phone, 0, 1) === '0') {
            $phone = '254' . substr($phone, 1);
        }
        
        // If doesn't start with 254, add it
        if (substr($phone, 0, 3) !== '254') {
            $phone = '254' . $phone;
        }
        
        return $phone;
    }
}
