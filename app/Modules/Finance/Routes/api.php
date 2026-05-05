<?php

use App\Modules\Finance\Controllers\FinanceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('finance')->group(function () {

    Route::get('/expenses', [FinanceController::class, 'expenses']);
    Route::get('/prescriptions', [FinanceController::class, 'prescriptions']);
});
