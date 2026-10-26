<?php

use App\Http\Controllers\Api\User\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::prefix('otp')->group(function () {
        Route::post('send', 'sendOtp');
        Route::post('verify', 'verifyOtp');
    });
    Route::post('register', 'register')->middleware('auth:api');
    Route::get('profile', 'profile')->middleware('auth:api');
    Route::post('logout', 'logout')->middleware('auth:api');
});
