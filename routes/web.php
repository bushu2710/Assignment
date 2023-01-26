<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;  
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

Route::get('/', function () {return redirect('sign-in');})->middleware('guest');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');
Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('admin-login');
Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest');
Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');
Route::get('verify', function () {
	return view('sessions.password.verify');
})->middleware('guest')->name('verify'); 
Route::get('/reset-password/{token}', function ($token) {
	return view('sessions.password.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	Route::get('billing', function () {
		return view('pages.billing');
	})->name('billing');
	Route::get('tables', function () {
		return view('pages.tables');
	})->name('tables');
	Route::get('rtl', function () {
		return view('pages.rtl');
	})->name('rtl');
	Route::get('virtual-reality', function () {
		return view('pages.virtual-reality');
	})->name('virtual-reality');
	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');
	Route::get('static-sign-in', function () {
		return view('pages.static-sign-in');
	})->name('static-sign-in');
	Route::get('static-sign-up', function () {
		return view('pages.static-sign-up');
	})->name('static-sign-up');
	
	Route::get('create-user', [UserController::class, 'create'])->name('create-user');
	Route::post('create-user', [UserController::class, 'store'])->name('user-store');
	Route::get('edit-user/{id}', [UserController::class, 'edit'])->name('user-edit');
	Route::post('update-user/{id}', [UserController::class, 'update'])->name('user-update');
	Route::delete("delete-user/{id}", [UserController::class, 'destroy'])->name("user-delete");
	Route::get('admin/users', [UserController::class, 'index'])->name('userIndex');
	Route::get('user-management', [UserController::class, 'index'])->name('user-index');

	Route::get('create-product', [ProductController::class, 'create'])->name('create-product');
	Route::post('create-product', [ProductController::class, 'store'])->name('product-store');
	Route::get('edit-product/{id}', [ProductController::class, 'edit'])->name('edit-product');
	Route::post('update-product/{id}', [ProductController::class, 'update'])->name('product-update');
	Route::get('admin/products', [ProductController::class, 'index'])->name('product-index');
	Route::delete('delete-product/{id}', [ProductController::class, 'destroy'])->name('product-delete');

	Route::get('create-category', [CategoryController::class, 'create'])->name('create-category');
	Route::post('create-category', [CategoryController::class, 'store'])->name('category-store');
	Route::get('edit-category/{id}', [CategoryController::class, 'edit'])->name('edit-category');
	Route::post('update-category/{id}', [CategoryController::class, 'update'])->name('category-update');
	Route::get('admin/categories', [CategoryController::class, 'index'])->name('category-index');
	Route::delete('delete-category/{id}', [CategoryController::class, 'destroy'])->name('category-delete');

	Route::get('user-profile', function () {
		return view('pages.user-profile');
	})->name('user-profile');
});