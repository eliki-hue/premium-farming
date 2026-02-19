<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartProxyController;

use App\Http\Controllers\{
    HomeController, ProfileController, ProductController, POSController, ShopController,
    StockController, TransactionController, ReportController, AccountController,
    SalesReportController, ItemController, InvoiceController, ReceiptController,
    CreditNoteController, PettyCashController, PosReturnController, ContactController,
    CategoryController, CartController, ConversionController, PosProductController,
    PosSellController, CustomerController, OrderController, CheckoutController, ReviewController
};
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (No Auth Required)
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->name('login'); 
Route::post('/login', [AuthenticatedSessionController::class, 'store']); // Handle login POST
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Home & About
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', fn() => view('about'))->name('about');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

// Reviews
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

Route::prefix('proxy/cart')->group(function () {
    Route::get('/', [CartProxyController::class, 'load']);
    Route::post('/add', [CartProxyController::class, 'add']);
    Route::patch('/update', [CartProxyController::class, 'update']);
    Route::delete('/remove', [CartProxyController::class, 'remove']);
});

Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
    // Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
Route::get('/cart/load', [CartController::class, 'load']);
Route::post('/cart/add', [CartController::class, 'add']);     // 👈 important
Route::patch('/cart/update', [CartController::class, 'update']);
Route::delete('/cart/remove', [CartController::class, 'remove']);
Route::post('/cart/checkout', [CartController::class, 'checkout']);

// Authentication (Django login)
// Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
// Route::post('/register', [RegisteredUserController::class, 'store']);

// Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
// Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Register & Forgot Password (Optional, if you handle via Django too)
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])->name('register');
Route::get('/forgot-password', fn() => view('auth.forgot-password'))->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');

// Shop & Products
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/products', [ShopController::class, 'products'])->name('shop.products');
Route::get('/shop/product/{id}', [ShopController::class, 'show'])->name('shop.show');

// Categories (public)
$categories = ['poultry','dairy','swine','pet-feeds','by-products','goat-feeds','pig','cattle','concentrates'];
foreach ($categories as $cat) {
    Route::view("/category/$cat", "categories.$cat")->name("category.$cat");
}
Route::get('/products/{category}', [ShopController::class, 'category'])
    ->whereIn('category', ['pig', 'pet', 'poultry', 'byproduct'])
    ->name('shop.category');

// Products & Categories
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

/*
|--------------------------------------------------------------------------
| CART ROUTES
|--------------------------------------------------------------------------
// */
// Route::prefix('cart')->group(function () {
//     Route::get('/', [CartController::class, 'view'])->name('cart.view');
//     Route::post('/add', [CartController::class, 'add'])->name('cart.add');
//     Route::post('/update', [CartController::class, 'update'])->name('cart.update');
//     Route::post('/increment', [CartController::class, 'increment'])->name('cart.increment');
//     Route::post('/decrement', [CartController::class, 'decrement'])->name('cart.decrement');
//     Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
//     Route::get('/load', [CartController::class, 'load']);
//     Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
//     Route::get('/count', [CartController::class, 'count'])->name('cart.count');
//     Route::get('/info', [CartController::class, 'info'])->name('cart.info');
//     Route::patch('/update/{id}', [CartController::class, 'update'])->name('cart.update');
//     Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
//     Route::post('/quick-add', [CartController::class, 'quickAdd'])->name('cart.quick.add');
//     Route::post('/add-multiple', [CartController::class, 'addMultiple'])->name('cart.add.multiple');
//     Route::get('/receipt/{orderId}/print', [CartController::class, 'printReceipt'])->name('receipt.print');
//     Route::post('/checkout', [CartController::class, 'checkout']);
// });

/*
|--------------------------------------------------------------------------
| CHECKOUT ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/calculate-delivery', [CheckoutController::class, 'calculateDelivery'])->name('checkout.calculate.delivery');
    Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place.order');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/receipt/{orderId}', [CheckoutController::class, 'receipt'])->name('checkout.receipt');
    Route::get('/track', [CheckoutController::class, 'trackOrder'])->name('checkout.track');
    Route::post('/track', [CheckoutController::class, 'trackOrder'])->name('checkout.track.post');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/my-profile', fn() => view('profile-page'))->name('my.profile');

    // Auth cart & checkout (logged-in users)
    // Route::prefix('cart')->group(function () {
    //     Route::post('/hold', [CartController::class, 'hold'])->name('cart.hold');
    //     Route::post('/complete', [CartController::class, 'complete'])->name('cart.complete');
    //     Route::post('/mpesa', [CartController::class, 'mpesa'])->name('cart.mpesa');
    //     Route::post('/apply-discount', [CartController::class, 'applyDiscount'])->name('cart.discount.apply');
    //     Route::post('/remove-discount', [CartController::class, 'removeDiscount'])->name('cart.discount.remove');
    //     Route::get('/my-cart', [CartController::class, 'getUserCart'])->name('cart.user');
    // });

    // Route::prefix('checkout')->group(function () {
    //     Route::get('/orders', [CheckoutController::class, 'orders'])->name('checkout.orders');
    //     Route::get('/orders/{orderId}', [CheckoutController::class, 'viewOrder'])->name('checkout.order.view');
    //     Route::get('/mpesa/{order}', [CheckoutController::class, 'showMpesaInstructions'])->name('checkout.mpesa');
    //     Route::get('/cheque/{order}', [CheckoutController::class, 'showChequeInstructions'])->name('checkout.cheque');
    //     Route::get('/bank-transfer/{order}', [CheckoutController::class, 'showBankTransferInstructions'])->name('checkout.bank-transfer');
    //     Route::post('/confirm-payment/{orderId}', [CheckoutController::class, 'confirmPayment'])->name('checkout.confirm.payment');
    //     Route::get('/generate-receipt/{orderId}', [CheckoutController::class, 'generateReceipt'])->name('checkout.generate.receipt');
    //     Route::get('/addresses', fn() => view('checkout.addresses'))->name('checkout.addresses');
    //     Route::post('/addresses', [CheckoutController::class, 'saveAddress'])->name('checkout.save.address');
    // });
});
