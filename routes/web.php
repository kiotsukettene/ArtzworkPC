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
use App\Http\Controllers\ClientLoginController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\ClientRegisterController;
use App\Http\Controllers\Client\PCBuilderController;
use App\Http\Controllers\Client\ProductListController;
use App\Http\Controllers\Client\ProductViewController;
use App\Http\Controllers\Client\CategoryProductsController;
use App\Http\Controllers\Client\ComponentSelectionController;
use App\Http\Controllers\EmailVerificationController;




// Public Routes (accessible without login)
Route::middleware('guest')->group(function () {

    // --------ADMIN LOGIN-------- //
    Route::get('/admin/login', [AuthenticateController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AuthenticateController::class, 'store']);

    // --------CUSTOMER LOGIN-------- //
    Route::get('/customer/login', [ClientLoginController::class, 'create'])->name('customer.login');
    Route::post('/customer/login', [ClientLoginController::class, 'store']);

    // --------FORGOT PASSWORD-------- //
    // Route::get('/customer/forgot-password', [AuthenticateController::class, 'create'])->name('customer.forgot-password');
    // Route::post('/customer/forgot-password', [AuthenticateController::class, 'store']);

    // --------FORGOT PASSWORD-------- //
    Route::get('/forgot-password', function () {
        return Inertia::render('Auth/ForgotPassword');
    })->name('password.request');

    // --------REGISTER--------//
    Route::get('/customer/register', [ClientRegisterController::class, 'create'])->name('customer.register');
    Route::post('/customer/register', [ClientRegisterController::class, 'store']);



    Route::get('/', [HomeController::class, 'index'])->name('home'); // Guest Home
    Route::get('/product-list', [ProductListController::class, 'index'])->name('product.list');
    Route::get('/category-products/{categorySlug?}', [CategoryProductsController::class, 'index'])->name('category.products');
    Route::get('/product-list/{slug}', [ProductViewController::class, 'index'])->name('product.view');
    Route::get('/pc-builder', [PCBuilderController::class, 'index'])->name('pc.builder');
    Route::get('/pc-builder/component-selection/{componentType}', [ComponentSelectionController::class, 'index'])
    ->name('component.selection');

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
        Route::post('/cart/add-multiple', 'addMultiple')->name('cart.add-multiple');
    });
});


require __DIR__ . '/auth.php';

