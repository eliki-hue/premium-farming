<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class POSReportController extends Controller
{
    /**
     * Display reports dashboard
     */
    public function index()
    {
        // Today's stats
        $todaySales = Order::whereDate('created_at', today())
            ->where('status', 'completed')
            ->sum('total_amount');
            
        $todayOrders = Order::whereDate('created_at', today())
            ->where('status', 'completed')
            ->count();
            
        // Monthly stats
        $monthlySales = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'completed')
            ->sum('total_amount');
            
        // Top products today
        $topProductsToday = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_qty'))
            ->whereHas('order', function($q) {
                $q->whereDate('created_at', today())
                  ->where('status', 'completed');
            })
            ->groupBy('product_name')
            ->orderBy('total_qty', 'desc')
            ->limit(5)
            ->get();
            
        return view('pos.reports.index', compact(
            'todaySales',
            'todayOrders',
            'monthlySales',
            'topProductsToday'
        ));
    }
    
    /**
     * Sales report
     */
    public function salesReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());
        
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->paginate(50);
            
        $totalSales = $orders->sum('total_amount');
        $totalOrders = $orders->total();
        
        return view('pos.reports.sales', compact('orders', 'totalSales', 'totalOrders', 'startDate', 'endDate'));
    }
    
    /**
     * Daily report
     */
    public function dailyReport(Request $request)
    {
        $date = $request->get('date', Carbon::today());
        
        $orders = Order::whereDate('created_at', $date)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $totalSales = $orders->sum('total_amount');
        $totalOrders = $orders->count();
        
        // Sales by hour
        $salesByHour = Order::select(
                DB::raw('HOUR(created_at) as hour'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(total_amount) as total_sales')
            )
            ->whereDate('created_at', $date)
            ->where('status', 'completed')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();
            
        return view('pos.reports.daily', compact('orders', 'totalSales', 'totalOrders', 'date', 'salesByHour'));
    }
    
    /**
     * Monthly report
     */
    public function monthlyReport(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);
        
        $orders = Order::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $totalSales = $orders->sum('total_amount');
        $totalOrders = $orders->count();
        
        // Sales by day
        $salesByDay = Order::select(
                DB::raw('DAY(created_at) as day'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(total_amount) as total_sales')
            )
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'completed')
            ->groupBy('day')
            ->orderBy('day')
            ->get();
            
        return view('pos.reports.monthly', compact('orders', 'totalSales', 'totalOrders', 'month', 'year', 'salesByDay'));
    }
    
    /**
     * Yearly report
     */
    public function yearlyReport(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        
        $orders = Order::whereYear('created_at', $year)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $totalSales = $orders->sum('total_amount');
        $totalOrders = $orders->count();
        
        // Sales by month
        $salesByMonth = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(total_amount) as total_sales')
            )
            ->whereYear('created_at', $year)
            ->where('status', 'completed')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        return view('pos.reports.yearly', compact('orders', 'totalSales', 'totalOrders', 'year', 'salesByMonth'));
    }
    
    /**
     * Best sellers report
     */
    public function bestSellers(Request $request)
    {
        $period = $request->get('period', 'daily');
        
        switch ($period) {
            case 'daily':
                $date = Carbon::today();
                $products = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(total) as total_sales'))
                    ->whereHas('order', function($q) use ($date) {
                        $q->whereDate('created_at', $date)
                          ->where('status', 'completed');
                    })
                    ->groupBy('product_name')
                    ->orderBy('total_quantity', 'desc')
                    ->get();
                break;
                
            case 'monthly':
                $month = Carbon::now()->month;
                $year = Carbon::now()->year;
                $products = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(total) as total_sales'))
                    ->whereHas('order', function($q) use ($month, $year) {
                        $q->whereMonth('created_at', $month)
                          ->whereYear('created_at', $year)
                          ->where('status', 'completed');
                    })
                    ->groupBy('product_name')
                    ->orderBy('total_quantity', 'desc')
                    ->get();
                break;
                
            case 'yearly':
                $year = Carbon::now()->year;
                $products = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(total) as total_sales'))
                    ->whereHas('order', function($q) use ($year) {
                        $q->whereYear('created_at', $year)
                          ->where('status', 'completed');
                    })
                    ->groupBy('product_name')
                    ->orderBy('total_quantity', 'desc')
                    ->get();
                break;
                
            default:
                $products = collect();
        }
        
        return view('pos.reports.best-sellers', compact('products', 'period'));
    }
    
    /**
     * Stock report
     */
    public function stockReport()
    {
        $products = Product::orderBy('stock', 'asc')->get();
        
        $stockValue = $products->sum(function($product) {
            return $product->stock * ($product->buying_price ?? $product->selling_price * 0.7);
        });
        
        $lowStockCount = $products->where('stock', '<=', 5)->count();
        $outOfStockCount = $products->where('stock', '<=', 0)->count();
        
        // Categories
        $categories = $products->groupBy('category')->map(function($categoryProducts) {
            return [
                'count' => $categoryProducts->count(),
                'stock_value' => $categoryProducts->sum(function($p) {
                    return $p->stock * ($p->buying_price ?? $p->selling_price * 0.7);
                })
            ];
        });
        
        return view('pos.reports.stock', compact('products', 'stockValue', 'lowStockCount', 'outOfStockCount', 'categories'));
    }
    
    /**
     * Payment method report
     */
    public function paymentReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());
        
        $payments = Order::select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_amount) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->groupBy('payment_method')
            ->orderBy('total', 'desc')
            ->get();
            
        $totalSales = $payments->sum('total');
        
        return view('pos.reports.payment', compact('payments', 'totalSales', 'startDate', 'endDate'));
    }
}