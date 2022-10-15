<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ClubController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => 'auth:sanctum', 'admin'], function () {

        Route::get('get', [AuthController::class, 'get']);
        Route::post('logout', [AuthController::class, 'logout']);


    });

});
Route::group(['middleware' => 'auth:sanctum', 'admin'], function () {

    Route::apiResource('users', UserController::class);
    Route::apiResource('clubs', ClubController::class);
    Route::apiResource('memberships', MembershipController::class);
    Route::apiResource('invoices', InvoiceController::class);

    Route::get('users/invoices/{user}', [UserController::class, 'userInvoices']);

});
