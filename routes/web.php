<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController as AdminOrderController;
use App\Http\Controllers\OrderItemController as CheckoutController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Customer\CategoryController as CustomerCategoryController;

// Rute untuk admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard admin
    Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');

    // Daftar produk
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Kategori
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Pesanan
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{id}', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
});

// Rute untuk customer
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('customer.cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('customer.cart.store');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('customer.cart.destroy');

    Route::get('/checkout', [CheckoutController::class, 'checkoutForm'])->name('customer.checkout.form');
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('customer.checkout.process');

});

// Produk dan kategori untuk customer
Route::get('/products', [CustomerProductController::class, 'index'])->name('customer.products.index');
Route::get('/products/{id}', [CustomerProductController::class, 'show'])->name('customer.products.show');
Route::get('/categories', [CustomerCategoryController::class, 'index'])->name('customer.categories.index');
Route::get('/categories/{id}', [CustomerCategoryController::class, 'show'])->name('customer.categories.show');

// Rute umum
Route::get('/', [CustomerProductController::class, 'index'])->name('customer.products.index');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profil pengguna
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes (login, register, dll.)
require __DIR__ . '/auth.php';
