<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        // LOGIN
        Route::get('masuk', 'index');
        Route::post('masuk', 'login')->name('login');
    });
});

Route::middleware('auth')->group(function () {
    // DASHBOARD
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::controller(CategoryController::class)->group(function () {
        // CATEGORY
        Route::get('category', 'categoryIndex')->name('category.index');
        Route::prefix('category')->group(function () {
            Route::get('create', 'createCategoryPage')->name('category.create');
            Route::post('create', 'createCategory');
            Route::get('{category}/edit', 'editCategoryPage')->name('category.edit');
            Route::put('{category}/update', 'updateCategory')->name('category.update');
            Route::delete('{category}', 'deleteCategory')->name('category.delete');
        });

        // SUB CATEGORY
        Route::get('sub-category', 'subCategoryIndex')->name('sub.category.index');
    });

    // USER
    Route::resource('user', UserController::class);
});
