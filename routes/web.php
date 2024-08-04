<?php

use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\user\HomeController;
use App\Http\Controllers\user\ProductControllerLanding;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;

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