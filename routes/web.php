<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        // LOGIN
        Route::get('login', 'index');
        Route::post('login', 'login')->name('login');
    });
});

Route::middleware('auth')->group(function () {
    Route::middleware(AdminMiddleware::class)->group(function () {
        // REGION
        Route::resource('region', RegionController::class)->except('show');

        // USER
        Route::resource('user', UserController::class)->except('show');

        // SUPPLIER
        Route::resource('supplier', SupplierController::class)
            ->except('show');

        // SALE
        Route::resource('sale', SaleController::class)
            ->except(['create', 'store']);

        // STOCK
        Route::resource('stock', StockController::class)->except('show');
        Route::delete('stock/reset/{stock}', [StockController::class, 'reset'])
            ->name('stock.reset');

        // CATEGORY & SUB CATEGORY
        Route::controller(CategoryController::class)->group(function () {
            // CATEGORY
            Route::get('category', 'itemCategory')->name('category.index');
            Route::prefix('category')->group(function () {
                Route::get('create', 'createCategoryItem')
                    ->name('category.create');
                Route::post('create', 'storeCategoryItem');
                Route::get('{category}/edit', 'editCategoryItem')
                    ->name('category.edit');
                Route::put('{category}/update', 'UpdateCategoryItem')
                    ->name('category.update');
            });

            // SUB CATEGORY
            Route::get('customer-category', 'customerCategory')->name('customer-category.index');
            Route::prefix('customer-category')->group(function () {
                Route::get('create', 'createCategoryCustomer')
                    ->name('customer-category.create');
                Route::post('create', 'storeCategoryCustomer');
                Route::get('{category}/edit', 'editCategoryCustomer')
                    ->name('customer-category.edit');
                Route::put('{category}/update', 'updateCategoryCustomer')
                    ->name('customer-category.update');
            });

            // DESTROY CATEGORY & SUBCATEGORY
            Route::delete('category/{category}', 'deleteCategory')
                ->name('category.delete');
        });

        // REPORT
        Route::controller(ReportController::class)->group(function () {
            Route::get('report', 'index')->name('report');
            Route::prefix('report')->group(function () {
                Route::post('sales', 'sales')->name('report.sales');
                Route::post('purchase', 'purchase')->name('report.purchase');
            });
        });

        // CUSTOMER
        Route::resource('customer', CustomerController::class);
        Route::prefix('customer')->controller(CustomerController::class)
            ->group(function () {
                Route::post('pay', 'pay')->name('customer.pay');
            });

        // PURCHASE
        Route::resource('purchase', PurchaseController::class)
            ->except(['edit', 'update']);
        Route::prefix('purchase')->controller(PurchaseController::class)
            ->group(function () {
                Route::post('get-item', 'getItem')->name('purchase.get.item');
            });
    });

    // DASHBOARD
    Route::get('/', DashboardController::class)->name('dashboard');

    // LOGOUT
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // CASHIER
    Route::controller(CashierController::class)->group(function () {
        Route::get('cashier', 'index')->name('cashier');
        Route::prefix('cashier')->group(function () {
            Route::post('get-item', 'getItem')->name('cashier.get-item');
            Route::post('get-credit', 'getCredit')->name('cashier.get-credit');
            Route::post('checkout', 'checkout')->name('cashier.checkout');
        });
    });
});
