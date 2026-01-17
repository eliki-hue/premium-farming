<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Route::get('/reviews', function () {
    return view('reviews');
})->name('reviews');

// Authentication (Public)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

// E-commerce Shop (Public - NO AUTH REQUIRED)
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/shop/products', [ShopController::class, 'products'])->name('shop.products'); // Added this public route
Route::get('/shop/product/{id}', [ShopController::class, 'show'])->name('shop.show'); // Make product details public

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

// Shop Category (Public)
Route::get('/products/{category}', [ShopController::class, 'category'])
    ->whereIn('category', ['pig', 'pet', 'poultry', 'byproduct'])
    ->name('shop.category');

// Categories (Public)
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

/*
|--------------------------------------------------------------------------
| PUBLIC PRODUCT & BROWSE ROUTES (No Auth Required)
|--------------------------------------------------------------------------
*/
// Public product view route (must be OUTSIDE auth middleware)
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Reviews (Public - accessible without login)
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

/*
|--------------------------------------------------------------------------
| GUEST CART ROUTES (No Auth Required)
|--------------------------------------------------------------------------
*/
Route::prefix('cart')->group(function () {
    // Cart viewing and operations (public)
    Route::get('/', [CartController::class, 'view'])->name('cart.view');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/increment', [CartController::class, 'increment'])->name('cart.increment');
    Route::post('/decrement', [CartController::class, 'decrement'])->name('cart.decrement');
    Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/count', [CartController::class, 'count'])->name('cart.count');
    Route::get('/info', [CartController::class, 'info'])->name('cart.info');
    Route::post('/quick-add', [CartController::class, 'quickAdd'])->name('cart.quick.add');
    Route::post('/add-multiple', [CartController::class, 'addMultiple'])->name('cart.add.multiple');
    
    // Keep the POST version for forms without @method('DELETE')
    Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove.post');
    Route::delete('/remove', [CartController::class, 'remove'])->name('cart.remove');
});

// Public receipt routes
Route::get('/receipt/{order_id}/print', [CartController::class, 'printReceipt'])->name('receipt.print');

/*
|--------------------------------------------------------------------------
| GUEST CHECKOUT ROUTES (No Auth Required)
|--------------------------------------------------------------------------
*/
Route::prefix('checkout')->group(function () {
    // Checkout pages (public)
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/calculate-delivery', [CheckoutController::class, 'calculateDelivery'])->name('checkout.calculate.delivery');
    Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place.order');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/receipt/{orderId}', [CheckoutController::class, 'receipt'])->name('checkout.receipt');
    Route::get('/track', [CheckoutController::class, 'trackOrder'])->name('checkout.track');
    Route::post('/track', [CheckoutController::class, 'trackOrder'])->name('checkout.track.post');
});
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
    
    echo "<h2>Testing Direct Connection to Django:</h2>";
    
    try {
        // Test 1: Direct authentication
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
            
            // Test 2: Direct API call
            echo "<h3>2. Testing Products API</h3>";
            $productsResponse = \Illuminate\Support\Facades\Http::withOptions(['verify' => false])
                ->withToken($token)
                ->get($config['url'] . '/api/products/');
            
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
            
            // Test 3: Test DjangoApiService
            echo "<h3>3. Testing DjangoApiService</h3>";
            $serviceProducts = \App\Services\DjangoApiService::getProducts();
            
            echo "Service returned: " . $serviceProducts->count() . " products<br>";
            
            if ($serviceProducts->count() > 0) {
                echo "<h4>Products from Service:</h4>";
                
                // Check if these are mock or real products
                $firstProduct = $serviceProducts->first();
                
                if (isset($firstProduct['unit_price'])) {
                    echo "✅ These are REAL products from Django!<br>";
                    echo "<pre>" . json_encode($serviceProducts->toArray(), JSON_PRETTY_PRINT) . "</pre>";
                } else {
                    echo "❌ These are MOCK products!<br>";
                    echo "First product keys: " . implode(', ', array_keys($firstProduct)) . "<br>";
                    echo "Mock products have: id, name, description, price, category, stock<br>";
                    echo "Real products have: id, name, sku, unit_price, unit_cost, is_active, etc.<br>";
                }
            }
            
        } else {
            echo "❌ Authentication failed: " . $authResponse->body() . "<br>";
        }
        
    } catch (\Exception $e) {
        echo "❌ Exception: " . $e->getMessage() . "<br>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
    
    // Check cache
    echo "<h2>Cache Status:</h2>";
    $cachedToken = \Illuminate\Support\Facades\Cache::get('django_api_token');
    echo "Cached Token: " . ($cachedToken ? substr($cachedToken, 0, 30) . '...' : 'NO TOKEN') . "<br>";
    
    return "<h3>Debug Complete</h3>";
});
Route::get('/test-minimal', function() {
    $config = config('services.django_api');
    
    // Direct API call - bypassing service
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
        ->get($config['url'] . '/api/products/');
    
    if ($response->successful()) {
        $products = $response->json();
        return response()->json([
            'success' => true,
            'count' => count($products),
            'data' => $products,
            'source' => 'direct_api_call',
            'note' => 'This is directly from Django, not through service'
        ]);
    }
    
    return response()->json(['error' => 'API failed'], $response->status());
});

