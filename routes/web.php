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
use App\Http\Controllers\InController;
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


/*
|--------------------------------------------------------------------------
| HOME & DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
;


Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Essential auth routes
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])->name('login');
Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/register', function () { return view('auth.register'); })->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])->name('register');Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])->name('register');
Route::get('/forgot-password', function () { return view('auth.forgot-password'); })->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');


require __DIR__.'/auth.php';

Route::get('/dashboard', [POSController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/about', function () {
    return view('about');
})->name('about');


Route::get('/pos/products', function () {
    return view('products');
})->name('products');

Route::get('/pos/dashboard', function() {
    return view('pos.dashboard');
})->name('pos.dashboard');

// Route::get('/pos/stores', [PosController::class, 'stores'])->name('pos.stores');
// Route::get('/pos/sell', [PosController::class, 'sell'])->name('pos.sell');

// Add these lines:
Route::get('/pos/stores', [App\Http\Controllers\PosController::class, 'stores'])->name('pos.stores');
Route::get('/pos/sell', [App\Http\Controllers\PosController::class, 'sell'])->name('pos.sell');
Route::get('/pos/categories', [App\Http\Controllers\PosController::class, 'categories'])->name('pos.categories');
Route::get('/pos/items', [App\Http\Controllers\PosController::class, 'items'])->name('pos.items');
// routes/web.php
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/categories/store', function () {
    return view('categories.store');
})->name('categories.store');

Route::post('/categories/store', [CategoryController::class, 'store'])
    ->name('categories.store');


/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});

// PRODUCTS ROUTES
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::post('/products', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
Route::get('/products/create', [App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
Route::get('/products/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::get('/products/{product}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');


// Route::get('/products/index', [PosProductController::class, 'index'])->name('products.index');
// Route::get('/products/show', [PosProductController::class, 'show'])->name('products.create');
// Route::get('/products/create', [PosProductController::class, 'create'])->name('products.show');
// Route::post('/products/store', [PosProductController::class, 'store'])->name('products.store');
// Route::get('/pos/products', [PosProductController::class, 'index'])->name('products.index');
// Route::get('/products/create', [PosProductController::class, 'create'])->name('products.create');
// Route::post('/products', [PosProductController::class, 'store'])->name('products.store');

// ✅ FIXED: Now /sell works directly
Route::get('/sell', [PosSellController::class, 'index'])->name('sell.index');
Route::post('/products', [PosSellController::class, 'store'])->name('products.store');
Route::post('/cart/mpesa', [CartController::class, 'mpesa'])->name('cart.mpesa');
// POS Routes
Route::get('/sell', [CartController::class, 'sell'])->name('sell');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/complete', [CartController::class, 'complete'])->name('cart.complete');
Route::post('/cart/mpesa', [CartController::class, 'mpesa'])->name('cart.mpesa');
Route::post('/cart/hold', [CartController::class, 'hold'])->name('cart.hold');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// ✅ SAFE RECEIPT ROUTE
Route::get('/receipt/{order_id}/print', [CartController::class, 'printReceipt'])->name('receipt.print');

/*
|--------------------------------------------------------------------------
| POS ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('pos')->name('pos.')->group(function () {

    Route::get('/pos.dashboard', function () {
        return view('pos.dashboard');
    })->name('pos');
    
    Route::get('/sell', [POSController::class, 'sell'])->name('sell');
    Route::post('/sell', [POSController::class, 'storeSale'])->name('sell.store');

    Route::get('/categories', [StockController::class, 'categories'])->name('categories');

    Route::get('/items', [ItemController::class, 'index'])->name('items');
    Route::post('/items/store', [ItemController::class, 'store'])->name('items.store');

    Route::get('/stores', [StockController::class, 'stores'])->name('stores');
    Route::get('/update-prices', [StockController::class, 'updatePrices'])->name('update-prices');

    Route::get('/goods-received', [TransactionController::class, 'goodsReceived'])->name('goods-received');
    Route::post('/goods-received/store', [TransactionController::class, 'storeGoodsReceived'])->name('goods-received.store');

    Route::get('/transfers', [TransactionController::class, 'transfers'])->name('transfers');
    Route::post('/transfers/store', [TransactionController::class, 'storeTransfer'])->name('transfers.store');

    Route::get('/stock-take', [TransactionController::class, 'stockTake'])->name('stock-take');
    Route::post('/stock-take/store', [TransactionController::class, 'storeStockTake'])->name('stock-take.store');

    Route::get('/reports/best-seller', [ReportController::class, 'bestSeller'])->name('reports.best-seller');
    Route::get('/reports/goods-received', [ReportController::class, 'goodsReceivedReport'])->name('reports.goods-received');
    Route::get('/reports/stock-level', [ReportController::class, 'stockLevel'])->name('reports.stock-level');

    Route::get('/clients', [AccountController::class, 'clients'])->name('clients');
    Route::get('/client-terms', [AccountController::class, 'clientTerms'])->name('client-terms');

    Route::get('/invoices', [AccountController::class, 'invoices'])->name('invoices');
    Route::get('/receipts', [AccountController::class, 'receipts'])->name('receipts');
    Route::get('/credit-notes', [AccountController::class, 'creditNotes'])->name('credit-notes');
    Route::get('/petty-cash', [AccountController::class, 'pettyCash'])->name('petty-cash');

});
Route::get('/products', [ShopController::class, 'Products'])->name('shop.products');


Route::get('/products/{category}', [ShopController::class, 'category'])
    ->whereIn('category', ['pig', 'pet', 'poultry', 'byproduct'])
    ->name('shop.category');

Route::get('/pos/held-sales', [CartController::class, 'heldSales'])
    ->name('pos.held.sales');

Route::post('/cart/hold', [CartController::class, 'hold'])->name('cart.hold');
Route::post('/cart/resume/{index}', [CartController::class, 'resume'])->name('cart.resume');
Route::post('/cart/discount', [CartController::class, 'discount'])->name('cart.discount');
Route::post('/cart/complete', [CartController::class, 'complete'])->name('cart.complete');
Route::get('/pos/receipt', fn() => view('pos.receipt'))->name('pos.receipt');

/*
|--------------------------------------------------------------------------
| POS Items CRUD
|--------------------------------------------------------------------------
*/

