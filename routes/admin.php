<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->group(function () {

	// Authentication
	Route::get('/login', function () {
		return view('admin.auth.login');
	})->name('login');

	// forget / reset / confirm password
	Route::get('/forgot-password', function () {
		return view('admin.auth.forgot-password');
	})->name('password.request');

	Route::get('/reset-password/{token}', function ($request) {
		return view('admin.auth.reset-password', ['request' => $request]);
	})->name('password.reset');

	Route::get('/user/confirm-password', function () {
		return view('admin.auth.password-confirm');
	});

	// verify email
	Route::get('/email/verify', function () {
		return view('admin.auth.verify-email');
	})->name('verification.notice');

	// two factor authentication
	Route::get('/two-factor-challeng', function () {
		return view('admin.auth.two-factor-challeng');
	})->name('two-factor.login');

	Route::middleware(['auth', 'verified'])->group(function () {

		Route::get('', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
		Route::post('/bulk', [App\Http\Controllers\AdminController::class, 'bulk_action'])->name('admin.bulk_action');

		// Settings Pages
		Route::resource('/general-settings', App\Http\Controllers\SettingController::class)->only(['index', 'store']);
		Route::post('/general-settings/date-preview', [App\Http\Controllers\SettingController::class, 'ajax_date_preview'])->name('date_preview');

		// Users Pages
		Route::get('/users/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('users.profile');
		Route::post('/users/show-code', [App\Http\Controllers\UserController::class, 'show_codes'])->name('users.show_recovery_code');
		Route::post('/users/generate-code', [App\Http\Controllers\UserController::class, 'regenerate_codes'])->name('users.regenerate_recovery_code');
		Route::post('/users/logout-sessions/', [App\Http\Controllers\UserController::class, 'logoutSessions'])->name('users.logout_sessions');
		Route::post('/users/{user}/restore', [App\Http\Controllers\UserController::class, 'restore'])->name('users.restore');
		Route::resource('/users', App\Http\Controllers\UserController::class);

		// Roles Pages
		Route::resource('/roles', App\Http\Controllers\RoleController::class);
	});

});
