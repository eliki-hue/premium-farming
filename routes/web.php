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
| PUBLIC ROUTES (No Auth Required)
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

// E-commerce Shop (Public)
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/products', [ProductController::class, 'index'])->name('products');

// Category Views
Route::view('/category/poultry', 'categories.poultry')->name('category.poultry');
Route::view('/category/dairy', 'categories.dairy')->name('category.dairy');
Route::view('/category/swine', 'categories.swine')->name('category.swine');
Route::view('/category/pet-feeds', 'categories.pet-feeds')->name('category.pet-feeds');
Route::view('/category/by-products', 'categories.by-products')->name('category.by-products');
Route::view('/category/goat-feeds', 'categories.goat-feeds')->name('category.goat-feeds');
Route::view('/category/pig', 'categories.pig')->name('category.pig');
Route::view('/category/cattle', 'categories.cattle')->name('category.cattle');
Route::view('/category/concentrates', 'categories.concentrates')->name('category.concentrates');

// Shop Category
Route::get('/products/{category}', [ShopController::class, 'category'])
    ->whereIn('category', ['pig', 'pet', 'poultry', 'byproduct'])
    ->name('shop.category');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES (Require Auth)
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

    /*
    |--------------------------------------------------------------------------
    | CART & CHECKOUT ROUTES (For both POS and E-commerce)
    |--------------------------------------------------------------------------
    */
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'view'])->name('cart.view');
        Route::post('/add', [CartController::class, 'add'])->name('cart.add');
        Route::post('/update', [CartController::class, 'update'])->name('cart.update');
        Route::post('/increment', [CartController::class, 'increment'])->name('cart.increment');
        Route::post('/decrement', [CartController::class, 'decrement'])->name('cart.decrement');
        Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
        Route::post('/hold', [CartController::class, 'hold'])->name('cart.hold');
        Route::post('/complete', [CartController::class, 'complete'])->name('cart.complete');
        Route::post('/mpesa', [CartController::class, 'mpesa'])->name('cart.mpesa');
        Route::get('/info', [CartController::class, 'info'])->name('cart.info');
        Route::post('/quick-add', [CartController::class, 'quickAdd'])->name('cart.quick.add');
        Route::post('/add-multiple', [CartController::class, 'addMultiple'])->name('cart.add.multiple');
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
        // Checkout Routes
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
        Route::get('/checkout/receipt/{orderId}', [CheckoutController::class, 'receipt'])->name('checkout.receipt');
        Route::get('/orders', [CheckoutController::class, 'orders'])->name('checkout.orders');
        Route::get('/orders/{orderId}', [CheckoutController::class, 'viewOrder'])->name('checkout.order.view');
    });

    // Receipt
    Route::get('/receipt/{order_id}/print', [CartController::class, 'printReceipt'])->name('receipt.print');

    // Keep the POST version for forms without @method('DELETE')
    Route::post('/cart/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove.post');

    // Add DELETE version for forms with @method('DELETE')
    Route::delete('/cart/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    
    /*
    |--------------------------------------------------------------------------
    | SHOP ROUTES (E-commerce Backend)
    |--------------------------------------------------------------------------
    */
    Route::prefix('shop')->name('shop.')->group(function () {
        Route::get('/orders', [ShopController::class, 'orders'])->name('orders');
        Route::get('/products', [ShopController::class, 'products'])->name('products');
        Route::get('/product/{id}', [ShopController::class, 'show'])->name('show');
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
    | E-COMMERCE DASHBOARD (Regular User Dashboard)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        return view('dashboard'); // Regular user dashboard
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | SECURE POS ROUTES (With POS layout)
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
        
        // POS Products Management - Single route for both GET and POST
        Route::match(['GET', 'POST'], '/products', function (\Illuminate\Http\Request $request) {
            // Handle POST request (form submission)
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
                
                // If coming from sell page, redirect back to sell page
                if (str_contains(url()->previous(), '/pos/sell')) {
                    return redirect()->route('pos.sell')->with('success', 'Product added successfully!');
                }
                
                return redirect()->route('pos.products')->with('success', 'Product added successfully!');
            }
            
            // Handle GET request (view products)
            $products = \App\Models\PosProduct::orderBy('name')->get();
            return view('pos.products', compact('products'));
        })->name('products');
        
        // Placeholder routes for navigation
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
        
        // POS Cart Operations
        Route::prefix('cart')->name('cart.')->group(function () {
            Route::post('/add', [CartController::class, 'add'])->name('add');
            Route::post('/complete', [CartController::class, 'complete'])->name('complete');
            Route::post('/mpesa', [CartController::class, 'mpesa'])->name('mpesa');
            Route::post('/hold', [CartController::class, 'hold'])->name('hold');
            Route::post('/clear', [CartController::class, 'clear'])->name('clear');
        });
        
        // POS Receipt
        Route::get('/receipt/print/{order_id}', [CartController::class, 'printReceipt'])->name('receipt.print');
        
        // Additional POS Routes (from your old code)
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

    /*
    |--------------------------------------------------------------------------
    | PRODUCT MANAGEMENT ROUTES (Admin only - separate from POS)
    |--------------------------------------------------------------------------
    */
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | CATEGORY MANAGEMENT
    |--------------------------------------------------------------------------
    */
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/store', [CategoryController::class, 'create'])->name('categories.store');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');

    /*
    |--------------------------------------------------------------------------
    | ITEMS CRUD (POS Items)
    |--------------------------------------------------------------------------
    */
    Route::prefix('pos/items')->name('items.')->group(function () {
        Route::get('/', [ItemController::class, 'index'])->name('index');
        Route::post('/', [ItemController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ItemController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ItemController::class, 'update'])->name('update');
        Route::delete('/{id}', [ItemController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | STOCK MANAGEMENT
    |--------------------------------------------------------------------------
    */
    Route::post('/receive-stock', [StockController::class, 'receiveStock'])->name('receive.stock');
    Route::post('/sell', [StockController::class, 'sell'])->name('sell.product');

    /*
    |--------------------------------------------------------------------------
    | REPORTS
    |--------------------------------------------------------------------------
    */
    Route::prefix('reports')->group(function () {
        Route::get('/sales', [SalesReportController::class, 'index'])->name('reports.sales');
        Route::get('/sales/report', [SalesReportController::class, 'index'])->name('sales.report');
        Route::get('/sales/report/pdf', [SalesReportController::class, 'pdf'])->name('sales.pdf');
    });

    /*
    |--------------------------------------------------------------------------
    | DOCUMENT MANAGEMENT
    |--------------------------------------------------------------------------
    */
    Route::resource('invoices', InvoiceController::class);
    Route::resource('receipts', ReceiptController::class);
    Route::resource('credit-notes', CreditNoteController::class);
    Route::resource('petty-cash', PettyCashController::class);
    Route::resource('pos-returns', PosReturnController::class);
});

// Contact routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

// Reviews (Public - accessible without login)
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

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
Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])->name('register');
Route::post('/forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');

require __DIR__.'/auth.php';