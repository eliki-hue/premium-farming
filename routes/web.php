<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\CreditNoteController;
use App\Http\Controllers\PettyCashController;
use App\Http\Controllers\PosReturnController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConversionController;
use App\Http\Controllers\PosProductController;
use App\Http\Controllers\PosSellController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (No Auth Required - Accessible to Everyone)
|--------------------------------------------------------------------------
*/

// Home & About
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', function () {
    return view('about');
})->name('about');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

// Reviews (Public - accessible without login)
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES (Public)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthenticatedSessionController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'login'])->name('auth.login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthenticatedSessionController::class, 'register'])->name('auth.register');
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

/*
|--------------------------------------------------------------------------
| E-COMMERCE SHOP ROUTES (Public - NO AUTH REQUIRED)
|--------------------------------------------------------------------------
*/
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/shop/products', [ShopController::class, 'products'])->name('shop.products');
Route::get('/shop/product/{id}', [ShopController::class, 'show'])->name('shop.show');

// Shop Category (Public)
Route::get('/products/{category}', [ShopController::class, 'category'])
    ->whereIn('category', ['pig', 'pet', 'poultry', 'byproduct'])
    ->name('shop.category');

/*
|--------------------------------------------------------------------------
| CATEGORY ROUTES (Public)
|--------------------------------------------------------------------------
*/
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Category Views (Public)
Route::view('/category/poultry', 'categories.poultry')->name('category.poultry');
Route::view('/category/dairy', 'categories.dairy')->name('category.dairy');
Route::view('/category/swine', 'categories.swine')->name('category.swine');
Route::view('/category/pet-feeds', 'categories.pet-feeds')->name('category.pet-feeds');
Route::view('/category/by-products', 'categories.by-products')->name('category.by-products');
Route::view('/category/goat-feeds', 'categories.goat-feeds')->name('category.goat-feeds');
Route::view('/category/pig', 'categories.pig')->name('category.pig');
Route::view('/category/cattle', 'categories.cattle')->name('category.cattle');
Route::view('/category/concentrates', 'categories.concentrates')->name('category.concentrates');

/*
|--------------------------------------------------------------------------
| CART ROUTES (PROTECTED - Require Cookie Authentication)
|--------------------------------------------------------------------------
*/
Route::middleware('auth.cookie')->prefix('cart')->name('cart.')->group(function () {
    // View cart
    Route::get('/', [CartController::class, 'view'])->name('view');
    
    // Cart operations
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{itemId}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{itemId}', [CartController::class, 'remove'])->name('remove');
    Route::post('/remove/{itemId}', [CartController::class, 'remove'])->name('remove.post');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    
    // Cart info
    Route::get('/count', [CartController::class, 'count'])->name('count');
    Route::get('/info', [CartController::class, 'info'])->name('info');
    
    // Quick actions
    Route::post('/quick-add', [CartController::class, 'quickAdd'])->name('quick.add');
    Route::post('/add-multiple', [CartController::class, 'addMultiple'])->name('add.multiple');
    Route::post('/increment', [CartController::class, 'increment'])->name('increment');
    Route::post('/decrement', [CartController::class, 'decrement'])->name('decrement');
    
    // Special features (authenticated only)
    Route::post('/hold', [CartController::class, 'hold'])->name('hold');
    Route::post('/complete', [CartController::class, 'complete'])->name('complete');
    Route::post('/mpesa', [CartController::class, 'mpesa'])->name('mpesa');
    
    // Discounts
    Route::post('/apply-discount', [CartController::class, 'applyDiscount'])->name('discount.apply');
    Route::post('/remove-discount', [CartController::class, 'removeDiscount'])->name('discount.remove');
    
    // User-specific cart
    Route::get('/my-cart', [CartController::class, 'getUserCart'])->name('user');
});

/*
|--------------------------------------------------------------------------
| CHECKOUT ROUTES (PROTECTED - Require Cookie Authentication)
|--------------------------------------------------------------------------
*/
Route::middleware('auth.cookie')->prefix('checkout')->name('checkout.')->group(function () {
    // Checkout pages
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/calculate-delivery', [CheckoutController::class, 'calculateDelivery'])->name('calculate.delivery');
    Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('place.order');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    
    // Order success & receipt
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
    Route::get('/receipt/{orderId}', [CheckoutController::class, 'receipt'])->name('receipt');
    Route::get('/print-receipt/{orderId}', [CheckoutController::class, 'printReceipt'])->name('print.receipt');
    Route::get('/download-receipt/{orderId}', [CheckoutController::class, 'downloadReceipt'])->name('download.receipt');
    Route::get('/generate-receipt/{orderId}', [CheckoutController::class, 'generateReceipt'])->name('generate.receipt');
    
    // Order tracking
    Route::get('/track', [CheckoutController::class, 'trackOrder'])->name('track');
    Route::post('/track', [CheckoutController::class, 'trackOrder'])->name('track.post');
    
    // Payment confirmations
    Route::post('/confirm-payment/{orderId}', [CheckoutController::class, 'confirmPayment'])->name('confirm.payment');
    Route::get('/mpesa/{order}', [CheckoutController::class, 'showMpesaInstructions'])->name('mpesa');
    Route::get('/cheque/{order}', [CheckoutController::class, 'showChequeInstructions'])->name('cheque');
    Route::get('/bank-transfer/{order}', [CheckoutController::class, 'showBankTransferInstructions'])->name('bank-transfer');
    
    // Order history (authenticated only)
    Route::get('/orders', [CheckoutController::class, 'orders'])->name('orders');
    Route::get('/orders/{orderId}', [CheckoutController::class, 'viewOrder'])->name('order.view');
    
    // Saved addresses
    Route::get('/addresses', function () {
        return view('checkout.addresses');
    })->name('addresses');
    Route::post('/addresses', [CheckoutController::class, 'saveAddress'])->name('save.address');
});

// Public receipt route (for guest orders)
Route::get('/receipt/{order_id}/print', [CartController::class, 'printReceipt'])->name('receipt.print');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES (Session-based Auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/my-profile', function () {
        return view('profile-page');
    })->name('my.profile');

    // Logout
    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/');
    });
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | E-COMMERCE DASHBOARD (Regular User Dashboard)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | SHOP MANAGEMENT ROUTES (For logged in users)
    |--------------------------------------------------------------------------
    */
    Route::prefix('shop')->name('shop.')->group(function () {
        Route::get('/orders', [ShopController::class, 'orders'])->name('orders');
        Route::get('/reports', function () {
            return view('shop.reports');
        })->name('reports');
        
        // Customer Management
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
        
        // Orders
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES (Admin only)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        // Delivery zones
        Route::resource('delivery-zones', DeliveryZoneController::class);
        Route::get('delivery-zones/{zone}/pricing', [DeliveryZoneController::class, 'pricing'])->name('delivery-zones.pricing');
        Route::post('delivery-zones/{zone}/pricing', [DeliveryZoneController::class, 'updatePricing'])->name('delivery-zones.update-pricing');
    });

    Route::middleware(['admin'])->group(function () {
        // PRODUCT MANAGEMENT ROUTES (Admin only)
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('/', [ProductController::class, 'store'])->name('store');
            Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
            Route::put('/{product}', [ProductController::class, 'update'])->name('update');
            Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
        });

        // CATEGORY MANAGEMENT (Admin only)
        Route::get('/categories/store', [CategoryController::class, 'create'])->name('categories.store');
        Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');

        // ITEMS CRUD (POS Items - Admin only)
        Route::prefix('pos/items')->name('items.')->group(function () {
            Route::get('/', [ItemController::class, 'index'])->name('index');
            Route::post('/', [ItemController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ItemController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ItemController::class, 'update'])->name('update');
            Route::delete('/{id}', [ItemController::class, 'destroy'])->name('destroy');
        });

        // STOCK MANAGEMENT (Admin only)
        Route::post('/receive-stock', [StockController::class, 'receiveStock'])->name('receive.stock');
        Route::post('/sell', [StockController::class, 'sell'])->name('sell.product');

        // REPORTS (Admin only)
        Route::prefix('reports')->group(function () {
            Route::get('/sales', [SalesReportController::class, 'index'])->name('reports.sales');
            Route::get('/sales/report', [SalesReportController::class, 'index'])->name('sales.report');
            Route::get('/sales/report/pdf', [SalesReportController::class, 'pdf'])->name('sales.pdf');
        });

        // DOCUMENT MANAGEMENT (Admin only)
        Route::resource('invoices', InvoiceController::class);
        Route::resource('receipts', ReceiptController::class);
        Route::resource('credit-notes', CreditNoteController::class);
        Route::resource('petty-cash', PettyCashController::class);
        Route::resource('pos-returns', PosReturnController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | POS ROUTES (Requires Login)
    |--------------------------------------------------------------------------
    */
    Route::prefix('pos')->name('pos.')->group(function () {
        // POS Dashboard
        Route::get('/dashboard', function () {
            return view('pos.dashboard');
        })->name('dashboard');
        
        // POS Sell Page
        Route::get('/sell', function () {
            return view('pos.sell');
        })->name('sell');
        
        // POS Products Management
        Route::match(['GET', 'POST'], '/products', function (\Illuminate\Http\Request $request) {
            if ($request->isMethod('POST')) {
                $request->validate([
                    'name' => 'required',
                    'selling_price' => 'required|numeric',
                    'stock' => 'required|numeric',
                ]);
                
                \App\Models\PosProduct::create([
                    'name' => $request->name,
                    'selling_price' => $request->selling_price,
                    'buying_price' => $request->buying_price ?? 0,
                    'stock' => $request->stock,
                    'unit' => $request->unit ?? 'bag',
                    'category' => $request->category ?? 'poultry',
                ]);
                
                if (str_contains(url()->previous(), '/pos/sell')) {
                    return redirect()->route('pos.sell')->with('success', 'Product added successfully!');
                }
                
                return redirect()->route('pos.products')->with('success', 'Product added successfully!');
            }
            
            $products = \App\Models\PosProduct::orderBy('name')->get();
            return view('pos.products', compact('products'));
        })->name('products');
        
        // POS Routes
        Route::get('/orders', function () {
            return view('pos.orders');
        })->name('orders');
        Route::get('/reports', function () {
            return view('pos.reports');
        })->name('reports');
        Route::get('/customers', function () {
            return view('pos.customers');
        })->name('customers');
        Route::get('/inventory', function () {
            return view('pos.inventory');
        })->name('inventory');
        Route::get('/settings', function () {
            return view('pos.settings');
        })->name('settings');
        Route::get('/held-sales', [CartController::class, 'heldSales'])->name('held.sales');
        Route::get('/receipt', function () {
            return view('pos.receipt');
        })->name('receipt');
        
        Route::post('/product/store', [POSController::class, 'storeProduct'])->name('product.store');
        
        // Additional POS Routes
        Route::get('/stores', [StockController::class, 'stores'])->name('stores');
        Route::get('/update-prices', [StockController::class, 'updatePrices'])->name('update-prices');
        Route::get('/stock-take', [TransactionController::class, 'stockTake'])->name('stock-take');
        Route::post('/stock-take/store', [TransactionController::class, 'storeStockTake'])->name('stock-take.store');
        Route::get('/reports/goods-received', [ReportController::class, 'goodsReceivedReport'])->name('reports.goods-received');
        Route::get('/reports/stock-level', [ReportController::class, 'stockLevel'])->name('reports.stock-level');
        Route::get('/clients', [AccountController::class, 'clients'])->name('clients');
        Route::get('/client-terms', [AccountController::class, 'clientTerms'])->name('client-terms');
        Route::get('/invoices', [AccountController::class, 'invoices'])->name('invoices');
        Route::get('/receipts', [AccountController::class, 'receipts'])->name('receipts');
        Route::get('/credit-notes', [AccountController::class, 'creditNotes'])->name('credit-notes');
        Route::get('/petty-cash', [AccountController::class, 'pettyCash'])->name('petty-cash');
        Route::get('/conversion', [ConversionController::class, 'index'])->name('conversion');
        Route::post('/conversion', [ConversionController::class, 'store'])->name('convert.store');
    });
});

