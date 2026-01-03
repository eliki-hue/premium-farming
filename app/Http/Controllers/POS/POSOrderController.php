<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class POSOrderController extends Controller
{
    /**
     * Display all orders
     */
    public function index()
    {
        $orders = Order::where('status', '!=', 'hold')
            ->orderBy('created_at', 'desc')
            ->paginate(50);
            
        return view('pos.orders.index', compact('orders'));
    }
    
    /**
     * Display today's orders
     */
    public function today()
    {
        $orders = Order::whereDate('created_at', today())
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->paginate(50);
            
        $totalSales = $orders->sum('total_amount');
        $totalTransactions = $orders->count();
        
        return view('pos.orders.today', compact('orders', 'totalSales', 'totalTransactions'));
    }
    
    /**
     * Show order details
     */
    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('pos.orders.show', compact('order'));
    }
    
    /**
     * Return order
     */
    public function returnOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'return_reason' => 'required|string',
            'items' => 'required|array'
        ]);
        
        DB::beginTransaction();
        
        try {
            // Mark original order as returned
            $order->update(['status' => 'returned']);
            
            // Create return order
            $returnOrder = Order::create([
                'order_number' => 'RET-' . time(),
                'parent_order_id' => $order->id,
                'customer_name' => $order->customer_name,
                'total_amount' => 0,
                'status' => 'returned',
                'return_reason' => $request->return_reason,
                'user_id' => auth()->id()
            ]);
            
            $returnTotal = 0;
            
            foreach ($request->items as $itemId => $returnQty) {
                if ($returnQty > 0) {
                    $orderItem = OrderItem::find($itemId);
                    
                    if ($orderItem) {
                        $returnAmount = $orderItem->price * $returnQty;
                        
                        // Create return item
                        OrderItem::create([
                            'order_id' => $returnOrder->id,
                            'product_name' => $orderItem->product_name,
                            'quantity' => $returnQty,
                            'price' => $orderItem->price,
                            'total' => $returnAmount
                        ]);
                        
                        // Restock product if we can find it
                        $product = Product::where('name', $orderItem->product_name)->first();
                        if ($product) {
                            $product->increment('stock', $returnQty);
                        }
                        
                        $returnTotal += $returnAmount;
                    }
                }
            }
            
            // Update return order total
            $returnOrder->update(['total_amount' => $returnTotal]);
            
            DB::commit();
            
            return redirect()->route('pos.orders.index')->with('success', 'Order returned successfully');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Display held orders
     */
    public function holdOrders()
    {
        $orders = Order::where('status', 'hold')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('pos.orders.hold', compact('orders'));
    }
    
    /**
     * Release held order
     */
    public function releaseHold($id)
    {
        $order = Order::findOrFail($id);
        
        if ($order->status !== 'hold') {
            return back()->with('error', 'Order is not on hold');
        }
        
        $order->update(['status' => 'pending']);
        
        return redirect()->route('pos.orders.hold')->with('success', 'Order released from hold');
    }
    
    /**
     * Cancel order
     */
    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);
        
        DB::beginTransaction();
        
        try {
            // Restock items
            foreach ($order->items as $item) {
                $product = Product::where('name', $item->product_name)->first();
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }
            
            // Mark as cancelled
            $order->update(['status' => 'cancelled']);
            
            DB::commit();
            
            return redirect()->route('pos.orders.index')->with('success', 'Order cancelled');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}