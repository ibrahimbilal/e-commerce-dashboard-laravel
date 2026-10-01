<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->group(function () {

	// Authentication
	Route::get('/login', function () {
		return view('admin.auth.login');
	})->name('admin.login');

	// forget / reset / confirm password
	Route::get('/forgot-password', function () {
		return view('admin.auth.forgot-password');
	})->name('admin.password.request');

	Route::get('/reset-password/{token}', function ($request) {
		return view('admin.auth.reset-password', ['request' => $request]);
	})->name('admin.password.reset');

	Route::get('/user/confirm-password', function () {
		return view('admin.auth.password-confirm');
	});

	// verify email
	Route::get('/email/verify', function () {
		return view('admin.auth.verify-email');
	})->name('admin.verification.notice');

	// two factor authentication
	Route::get('/two-factor-challeng', function () {
		return view('admin.auth.two-factor-challeng');
	})->name('admin.two-factor.login');

	Route::middleware(['auth', 'verified'])->group(function () {

		Route::get('', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.index');

		// Users
		Route::get('/users/profile', [App\Http\Controllers\Admin\UserController::class, 'profile'])->name('users.profile');
		Route::post('/users/profile', [App\Http\Controllers\Admin\UserController::class, 'update_profile'])->name('users.update_profile');
		Route::post('/users/logout-sessions/', [App\Http\Controllers\Admin\UserController::class, 'logoutSessions'])->name('users.logout_sessions');

		Route::post('/users/show-code', [App\Http\Controllers\Admin\UserController::class, 'show_codes'])->name('users.show_recovery_code');
		Route::post('/users/generate-code', [App\Http\Controllers\Admin\UserController::class, 'regenerate_codes'])->name('users.regenerate_recovery_code');

		Route::post('/users/{user}/restore', [App\Http\Controllers\Admin\UserController::class, 'restore'])->name('users.restore');
		Route::post('/users/{user}/force-delete', [App\Http\Controllers\Admin\UserController::class, 'force_delete'])->name('users.force_delete');

		Route::post('/users/bulk-delete', [App\Http\Controllers\Admin\UserController::class, 'bulk_destroy'])->name('users.bulk_delete');
		Route::post('/users/bulk-restore', [App\Http\Controllers\Admin\UserController::class, 'bulk_restore'])->name('users.bulk_restore');
		Route::post('/users/bulk-force-delete', [App\Http\Controllers\Admin\UserController::class, 'bulk_force_delete'])->name('users.bulk_force_delete');

		Route::resource('/users', App\Http\Controllers\Admin\UserController::class)->names('admin.users');

		// Roles Pages
		Route::resource('/roles', App\Http\Controllers\Admin\RoleController::class)->names('admin.roles');

		// Gallery Pages
		Route::resource('/gallery', App\Http\Controllers\Admin\GalleryController::class)->names('admin.gallery');
		Route::post('/gallery/get-metas', [App\Http\Controllers\Admin\GalleryController::class, 'get_image_meta'])->name('get_metas');

		// Languages Pages
		Route::resource('/langs', App\Http\Controllers\Admin\LanguageController::class)->except(['show', 'edit']);
		Route::get('langs/{slug?}', [App\Http\Controllers\Admin\LanguageController::class, 'edit'])->where('slug', '[A-Za-z]+')->name('langs.edit');
		// Route::get('/langs', [App\Http\Controllers\LanguageController::class, 'index'])->name('langs.index');
		// Route::get('/langs/create', [App\Http\Controllers\LanguageController::class, 'create'])->name('langs.index');
		// Route::get('/langs', [App\Http\Controllers\LanguageController::class, 'index'])->name('langs.index');

		// Settings [General]
		Route::resource('/general-settings', App\Http\Controllers\Admin\Settings\GeneralSettingController::class)->only(['index', 'store']);
		Route::post('/general-settings/date-preview', [App\Http\Controllers\Admin\Settings\GeneralSettingController::class, 'ajax_date_preview'])->name('date_preview');
		// Settings [Theme]
		Route::resource('/theme-settings', App\Http\Controllers\Admin\Settings\ThemeSettingController::class)->only(['index', 'store']);
		// Settings [Store]
		Route::resource('/store-settings', App\Http\Controllers\Admin\Settings\StoreSettingController::class)->only(['index', 'store']);
		// Settings [Currencies]
		Route::resource('/currencies-settings', App\Http\Controllers\Admin\Settings\CurrencySettingController::class)->only(['index', 'store']);
		Route::post('/currencies-settings/get-multi-currencies-component', [App\Http\Controllers\Admin\Settings\CurrencySettingController::class, 'multi_currencies'])->name('multi_currencies');
		// Settings [Emails]
		Route::resource('/emails-settings', App\Http\Controllers\Admin\Settings\EmailSettingController::class)->only(['index', 'store']);
		Route::post('/emails-settings/recipients-type', [App\Http\Controllers\Admin\Settings\EmailSettingController::class, 'recipients_type'])->name('recipients_type');

	});

});