/*
|--------------------------------------------------------------------------
| DEBUG & TESTING ROUTES (Remove in production)
|--------------------------------------------------------------------------
*/
Route::get('/debug-django-real', function() {
    echo "<h1>Debug: Real Django Connection</h1>";
    
    $config = config('services.django_api');
    
    echo "<h2>Current Configuration:</h2>";
    echo "<pre>";
    print_r([
        'DJANGO_API_URL' => $config['url'],
        'DJANGO_API_USERNAME' => $config['username'],
        'DJANGO_API_PASSWORD' => $config['password'] ? '***SET***' : 'NOT SET',
        'DJANGO_API_USE_MOCK' => env('DJANGO_API_USE_MOCK', 'not set'),
        'APP_ENV' => env('APP_ENV'),
        'APP_DEBUG' => env('APP_DEBUG')
    ]);
    echo "</pre>";
    
    echo "<h2>Testing Direct Connection to Django API:</h2>";
    
    try {
        echo "<h3>1. Testing Authentication</h3>";
        $authResponse = \Illuminate\Support\Facades\Http::withOptions(['verify' => false])
            ->post($config['url'] . '/api/auth/login/', [
                'username' => $config['username'],
                'password' => $config['password']
            ]);
        
        echo "Status: " . $authResponse->status() . "<br>";
        
        if ($authResponse->successful()) {
            $token = $authResponse->json()['access'];
            echo "✅ Token obtained: " . substr($token, 0, 30) . "...<br>";
            
            echo "<h3>2. Testing Products API</h3>";
            $productsResponse = \Illuminate\Support\Facades\Http::withOptions(['verify' => false])
                ->withToken($token)
                ->get($config['url'] . '/api/public/products/');
            
            echo "Status: " . $productsResponse->status() . "<br>";
            
            if ($productsResponse->successful()) {
                $products = $productsResponse->json();
                $count = is_array($products) ? count($products) : 0;
                
                echo "✅ Found " . $count . " real products from Django!<br>";
                
                if ($count > 0) {
                    echo "<h4>Real Products from Django:</h4>";
                    echo "<table border='1' cellpadding='5'>";
                    echo "<tr><th>ID</th><th>Name</th><th>SKU</th><th>Unit Price</th><th>Unit Cost</th><th>Active</th></tr>";
                    
                    foreach ($products as $product) {
                        echo "<tr>";
                        echo "<td>" . $product['id'] . "</td>";
                        echo "<td>" . $product['name'] . "</td>";
                        echo "<td>" . $product['sku'] . "</td>";
                        echo "<td>" . $product['unit_price'] . "</td>";
                        echo "<td>" . $product['unit_cost'] . "</td>";
                        echo "<td>" . ($product['is_active'] ? 'Yes' : 'No') . "</td>";
                        echo "</tr>";
                    }
                    
                    echo "</table>";
                }
            } else {
                echo "❌ Products API Error: " . $productsResponse->body() . "<br>";
            }
        } else {
            echo "❌ Authentication failed: " . $authResponse->body() . "<br>";
        }
    } catch (\Exception $e) {
        echo "❌ Exception: " . $e->getMessage() . "<br>";
    }
    
    return "<h3>Debug Complete</h3>";
});

Route::get('/test-minimal', function() {
    $config = config('services.django_api');
    
    $auth = \Illuminate\Support\Facades\Http::withOptions(['verify' => false])
        ->post($config['url'] . '/api/auth/login/', [
            'username' => $config['username'],
            'password' => $config['password']
        ]);
    
    if (!$auth->successful()) {
        return response()->json(['error' => 'Auth failed'], 401);
    }
    
    $token = $auth->json()['access'];
    
    $response = \Illuminate\Support\Facades\Http::withOptions(['verify' => false])
        ->withToken($token)
        ->get($config['url'] . '/api/public/products/');
    
    if ($response->successful()) {
        $products = $response->json();
        return response()->json([
            'success' => true,
            'count' => count($products),
            'data' => $products,
            'source' => 'direct_api_call'
        ]);
    }
    
    return response()->json(['error' => 'API failed'], $response->status());
});

// Redirect to main login for POS access
Route::get('/pos/login', function () {
    return redirect()->route('login')->with('info', 'Please login to access POS system');
})->name('pos.login');

require __DIR__.'/auth.php';