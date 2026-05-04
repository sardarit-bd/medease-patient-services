<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Medications\Controllers\MedicationsController;

Route::middleware('auth:sanctum')->prefix('medications')->group(function () {

    Route::get('/today',       [MedicationsController::class, 'today']);
    Route::post('/take',       [MedicationsController::class, 'take']);
    Route::get('/observance',  [MedicationsController::class, 'observance']);
    Route::get('/vaccination', [MedicationsController::class, 'vaccination']);
});