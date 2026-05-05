<?php

use App\Modules\Auth\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {


    Route::post('/register',     [AuthController::class, 'register']);
    Route::post('/login',        [AuthController::class, 'login']);


    Route::post('/verify-email', [AuthController::class, 'verifyEmail']);

    Route::post('/forgot-password',    [AuthController::class, 'forgotPassword']);
    Route::post('/verify-reset-code',  [AuthController::class, 'verifyResetCode']);
    Route::post('/reset-password',     [AuthController::class, 'resetPassword']);


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout',        [AuthController::class, 'logout']);
        Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
    });
});
