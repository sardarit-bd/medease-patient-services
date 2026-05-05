<?php

use App\Modules\User\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('user')->group(function () {

    Route::get('/profile', [UserController::class, 'getProfile']);
    Route::patch('/profile', [UserController::class, 'updateProfile']);
    Route::post('/profile/photo', [UserController::class, 'uploadPhoto']);
    Route::delete('/profile/deactivate', [UserController::class, 'softDelete']);
    Route::delete('/profile/delete', [UserController::class, 'hardDelete']);
});
