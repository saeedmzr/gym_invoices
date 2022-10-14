<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClubController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => 'auth:sanctum'], function () {

        Route::get('get', [AuthController::class, 'get']);
        Route::post('logout', [AuthController::class, 'logout']);


    });

});
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('memberships', [AuthController::class, 'memberships']);

    });
    Route::group(['prefix' => 'clubs',], function () {
        Route::get('/', [ClubController::class, 'index']);
        Route::post('/checkin', [ClubController::class, 'checkIn']);

        Route::post('logout', [AuthController::class, 'logout']);
    });


});
