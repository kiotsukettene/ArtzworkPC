<?php

use App\Http\Controllers\CategoryController;
use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::inertia('/dashboard', 'Dashboard');
Route::inertia('/categories', 'CategoryView',
    ['categories' => Category::paginate(5)])
    ->name('categoryview.index');
Route::inertia('/categories/create', 'CategoryCreate');




Route::post('/categories/create', [CategoryController::class, 'create']);
Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');


