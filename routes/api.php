<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController; 
use App\Http\Controllers\AuthController; 

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
    Route::post('/user/register', [AuthController::class, 'register']);
    Route::post('/user/login', [AuthController::class, 'login'])->name('login');
    Route::post('/user/validate', [AuthController::class, 'userValidate']);
    
    Route::get('/get-categories', [ApiController::class, 'getCategories']);
    Route::get('/get-products', [ApiController::class, 'getProducts']);
    Route::get('/search-products', [ApiController::class, 'search']);
    Route::get('/product-details/{id}', [ApiController::class, 'productDetails']);
    Route::get('/category/{id}/product-list', [ApiController::class, 'productListOfCategory']);