Route::get('/pos/items', [ItemController::class, 'index'])->name('items.index');
Route::post('/pos/items', [ItemController::class, 'store'])->name('items.store');
Route::get('/pos/items/{id}/edit', [ItemController::class, 'edit'])->name('items.edit');
Route::put('/pos/items/{id}', [ItemController::class, 'update'])->name('items.update');
Route::delete('/pos/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');

Route::prefix('shop')->group(function () {
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

});

Route::get('/pos/conversion', function () {
    return view('pos.conversion');
})->name('pos.conversion');
Route::prefix('pos')->group(function () {

    // Conversion page (form)
    Route::get('conversion', [ConversionController::class, 'index'])->name('pos.conversion');

    // Store conversion (POST)
    Route::post('conversion', [ConversionController::class, 'store'])->name('pos.convert.store');

});
/*
|--------------------------------------------------------------------------
| CATEGORY BLADE ROUTES (NEW)
|--------------------------------------------------------------------------
*/

Route::view('/category/poultry', 'categories.poultry')->name('category.poultry');
Route::view('/category/dairy', 'categories.dairy')->name('category.dairy');
Route::view('/category/swine', 'categories.swine')->name('category.swine');
Route::view('/category/pet-feeds', 'categories.pet-feeds')->name('category.pet-feeds');
Route::view('/category/by-products', 'categories.by-products')->name('category.by-products');
Route::view('/category/goat-feeds', 'categories.goat-feeds')->name('category.goat-feeds');

Route::get('/shop/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/shop/orders/store', [OrderController::class, 'store'])->name('orders.store');


/*
|--------------------------------------------------------------------------
| SHOP ROUTES (Front-End Online Shop)
|--------------------------------------------------------------------------
*/

Route::prefix('shop')->name('shop.')->group(function () {

    Route::get('/', [ShopController::class, 'index'])->name('index');

    Route::get('/products', [ShopController::class, 'products'])->name('products');
    Route::get('/orders', [ShopController::class, 'orders'])->name('orders');
    // Route::get('/customers', [ShopController::class, 'customers'])->name('customers');

    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('shop.category');

    Route::view('/reports', 'shop.reports')->name('reports');

    Route::get('/product/{id}', [ShopController::class, 'show'])->name('show');
});



Route::view('/category/poultry', 'categories.poultry')->name('category.poultry');
Route::view('/category/pig', 'categories.pig')->name('category.pig');
Route::view('/category/cattle', 'categories.cattle')->name('category.cattle');
Route::view('/category/concentrates', 'categories.concentrates')->name('category.concentrates');

/*
|--------------------------------------------------------------------------
| CART ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::post('/cart/increment', [App\Http\Controllers\CartController::class, 'increment'])->name('cart.increment');
Route::post('/cart/decrement', [App\Http\Controllers\CartController::class, 'decrement'])->name('cart.decrement');
Route::post('/cart/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');

Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');


/*
|--------------------------------------------------------------------------
| OTHER ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/receive-stock', [StockController::class, 'receiveStock'])->name('receive.stock');
Route::post('/receive-stock', [StockController::class, 'receiveStock']);

Route::post('/sell', [StockController::class, 'sell'])->name('sell.product');

Route::get('/sales/report', [SalesReportController::class, 'index'])->name('sales.report');
Route::get('/sales/report/pdf', [SalesReportController::class, 'pdf'])->name('sales.pdf');

Route::get('/reports/sales', [SalesReportController::class, 'index'])->name('reports.sales');

Route::get('/my-profile', function () {
    return view('profile-page');
})->name('my.profile');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::resource('invoices', InvoiceController::class);
Route::resource('receipts', ReceiptController::class);
Route::resource('credit-notes', CreditNoteController::class);
Route::resource('petty-cash', PettyCashController::class);
Route::resource('pos-returns', PosReturnController::class);

require __DIR__.'/auth.php';
