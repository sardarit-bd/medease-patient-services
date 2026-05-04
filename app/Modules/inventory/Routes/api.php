<?php

use Illuminate\Support\Facades\Route;
use App\Modules\inventory\Controllers\InventoryController;

Route::middleware('auth:sanctum')->prefix('inventory')->group(function () {

    Route::get('/stock', [InventoryController::class, 'stock']);
});