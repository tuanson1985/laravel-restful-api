<?php

use App\Http\Controllers\API\V1\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::group(['prefix' => 'api/v1'], function () {
//    Route::apiResource('books', BookController::class);
//});
