<?php

use Inertia\Inertia;
use App\Models\Brands;
use App\Models\Category;
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

});

// Protected Routes (requires login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('products', ProductController::class);
    Route::resource('employees', EmployeeController::class);

    Route::post('/logout', [AuthenticateController::class, 'destroy'])->name('logout');
});



require __DIR__ . '/auth.php';

