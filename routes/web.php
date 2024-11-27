<?php

use Inertia\Inertia;
use App\Models\Brands;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

// Route::inertia('/dashboard', 'Dashboard');

Route::get('/dashboard',
    [ DashboardController::class,'index'])
    ->name('dashboard');
Route::inertia('/home', 'ClientSide/Home');

Route::resource(
    'categories', CategoryController::class,
);

Route::resource(
    'brands', BrandController::class,
);

Route::resource(
    'products', ProductController::class,
);

// Route::inertia('/products/create', 'AdminSide/Products/Create');

// Route::inertia('/categories', 'AdminSide/Categories/Index',
//     ['categories' => Category::paginate(5)])
//     ->name('category.index');

// Route::inertia('/categories/create', 'AdminSide/Categories/Create');






// Route::post('/categories/create', [CategoryController::class, 'create']);
// Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
// Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');


