<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});

Route::prefix('/admin')->middleware(['auth', 'verified'])->group(function () {

	Route::get('', [App\Http\Controllers\AdminController::class, 'index'])->name('index');

	// Settings Pages
	Route::resource('/general-settings', App\Http\Controllers\SettingController::class)->only(['index', 'store']);
	Route::post('/general-settings/date-preview', [App\Http\Controllers\SettingController::class, 'ajax_date_preview'])->name('date_preview');

	// Users Pages
	Route::post('/users/show-code/{user}', [App\Http\Controllers\UserController::class, 'show_codes'])->name('users.show_recovery_code');
	Route::resource('/users', App\Http\Controllers\UserController::class);

	// Roles Pages
	Route::resource('/roles', App\Http\Controllers\RoleController::class);
});
