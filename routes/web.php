<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\ClientRegisterController;
use App\Http\Controllers\Client\PCBuilderController;
use App\Http\Controllers\Client\ProductListController;
use App\Http\Controllers\Client\ProductViewController;
use App\Http\Controllers\Client\CategoryProductsController;
use App\Http\Controllers\Client\ComponentSelectionController;

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
    Route::get('/pc-builder', [PCBuilderController::class, 'index'])->name('pc.builder');
    Route::get('/pc-builder/component-selection/{componentType}', [ComponentSelectionController::class, 'index'])
    ->name('component.selection');
    Route::inertia('/customer/register', 'ClientSide/Customer/RegisterProcess');
});

// Protected Routes (requires login)


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
        Route::post('/cart/add-multiple', 'addMultiple')->name('cart.add-multiple');
    });
});

require __DIR__ . '/auth.php';

