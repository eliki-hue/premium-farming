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
| LANDING PAGE (HOME FIRST)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home.page');

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/about', fn () => view('about'))->name('about');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

/*
|--------------------------------------------------------------------------
| AUTH PAGES
|--------------------------------------------------------------------------
*/
Route::get('/login', fn () => view('auth.login'))->name('login');
Route::get('/register', fn () => view('auth.register'))->name('register');
Route::get('/forgot-password', fn () => view('auth.forgot-password'))->name('password.request');

/*
|--------------------------------------------------------------------------
| PRODUCTS & SHOP (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/product/{id}', [ShopController::class, 'show'])->name('shop.show');

/*
|--------------------------------------------------------------------------
| CATEGORIES
|--------------------------------------------------------------------------
*/
Route::prefix('categories')->name('categories.')->group(function () {
    Route::view('/poultry', 'categories.poultry')->name('poultry');
    Route::view('/dairy', 'categories.dairy')->name('dairy');
    Route::view('/swine', 'categories.swine')->name('swine');
    Route::view('/pet-feeds', 'categories.pet-feeds')->name('pet-feeds');
    Route::view('/by-products', 'categories.by-products')->name('by-products');
    Route::view('/goat-feeds', 'categories.goat-feeds')->name('goat-feeds');
});

// Route::view('/categorie/cattle', 'categories.cattle');
// Route::view('/category/concentrates', 'categories.concentrates');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
// 
/*
|--------------------------------------------------------------------------
| CART (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
});

/*
|--------------------------------------------------------------------------
| CHECKOUT (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place.order');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

});

/*
|--------------------------------------------------------------------------
| AUTH HANDLERS
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthenticatedSessionController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthenticatedSessionController::class, 'logout'])->name('auth.logout');

require __DIR__.'/auth.php';
