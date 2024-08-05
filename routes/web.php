<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OngkirController;
use App\Http\Controllers\PaymenController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\user\HomeController;
use App\Http\Controllers\user\ProductControllerLanding;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth-login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('auth-register');



// landing page
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/user/product', [ProductControllerLanding::class, 'index'])->name('user.product');
Route::get('/products/search', [ProductControllerLanding::class, 'search'])->name('products.search');

// Cart routes
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');


//check ongkir
Route::get('/ongkir', [OngkirController::class, 'index'])->name('ongkir');
Route::get('/provinces', [OngkirController::class, 'province'])->name('provinces');
Route::get('/cities', [OngkirController::class, 'city'])->name('cities');
Route::post('/check-ongkir', [OngkirController::class, 'checkOngkir'])->name('check-ongkir');

//checkout
Route::post('/checkout', [CheckoutController::class, 'storeOrder'])->name('storeOrder');

//payment
Route::get('/payment', [PaymenController::class, 'index'])->name('payment.index');
Route::post('/order/update-status-proses', [PaymenController::class, 'updateStatusToProses'])->name('order.updateStatusProses');
Route::post('/payment/callback', [PaymenController::class, 'paymentCallback']);

// Terapkan middleware 'check.is.logged.in' untuk memastikan pengguna terautentikasi
Route::middleware(['check.is.logged.in'])->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/top-selling-products', [DashboardController::class, 'topSellingProducts']);

    // Product routes
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::post('/product/create', [ProductController::class, 'store'])->name('product.store');
    Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

    // Order routes
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::post('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');

    // Riwayat routes
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

});