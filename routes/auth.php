<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\ClientRegisterController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Middleware\EnsureCustomerIsAuthenticated;
use App\Http\Controllers\Client\ClientProfileController;


Route::middleware('auth')->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::resource('admin/categories', CategoryController::class)
        ->names('categories');
    Route::resource('admin/brands', BrandController::class)
        ->names('brands');
    Route::resource('admin/products', ProductController::class)
        ->names('products');
    Route::resource('admin/employees', EmployeeController::class)
        ->names('employees');
    Route::post('admin/logout', [AuthenticateController::class, 'destroy'])->name('admin.logout');

});

Route::middleware(['guest'])->group(function () {
    Route::get('/admin/login', [AuthenticateController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AuthenticateController::class, 'store']);
    // Route::resource('admin/employees', EmployeeController::class)
    //     ->names('employees');
});

require __DIR__ . '/customer-auth.php';



