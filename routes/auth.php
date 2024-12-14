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
use App\Http\Controllers\Client\ClientProfileController;


Route::middleware('auth')->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('admin/categories', CategoryController::class)->names('categories');
    Route::resource('admin/brands', BrandController::class)->names('brands');
    Route::resource('admin/products', ProductController::class)->names('products');
    Route::resource('admin/employees', EmployeeController::class)->names('employees');
    Route::post('admin/logout', [AuthenticateController::class, 'destroy'])->name('admin.logout');


});

Route::middleware(['auth:customer'])->group(function () {
    Route::post('/customer/logout', [ClientRegisterController::class, 'destroy'])->name('customer.logout');


    // ---Email Verification -- //
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware(['auth:customer', 'signed'])->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])->middleware(['throttle:6,1'])->name('verification.send');

    Route::middleware(['verified'])->group(function () {
        Route::get('/customer/register/process', [ClientRegisterController::class, 'show'])->name('customer.register.process');
        Route::post('/customer/register/process', [ClientRegisterController::class, 'update'])->name('customer.register.process.update');

        Route::get('/customer/profile', [ClientProfileController::class, 'index'])->name('customer.profile');
    });



});



