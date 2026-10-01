<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerAddressController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TwoFactorPageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::get('/two-factor-recovery', [TwoFactorPageController::class, 'recovery'])
    ->name('two-factor.recovery');

foreach (['400', '401', '403', '404', '500', '503'] as $errorCode) {
    Route::get('/errors/'.$errorCode, fn () => view('errors.'.$errorCode))
        ->name('errors.'.$errorCode);
}

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/theme', [SettingsController::class, 'theme'])->name('settings.theme');
    Route::get('/settings/store', [SettingsController::class, 'store'])->name('settings.store');
    Route::get('/settings/currencies', [SettingsController::class, 'currencies'])->name('settings.currencies');
    Route::get('/settings/emails', [SettingsController::class, 'emails'])->name('settings.emails');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::patch('/settings', [SettingsController::class, 'update']);

    Route::get('/analytics/overview', [AnalyticsController::class, 'overview'])->name('analytics.overview');
    Route::get('/marketing', [MarketingController::class, 'index'])->name('marketing.index');
    Route::post('/marketing/subscribers', [MarketingController::class, 'store'])->name('marketing.subscribers.store');
    Route::put('/marketing/subscribers/{subscriber}', [MarketingController::class, 'update'])->name('marketing.subscribers.update');
    Route::delete('/marketing/subscribers/{subscriber}', [MarketingController::class, 'destroy'])->name('marketing.subscribers.destroy');
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::put('/gallery/{gallery}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
    Route::get('/languages', [LanguageController::class, 'index'])->name('languages.index');

    Route::get('customers/{customer}/addresses', [CustomerAddressController::class, 'index'])
        ->name('customers.addresses');

    Route::resources([
        'orders' => OrderController::class,
        'customers' => CustomerController::class,
        'reviews' => ReviewController::class,
        'users' => UserController::class,
        'roles' => RoleController::class,
        'invoices' => InvoiceController::class,
    ]);

    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('attributes', AttributeController::class)->except(['show']);
    Route::resource('tags', TagController::class)->except(['show']);
    Route::resource('discounts', DiscountController::class)->except(['show']);
    Route::resource('coupons', CouponController::class)->except(['show']);
    Route::resource('order-statuses', OrderStatusController::class)->except(['show']);

    $trashedStorefrontResources = [
        'products' => ProductController::class,
        'categories' => CategoryController::class,
        'tags' => TagController::class,
        'orders' => OrderController::class,
        'customers' => CustomerController::class,
        'coupons' => CouponController::class,
        'discounts' => DiscountController::class,
        'reviews' => ReviewController::class,
        'invoices' => InvoiceController::class,
        'users' => UserController::class,
        'order-statuses' => OrderStatusController::class,
        'gallery' => GalleryController::class,
        'addresses' => AddressController::class,
    ];

    foreach ($trashedStorefrontResources as $prefix => $controller) {
        Route::patch($prefix.'/{id}/restore', [$controller, 'restore'])
            ->name($prefix.'.restore')
            ->whereNumber('id');
        Route::delete($prefix.'/{id}/force', [$controller, 'forceDelete'])
            ->name($prefix.'.force-delete')
            ->whereNumber('id');
    }
});
