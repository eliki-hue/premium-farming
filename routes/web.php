<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartProxyController;

use App\Http\Controllers\{
    HomeController, ProfileController, ProductController, POSController, ShopController,
    StockController, TransactionController, ReportController, AccountController,
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
// Show proxy signup form
Route::get('/proxy/signup', fn () => view('auth.proxy-signup'))->name('proxy.signup.form');

// Handle proxy signup POST
Route::post('/proxy/signup', [RegisteredUserController::class, 'proxySignup'])->name('proxy.signup');

Route::get('/forgot-password', fn() => view('auth.forgot-password'))->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

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


/*
|--------------------------------------------------------------------------
| DJANGO CART PROXY (AUTH REQUIRED)
|--------------------------------------------------------------------------
*/
Route::prefix('proxy/cart')->group(function () {
    Route::get('/', [CartProxyController::class, 'load']);
    Route::post('/add', [CartProxyController::class, 'add']);
    Route::patch('/update', [CartProxyController::class, 'update']); // PATCH (matches Django)
    Route::delete('/remove', [CartProxyController::class, 'remove']);
});


/*
|--------------------------------------------------------------------------
| CART (LARAVEL SIDE)
|--------------------------------------------------------------------------
*/
Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
Route::get('/cart/load', [CartController::class, 'load']);
Route::post('/cart/add', [CartController::class, 'add']);
Route::patch('/cart/update', [CartController::class, 'update']);
Route::delete('/cart/remove', [CartController::class, 'remove']);
Route::post('/cart/checkout', [CartController::class, 'checkout']);


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

/* Categories CRUD */
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');


/*
|--------------------------------------------------------------------------
| CHECKOUT
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

    /* PROFILE */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/my-profile', fn() => view('profile-page'))->name('my.profile');

});