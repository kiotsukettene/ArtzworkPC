<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\ClientRegisterController;
use App\Http\Controllers\Client\ProductListController;
use App\Http\Controllers\Client\ProductViewController;
use App\Http\Controllers\Client\CategoryProductsController;
use App\Http\Controllers\Client\CartController;

// Route::inertia('/dashboard', 'Dashboard');

// Public Routes (accessible without login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticateController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticateController::class, 'store']);
    Route::get('/register', [ClientRegisterController::class, 'create'])->name('register');
    Route::post('/register', [ClientRegisterController::class, 'store']);
    Route::get('/forgot-password', function () {
        return Inertia::render('Auth/ForgotPassword');
    })->name('password.request');
    Route::get('/', [HomeController::class, 'index'])->name('home'); // Guest Home
    Route::get('/product-list', [ProductListController::class, 'index'])->name('product.list');
    Route::get('/category-products/{categorySlug?}', [CategoryProductsController::class, 'index'])->name('category.products');
    Route::get('/product-list/{slug}', [ProductViewController::class, 'index'])->name('product.view');
    Route::inertia('/pc-builder', 'ClientSide/PCBuilder');
    Route::inertia('/component-selection', 'ClientSide/ComponentSelection');
});

// Protected Routes (requires login)
Route::middleware('auth')->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('admin/categories', CategoryController::class)->names('categories');
    Route::resource('admin/brands', BrandController::class)->names('brands');
    Route::resource('admin/products', ProductController::class)->names('products');
    Route::resource('admin/employees', EmployeeController::class)->names('employees');

    Route::post('/logout', [AuthenticateController::class, 'destroy'])->name('logout');
});

Route::middleware(['web'])->group(function () {
    Route::controller(CartController::class)->group(function () {
        Route::get('/cart', 'index')->name('cart.index');
        Route::post('/cart/add', 'addToCart')->name('cart.add');
        Route::post('/cart/update-quantity', 'updateQuantity')->name('cart.updateQuantity');
        Route::post('/cart/remove', 'removeFromCart')->name('cart.remove');
        Route::post('/cart/update-selection', 'updateSelection')->name('cart.updateSelection');
        Route::post('/cart/clear', 'clearCart')->name('cart.clear');
        Route::post('/cart/update-all-selections', 'updateAllSelections')
            ->name('cart.updateAllSelections');
    });
});

require __DIR__ . '/auth.php';

