<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class POSStockController extends Controller
{
    /**
     * Display stock management page
     */
    public function index()
    {
        $products = Product::orderBy('name')->paginate(50);
        
        $totalStockValue = $products->sum(function($product) {
            return $product->stock * ($product->buying_price ?? $product->selling_price * 0.7);
        });
        
        $lowStockCount = $products->where('stock', '<=', 5)->count();
        
        return view('pos.stock.index', compact('products', 'totalStockValue', 'lowStockCount'));
    }
    
    /**
     * Receive stock
     */
    public function receiveStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'supplier' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);
        
        DB::beginTransaction();
        
        try {
            $product = Product::find($request->product_id);
            
            // Update stock
            $product->increment('stock', $request->quantity);
            
            // Log stock movement (you can create a StockMovement model later)
            // StockMovement::create([...]);
            
            DB::commit();
            
            return redirect()->route('pos.stock.index')->with('success', 'Stock received: ' . $request->quantity . ' ' . $product->unit . ' of ' . $product->name);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Return stock to supplier
     */
    public function returnStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'return_reason' => 'required|string',
            'supplier' => 'nullable|string'
        ]);
        
        DB::beginTransaction();
        
        try {
            $product = Product::find($request->product_id);
            
            // Check if enough stock
            if ($product->stock < $request->quantity) {
                throw new \Exception('Insufficient stock. Available: ' . $product->stock);
            }
            
            // Reduce stock
            $product->decrement('stock', $request->quantity);
            
            DB::commit();
            
            return redirect()->route('pos.stock.index')->with('success', 'Stock returned: ' . $request->quantity . ' ' . $product->unit . ' of ' . $product->name);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Display stock transfers
     */
    public function transfers()
    {
        // For now, just show products that can be transferred
        $products = Product::where('stock', '>', 0)
            ->orderBy('name')
            ->get();
            
        return view('pos.stock.transfers', compact('products'));
    }
    
    /**
     * Create stock transfer
     */
    public function createTransfer(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'from_store' => 'required|string',
            'to_store' => 'required|string',
            'notes' => 'nullable|string'
        ]);
        
        DB::beginTransaction();
        
        try {
            $product = Product::find($request->product_id);
            
            // Check stock
            if ($product->stock < $request->quantity) {
                throw new \Exception('Insufficient stock. Available: ' . $product->stock);
            }
            
            // For now, just reduce stock (in real system, you'd have multiple stores)
            $product->decrement('stock', $request->quantity);
            
            // Log transfer (you can create a StockTransfer model later)
            // StockTransfer::create([...]);
            
            DB::commit();
            
            return redirect()->route('pos.stock.transfers')->with('success', 'Transfer created: ' . $request->quantity . ' ' . $product->unit . ' of ' . $product->name);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Stock adjustment
     */
    public function adjustStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'adjustment_type' => 'required|in:add,subtract,set',
            'quantity' => 'required|integer|min:0',
            'reason' => 'required|string'
        ]);
        
        DB::beginTransaction();
        
        try {
            $product = Product::find($request->product_id);
            
            switch ($request->adjustment_type) {
                case 'add':
                    $product->increment('stock', $request->quantity);
                    $message = 'Stock added: ' . $request->quantity;
                    break;
                    
                case 'subtract':
                    if ($product->stock < $request->quantity) {
                        throw new \Exception('Insufficient stock. Available: ' . $product->stock);
                    }
                    $product->decrement('stock', $request->quantity);
                    $message = 'Stock subtracted: ' . $request->quantity;
                    break;
                    
                case 'set':
                    $product->stock = $request->quantity;
                    $product->save();
                    $message = 'Stock set to: ' . $request->quantity;
                    break;
            }
            
            DB::commit();
            
            return redirect()->route('pos.stock.index')->with('success', $message . ' ' . $product->unit . ' of ' . $product->name);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}