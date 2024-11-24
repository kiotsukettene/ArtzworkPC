<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

// Route::inertia('/dashboard', 'Dashboard');

Route::get('/dashboard',
    [ DashboardController::class,'index'])
    ->name('dashboard');


Route::resource('categories', CategoryController::class);

// Route::inertia('/categories', 'AdminSide/Categories/Index',
//     ['categories' => Category::paginate(5)])
//     ->name('category.index');

// Route::inertia('/categories/create', 'AdminSide/Categories/Create');






// Route::post('/categories/create', [CategoryController::class, 'create']);
// Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
// Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');