Route::get('/api-diagnosis', function() {
    echo "<h1>API Connection Diagnosis</h1>";
    
    $config = config('services.django_api');
    $laravelUrl = config('app.url');
    
    echo "<h2>Current Configuration:</h2>";
    echo "<pre>";
    print_r([
        'Laravel App URL' => $laravelUrl,
        'Django API URL' => $config['url'],
        'Django Username' => $config['username'] ? 'SET' : 'NOT SET',
        'Using Mock' => env('DJANGO_API_USE_MOCK', false) ? 'YES' : 'NO'
    ]);
    echo "</pre>";
    
    echo "<h2>Testing Connection to Django API:</h2>";
    
    // Test 1: Direct connection to Django URL
    $djangoUrl = $config['url'];
    echo "<h3>1. Testing: $djangoUrl</h3>";
    
    try {
        $test = Http::withOptions(['verify' => false])
            ->timeout(5)
            ->get($djangoUrl);
        
        echo "Status: " . $test->status() . "<br>";
        echo "Response Headers: <pre>";
        print_r($test->headers());
        echo "</pre>";
        
        if (str_contains($test->body(), 'Django') || str_contains($test->body(), 'django')) {
            echo "<span style='color: green;'>✅ This looks like a Django server!</span><br>";
        } else {
            echo "<span style='color: orange;'>⚠️ This might not be Django</span><br>";
            echo "Response preview: " . substr($test->body(), 0, 500) . "...<br>";
        }
    } catch (\Exception $e) {
        echo "<span style='color: red;'>❌ Cannot connect: " . $e->getMessage() . "</span><br>";
    }
    
    echo "<h2>Common Django Ports Test:</h2>";
    $commonPorts = [8000, 8001, 8002, 8003, 8004, 8005, 8006, 8007, 8008, 8009, 8010];
    
    foreach ($commonPorts as $port) {
        $testUrl = "http://localhost:$port";
        echo "Testing $testUrl: ";
        
        try {
            $response = Http::withOptions(['verify' => false])
                ->timeout(2)
                ->get($testUrl);
            
            echo "Status: " . $response->status() . " - ";
            
            $body = $response->body();
            $isDjango = str_contains($body, 'Django') || 
                       str_contains($body, 'django') ||
                       str_contains($body, 'csrfmiddlewaretoken');
            
            if ($isDjango) {
                echo "<span style='color: green; font-weight: bold;'>DJANGO FOUND!</span>";
            } else {
                echo "Not Django";
            }
            
        } catch (\Exception $e) {
            echo "Connection failed";
        }
        
        echo "<br>";
    }
    
    return "<h3>Diagnosis Complete</h3>";
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES (Require Auth - Only for Logged-in Users)
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

    // Logout POST route
    Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | AUTH-ONLY CART FEATURES (Special features only for logged in users)
    |--------------------------------------------------------------------------
    */
    Route::prefix('cart')->group(function () {
        // Special cart features (authenticated only)
        Route::post('/hold', [CartController::class, 'hold'])->name('cart.hold');
        Route::post('/complete', [CartController::class, 'complete'])->name('cart.complete');
        Route::post('/mpesa', [CartController::class, 'mpesa'])->name('cart.mpesa');
        
        // Discounts (authenticated only)
        Route::post('/apply-discount', [CartController::class, 'applyDiscount'])->name('cart.discount.apply');
        Route::post('/remove-discount', [CartController::class, 'removeDiscount'])->name('cart.discount.remove');
        
        // User-specific cart (authenticated only)
        Route::get('/my-cart', [CartController::class, 'getUserCart'])->name('cart.user');
    });

    /*
    |--------------------------------------------------------------------------
    | AUTH-ONLY CHECKOUT FEATURES (Order history, saved addresses, etc.)
    |--------------------------------------------------------------------------
    */
    Route::prefix('checkout')->group(function () {
        // User order history (authenticated only)
        Route::get('/orders', [CheckoutController::class, 'orders'])->name('checkout.orders');
        Route::get('/orders/{orderId}', [CheckoutController::class, 'viewOrder'])->name('checkout.order.view');
        Route::get('/mpesa/{order}', [CheckoutController::class, 'showMpesaInstructions'])->name('checkout.mpesa');
    Route::get('/cheque/{order}', [CheckoutController::class, 'showChequeInstructions'])->name('checkout.cheque');
    Route::get('/bank-transfer/{order}', [CheckoutController::class, 'showBankTransferInstructions'])->name('checkout.bank-transfer');

    
Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place.order');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/receipt/{orderId}', [CheckoutController::class, 'receipt'])->name('checkout.receipt');
    Route::get('/print-receipt/{orderId}', [CheckoutController::class, 'printReceipt'])->name('checkout.print.receipt');
    Route::get('/download-receipt/{orderId}', [CheckoutController::class, 'downloadReceipt'])->name('checkout.download.receipt');
    Route::get('/track', [CheckoutController::class, 'trackOrder'])->name('checkout.track');
    Route::post('/track', [CheckoutController::class, 'trackOrder'])->name('checkout.track.post');
    Route::post('/confirm-payment/{orderId}', [CheckoutController::class, 'confirmPayment'])->name('checkout.confirm.payment');
    Route::get('/generate-receipt/{orderId}', [CheckoutController::class, 'generateReceipt'])->name('checkout.generate.receipt');
// Checkout routes
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/receipt/{orderId}', [CheckoutController::class, 'receipt'])->name('checkout.receipt');
        // Saved addresses and preferences (authenticated only)
        Route::get('/addresses', function () {
            return view('checkout.addresses');
        })->name('checkout.addresses');
        Route::post('/addresses', [CheckoutController::class, 'saveAddress'])->name('checkout.save.address');
    });

    /*
    |--------------------------------------------------------------------------
    | SHOP MANAGEMENT ROUTES (For logged in users only - Order History, etc.)
    |--------------------------------------------------------------------------
    */
    Route::prefix('shop')->name('shop.')->group(function () {
        Route::get('/orders', [ShopController::class, 'orders'])->name('orders');
        Route::get('/reports', function () {
            return view('shop.reports');
        })->name('reports');
        
        // Customer Management (authenticated only)
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
        
        // Orders (authenticated only)
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
        // Product routes
     // Use ProductController for products
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/shop/products', [ProductController::class, 'index'])->name('shop.products');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/category/{category}', [ProductController::class, 'byCategory'])->name('products.category');

    });

    /*
    |--------------------------------------------------------------------------
    | E-COMMERCE DASHBOARD (Regular User Dashboard)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        return view('dashboard'); // Regular user dashboard
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES (Admin only - separate from regular auth)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin'])->group(function () {
        // Admin delivery zones
        Route::prefix('admin')->group(function () {
            Route::resource('delivery-zones', DeliveryZoneController::class);
            Route::get('delivery-zones/{zone}/pricing', [DeliveryZoneController::class, 'pricing'])->name('delivery-zones.pricing');
            Route::post('delivery-zones/{zone}/pricing', [DeliveryZoneController::class, 'updatePricing'])->name('delivery-zones.update-pricing');
        });
        
        // PRODUCT MANAGEMENT ROUTES (Admin only - separate from POS)
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
    | SECURE POS ROUTES (With POS layout - Requires Login)
    |--------------------------------------------------------------------------
    */
    Route::prefix('pos')->name('pos.')->group(function () {
        // POS Dashboard
        Route::get('/dashboard', function () {
            return view('pos.dashboard');
        })->name('dashboard');
        
        // POS Sell Page (Main POS Interface)
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
        
        // Placeholder routes
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
            
        Route::post('/product/store', [PosController::class, 'storeProduct'])->name('pos.product.store');

        // Add to routes/web.php

Route::get('/test-direct-api', function() {
    $config = config('services.django_api');
    
    // First get token
    $authResponse = \Illuminate\Support\Facades\Http::withOptions(['verify' => false])
        ->post($config['url'] . '/api/auth/login/', [
            'username' => $config['username'],
            'password' => $config['password']
        ]);
    
    if (!$authResponse->successful()) {
        return response()->json([
            'error' => 'Auth failed',
            'status' => $authResponse->status(),
            'body' => $authResponse->body()
        ]);
    }
    
    $token = $authResponse->json()['access'];
    
    // Now try to get products
    $productsResponse = \Illuminate\Support\Facades\Http::withOptions(['verify' => false])
        ->withToken($token)
        ->get($config['url'] . '/api/products/');
    
    return response()->json([
        'auth_status' => $authResponse->status(),
        'products_status' => $productsResponse->status(),
        'products_data' => $productsResponse->json(),
        'products_headers' => $productsResponse->headers()
    ]);
});
Route::get('/products', [ProductController::class, 'index']);        
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
        Route::get('/held-sales', [CartController::class, 'heldSales'])->name('held.sales');
        Route::get('/receipt', function () {
            return view('pos.receipt');
        })->name('receipt');
    });
});

// Contact routes (public)
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

// Redirect to main login for POS access
Route::get('/pos/login', function () {
    return redirect()->route('login')->with('info', 'Please login to access POS system');
})->name('pos.login');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION HANDLERS (Keep at bottom)
|--------------------------------------------------------------------------
*/
Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])->name('login');
Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])->name('register');
Route::post('/forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');

require __DIR__.'/auth.php';