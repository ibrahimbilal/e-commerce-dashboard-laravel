<?php

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

Route::prefix('admin/')->group(function () {

	Route::get('', [App\Http\Controllers\AdminController::class, 'index'])->name('index');

	// Settings Pages
	Route::controller(App\Http\Controllers\SettingController::class)
		->prefix('general-settings')
		->group(function () {
			Route::get('', 'view_general_page')->name('general_settings');
			Route::post('save', 'save_general_settings')->name('save_general_settings');
			Route::post('date-preview', 'ajax_date_preview')->name('date_preview');
		});

	// Users Pages
	Route::controller(App\Http\Controllers\UserController::class)
		->prefix('users')
		->group(function () {
			Route::get('', 'list')->name('users.list');
			Route::get('add', 'add')->name('users.add');
			Route::post('create', 'create')->name('users.create');
			Route::get('edit/{id}', 'edit')->name('users.edit');
			Route::post('update/{id}', 'update')->name('users.update');
		});

	// Roles Pages
	Route::controller(App\Http\Controllers\RoleController::class)
		->prefix('roles')
		->group(function () {
			Route::get('', 'list')->name('roles.list');
			Route::get('add', 'add')->name('roles.add');
			Route::post('create', 'create')->name('roles.create');
			Route::get('edit/{id}', 'edit')->name('roles.edit');
			Route::post('update/{id}', 'update')->name('roles.update');
			Route::post('delete/{id}', 'delete')->name('roles.delete');
		});
});

// Route::group([
// 	'prefix' => 'admin',
// 	'where' => ['locale' => '[a-zA-Z]{2}'],
// 	'middleware' => 'Localization'
// ], function () {

// 	Route::get('', [App\Http\Controllers\AdminController::class, 'index'])->name('index');

// 	// Settings Pages
// 	Route::controller(App\Http\Controllers\SettingController::class)
// 		->prefix('general-settings')
// 		->group(function () {
// 			Route::get('', 'view_general_page')->name('general_settings');
// 			Route::post('save', 'save_general_settings')->name('save_general_settings');
// 			Route::post('date-preview', 'ajax_date_preview')->name('date_preview');
// 		});

// 	// Users Pages
// 	Route::controller(App\Http\Controllers\UserController::class)
// 		->prefix('users')
// 		->group(function () {
// 			Route::get('', 'list')->name('users.list');
// 			Route::get('edit/{id}', 'edit')->name('users.edit');
// 			Route::post('update/{id}', 'update')->name('users.update');
// 		});
// });

// Route::get('admin', function () {
//     return redirect(app()->getLocale() . '/admin');
// });
