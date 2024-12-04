<?php

use App\Http\Controllers\API\V1\BookController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


Route::apiResource('products', ProductController::class);

Route::group(['prefix' => 'v1','as'=>'api.'],function(){
    Route::apiResource('books', BookController::class);

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('profile', [AuthController::class, 'profile']);

        Route::post('books/upload-image', [BookController::class, 'uploadImage']);
        Route::post('books/upload-base64', [BookController::class, 'uploadImageBase64']);

    });
});


