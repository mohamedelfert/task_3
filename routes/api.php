<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'user', 'namespace' => 'Api'], function () {

    Route::post('register', [AuthController::class,'register']);
    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);

    Route::group(['middleware' => 'auth:api'], function () {

        Route::get('profile', [AuthController::class,'profile']);
        Route::get('products', [ProductController::class,'index']);
        Route::post('add-product', [ProductController::class,'store']);
        Route::post('edit-product', [ProductController::class,'update']);

    });

});
