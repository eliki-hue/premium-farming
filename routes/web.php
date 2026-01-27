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
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/
Route::get('/about', fn () => view('about'))->name('about');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

/*
|--------------------------------------------------------------------------
| AUTH (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthenticatedSessionController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'login'])->name('auth.login');

Route::get('/register', fn () => view('auth.register'))->name('register');
Route::post('/register', [AuthenticatedSessionController::class, 'register'])->name('auth.register');

Route::get('/forgot-password', fn () => view('auth.forgot-password'))->name('password.request');

/*
|--------------------------------------------------------------------------
| SHOP & PRODUCTS (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/shop/product/{id}', [ShopController::class, 'show'])->name('shop.show');

/*
|--------------------------------------------------------------------------
| CATEGORIES (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::view('/category/poultry', 'categories.poultry')->name('category.poultry');
Route::view('/category/dairy', 'categories.dairy')->name('category.dairy');
Route::view('/category/swine', 'categories.swine')->name('category.swine');
Route::view('/category/pet-feeds', 'categories.pet-feeds')->name('category.pet-feeds');
Route::view('/category/by-products', 'categories.by-products')->name('category.by-products');
Route::view('/category/goat-feeds', 'categories.goat-feeds')->name('category.goat-feeds');

/*
|--------------------------------------------------------------------------
| CART (COOKIE AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware('auth.cookie')->prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'view'])->name('view');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{itemId}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{itemId}', [CartController::class, 'remove'])->name('remove');
});

/*
|--------------------------------------------------------------------------
| CHECKOUT (COOKIE AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware('auth.cookie')->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('place.order');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USERS
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
| DEBUG ROUTES (REMOVE IN PRODUCTION)
|--------------------------------------------------------------------------
*/
Route::get('/debug-django-real', function() {
    return "Debug route active";
});

require __DIR__.'/auth.php';
