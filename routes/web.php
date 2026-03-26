<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartProxyController;
use App\Http\Controllers\CheckoutProxyController;
use App\Http\Controllers\WhatsAppRedirectController;
use App\Http\Controllers\CheckoutResumeController;
use App\Http\Controllers\WhatsAppOrderController;
use App\Http\Controllers\PaymentController;


// Fixed duplicate import - removed the duplicate WhatsAppRedirectController

use App\Http\Controllers\{
    HomeController, ProfileController, ProductController, ShopController, TransactionController, ReportController, AccountController,
    SalesReportController, ItemController, InvoiceController, ReceiptController,
    CreditNoteController, PettyCashController, PosReturnController, ContactController,
    CategoryController, CartController, ConversionController, PosProductController,
    PosSellController, CustomerController, OrderController, CheckoutController,
    ReviewController, 
};

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

/* ===== AUTH ===== */
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/register', fn () => view('auth.register'))->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/proxy/signup', fn () => view('auth.proxy-signup'))->name('proxy.signup.form');
Route::post('/proxy/signup', [RegisteredUserController::class, 'proxySignup'])->name('proxy.signup');

Route::get('/forgot-password', fn() => view('auth.forgot-password'))->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
// Route::get('/payment/{orderId}', [PaymentController::class, 'showPaymentPage'])->name('payment.page');
Route::get('/payment/{orderId}', [PaymentController::class, 'showPaymentPage'])->name('payment.page');
Route::get('/api/payment/status/{orderId}', [PaymentController::class, 'checkPaymentStatus'])->name('payment.status');
/* ===== HOME ===== */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', fn() => view('about'))->name('about');

/* ===== CONTACT ===== */
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/gallery', fn () => view('gallery'))->name('gallery');

/* ===== REVIEWS ===== */
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// WhatsApp Routes
Route::middleware(['web', 'auth'])->group(function () {
    // WhatsApp redirect routes
    Route::post('/whatsapp/redirect', [WhatsAppRedirectController::class, 'redirectToWhatsApp'])
        ->name('whatsapp.redirect');
    
    Route::post('/api/whatsapp/redirect', [WhatsAppRedirectController::class, 'apiRedirect'])
        ->name('api.whatsapp.redirect');
    
    // Checkout resume routes
    Route::get('/checkout/resume/{orderId}', [CheckoutResumeController::class, 'resumeCheckout'])
        ->name('checkout.resume');
    
    Route::post('/api/checkout/complete', [CheckoutResumeController::class, 'completeCheckout'])
        ->name('api.checkout.complete');
    
    // Webhook for Django (no auth required)
    Route::post('/api/webhook/update-delivery', [CheckoutResumeController::class, 'webhookUpdateDelivery'])
        ->name('api.webhook.update-delivery');
});

// WhatsApp Order Routes (public routes)
Route::post('/api/whatsapp/prepare-order', [WhatsAppOrderController::class, 'prepareWhatsAppOrder']);
// Fixed duplicate route - removed the duplicate checkout.resume route
Route::post('/api/checkout/complete-whatsapp', [WhatsAppOrderController::class, 'completeCheckout']);

/*
|--------------------------------------------------------------------------
| DJANGO CART PROXY
| Uses session('django_token') — NOT Laravel auth middleware
|--------------------------------------------------------------------------
*/
Route::prefix('proxy/cart')->group(function () {
    Route::get('/',       [CartProxyController::class, 'load']);
    Route::post('/add',   [CartProxyController::class, 'add']);
    Route::patch('/update', [CartProxyController::class, 'update']);
    Route::delete('/remove', [CartProxyController::class, 'remove']);
});

/*
|--------------------------------------------------------------------------
| DJANGO CHECKOUT PROXY
|--------------------------------------------------------------------------
*/
Route::prefix('proxy/checkout')->group(function () {
    // Trigger M-Pesa STK Push → returns checkout_request_id
    Route::post('/mpesa', [CheckoutProxyController::class, 'mpesa'])
        ->name('proxy.checkout.mpesa');

    // Poll payment status using checkout_request_id from Safaricom
    Route::get('/status/{checkoutRequestId}', [CheckoutProxyController::class, 'paymentStatus'])
        ->name('proxy.checkout.status');
});

/*
|--------------------------------------------------------------------------
| DJANGO ORDERS PROXY
| ⚠️  NO middleware('auth') — auth is handled via session('django_token')
|--------------------------------------------------------------------------
*/
Route::prefix('proxy/orders')->group(function () {
    // Fetch all orders for logged-in user
    Route::get('/', [CheckoutProxyController::class, 'orders'])
        ->name('proxy.orders');

    // Fetch single order with items breakdown
    Route::get('/{orderNumber}', [CheckoutProxyController::class, 'orderDetail'])
        ->name('proxy.orders.detail');
});

/*
|--------------------------------------------------------------------------
| ORDERS PAGE (view only — data loaded via JS from proxy above)
| ⚠️  NO middleware('auth') — session check is done in the blade itself
|--------------------------------------------------------------------------
*/
Route::get('/orders', fn() => view('shop.orders'))->name('orders');


/*
|--------------------------------------------------------------------------
| CART PAGE
|--------------------------------------------------------------------------
*/
Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
Route::get('/cart/load', [CartController::class, 'load']);
Route::post('/cart/add', [CartController::class, 'add']);
Route::patch('/cart/update', [CartController::class, 'update']);
Route::delete('/cart/remove', [CartController::class, 'remove']);

/*
|--------------------------------------------------------------------------
| SHOP & PRODUCTS
|--------------------------------------------------------------------------
*/
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/products', [ShopController::class, 'products'])->name('shop.products');
Route::get('/shop/product/{id}', [ShopController::class, 'show'])->name('shop.show');

/* Categories */
$categories = ['poultry','dairy','swine','pet-feeds','by-products','goat-feeds','pig','cattle','concentrates'];
foreach ($categories as $cat) {
    Route::view("/category/$cat", "categories.$cat")->name("category.$cat");
}

Route::get('/products/{category}', [ShopController::class, 'category'])
    ->whereIn('category', ['pig', 'pet', 'poultry', 'byproduct'])
    ->name('shop.category');

/* Products */
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

/* Categories */
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

/*
|--------------------------------------------------------------------------
| CHECKOUT (Laravel-side, for non-Django orders)
|--------------------------------------------------------------------------
*/
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

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
| AUTHENTICATED ROUTES (Laravel auth — for admin/staff only)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/my-profile', fn() => view('profile-page'))->name('my.profile');
});