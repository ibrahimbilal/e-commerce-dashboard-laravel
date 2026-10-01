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
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::get('/languages', [LanguageController::class, 'index'])->name('languages.index');

    Route::get('customers/{customer}/addresses', [CustomerAddressController::class, 'index'])
        ->name('customers.addresses');

    Route::resources([
        'products' => ProductController::class,
        'categories' => CategoryController::class,
        'orders' => OrderController::class,
        'customers' => CustomerController::class,
        'reviews' => ReviewController::class,
        'users' => UserController::class,
        'roles' => RoleController::class,
        'invoices' => InvoiceController::class,
        'addresses' => AddressController::class,
    ]);

    Route::resource('attributes', AttributeController::class)->except(['show']);
    Route::resource('tags', TagController::class)->except(['show']);
    Route::resource('discounts', DiscountController::class)->except(['show']);
    Route::resource('coupons', CouponController::class)->except(['show']);
    Route::resource('order-statuses', OrderStatusController::class)->except(['show']);
});

require_once 'admin.php';
