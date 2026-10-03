<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerAddressController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\MarketingController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderStatusController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\TagController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/analytics/overview', [AnalyticsController::class, 'overview'])->name('analytics.overview');

    Route::get('/marketing', [MarketingController::class, 'index'])->name('marketing.index');
    Route::post('/marketing/subscribers', [MarketingController::class, 'store'])->name('marketing.subscribers.store');
    Route::put('/marketing/subscribers/{subscriber}', [MarketingController::class, 'update'])->name('marketing.subscribers.update');
    Route::delete('/marketing/subscribers/{subscriber}', [MarketingController::class, 'destroy'])->name('marketing.subscribers.destroy');

    Route::get('customers/{customer}/addresses', [CustomerAddressController::class, 'index'])
        ->name('customers.addresses');

    Route::resources([
        'orders' => OrderController::class,
        'customers' => CustomerController::class,
        'reviews' => ReviewController::class,
        'invoices' => InvoiceController::class,
    ]);

    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('attributes', AttributeController::class)->except(['show']);
    Route::resource('tags', TagController::class)->except(['show']);
    Route::resource('discounts', DiscountController::class)->except(['show']);
    Route::resource('coupons', CouponController::class)->except(['show']);
    Route::resource('order-statuses', OrderStatusController::class)->except(['show']);

    $trashedResources = [
        'products' => ProductController::class,
        'categories' => CategoryController::class,
        'tags' => TagController::class,
        'orders' => OrderController::class,
        'customers' => CustomerController::class,
        'coupons' => CouponController::class,
        'discounts' => DiscountController::class,
        'reviews' => ReviewController::class,
        'invoices' => InvoiceController::class,
        'order-statuses' => OrderStatusController::class,
    ];

    foreach ($trashedResources as $prefix => $controller) {
        Route::patch($prefix.'/{id}/restore', [$controller, 'restore'])
            ->name($prefix.'.restore')
            ->whereNumber('id');
        Route::delete($prefix.'/{id}/force', [$controller, 'forceDelete'])
            ->name($prefix.'.force-delete')
            ->whereNumber('id');
    }

    $toggleResources = [
        'products' => ProductController::class,
        'categories' => CategoryController::class,
        'coupons' => CouponController::class,
        'discounts' => DiscountController::class,
        'tags' => TagController::class,
    ];

    foreach ($toggleResources as $prefix => $controller) {
        Route::patch($prefix.'/{id}/toggle', [$controller, 'toggle'])
            ->name($prefix.'.toggle')
            ->whereNumber('id');
    }

    Route::patch('marketing/subscribers/{subscriber}/toggle', [MarketingController::class, 'toggleSubscriber'])
        ->name('marketing.subscribers.toggle')
        ->whereNumber('subscriber');
});

// Legacy route name used by storefront blades and error pages until Fronty renames links.
Route::redirect('/dashboard', '/admin/dashboard')->name('dashboard');
