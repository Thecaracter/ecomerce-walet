<?php

use App\Http\Controllers\RiwayatController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth-login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('auth-register');


Route::middleware(['check.is.logged.in'])->group(function () {
    //Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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