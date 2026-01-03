<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty');
        }
        
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $shipping = 500;
        $tax = $subtotal * 0.16;
        $total = $subtotal + $shipping + $tax;
        
        return view('checkout.index', compact('cart', 'subtotal', 'shipping', 'tax', 'total'));
    }
    
    public function process(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'required|email',
        'address' => 'required|string',
        'county' => 'required|string',
        'town' => 'required|string',
        'delivery_type' => 'required|string',
        'payment_method' => 'required|string',
        'mpesa_number' => 'required_if:payment_method,mpesa'
    ]);

    $cart = Session::get('cart', []);
    
    if (empty($cart)) {
        return redirect()->route('cart.view')->with('error', 'Your cart is empty');
    }

    // Calculate order totals
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    
    $shipping = ($request->delivery_type === 'farm_delivery') ? 500 : 0;
    $tax = $subtotal * 0.16;
    $total = $subtotal + $shipping + $tax;
    
    // Generate order ID
    $orderId = 'ONL-' . date('Ymd') . '-' . Str::upper(Str::random(6));
    
    // Calculate cash change if applicable
    $change = 0;
    $amountPaid = $total;
    if ($request->payment_method == 'cash' && $request->has('amount_paid')) {
        $amountPaid = $request->amount_paid;
        $change = max(0, $amountPaid - $total);
    }

    // Create order data with receipt information
    $order = [
        'order_id' => $orderId,
        'customer' => [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'county' => $request->county,
            'town' => $request->town,
        ],
        'delivery' => [
            'type' => $request->delivery_type,
            'instructions' => $request->delivery_instructions ?? '',
        ],
        'payment' => [
            'method' => $request->payment_method,
            'mpesa_number' => $request->mpesa_number ?? null,
            'amount_paid' => $amountPaid,
            'change' => $change,
            'status' => $request->payment_method == 'cash' ? 'completed' : 'pending',
            'paybill' => '247247',
            'account' => '470470',
        ],
        'items' => $cart,
        'totals' => [
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total,
        ],
        'order_date' => now()->toDateTimeString(),
        'status' => 'processing',
        'receipt_info' => [
            'branches' => 'Turitu | Githiga | Ikinu - Kiambu',
            'phones' => '0786571173 | 0708488688 | 0711633900',
            'cashier' => 'Online System',
            'notes' => 'Thank you for shopping with Premium Farming Feed!',
        ]
    ];

    // Save order to session
    $orders = Session::get('orders', []);
    $orders[$orderId] = $order;
    Session::put('orders', $orders);

    // Clear cart after order
    Session::forget('cart');

    // Redirect to receipt page
    return redirect()->route('checkout.receipt', $orderId);
}
    
    public function receipt($orderId)
    {
        $orders = Session::get('orders', []);
        
        if (!isset($orders[$orderId])) {
            return redirect()->route('home')->with('error', 'Order not found');
        }
        
        $order = $orders[$orderId];
        
        return view('checkout.receipt', compact('order'));
    }
    
    public function orders()
    {
        $orders = Session::get('orders', []);
        
        // For demo, if no orders, create a sample
        if (empty($orders)) {
            $orders = $this->getSampleOrders();
        }
        
        return view('checkout.orders', compact('orders'));
    }
    
    public function viewOrder($orderId)
    {
        $orders = Session::get('orders', []);
        
        if (!isset($orders[$orderId])) {
            // Try sample orders
            $sampleOrders = $this->getSampleOrders();
            if (isset($sampleOrders[$orderId])) {
                $order = $sampleOrders[$orderId];
            } else {
                return redirect()->route('checkout.orders')->with('error', 'Order not found');
            }
        } else {
            $order = $orders[$orderId];
        }
        
        return view('checkout.order-details', compact('order'));
    }
    
    private function getSampleOrders()
    {
        return [
            'ORD-ABC123-' . date('Ymd') => [
                'order_id' => 'ORD-ABC123-' . date('Ymd'),
                'customer' => [
                    'name' => 'John Doe',
                    'phone' => '0712345678',
                    'email' => 'john@example.com',
                    'address' => 'Farm 123, Ngong Road',
                    'county' => 'Nairobi',
                    'town' => 'Nairobi',
                ],
                'delivery' => [
                    'type' => 'farm_delivery',
                    'instructions' => 'Call before delivery',
                ],
                'payment' => [
                    'method' => 'mpesa',
                    'status' => 'completed',
                ],
                'items' => [
                    '101' => [
                        'id' => '101',
                        'name' => 'Pig Starter Pellets',
                        'price' => 3200,
                        'quantity' => 2,
                        'image' => 'images/piggrower.jpeg'
                    ],
                    '301' => [
                        'id' => '301',
                        'name' => 'Chick Starter',
                        'price' => 2500,
                        'quantity' => 1,
                        'image' => 'images/chickstart.jpeg'
                    ]
                ],
                'totals' => [
                    'subtotal' => 8900,
                    'shipping' => 500,
                    'tax' => 1424,
                    'total' => 10824,
                ],
                'order_date' => now()->subDays(2)->toDateTimeString(),
                'status' => 'delivered',
            ]
        ];
    }
}