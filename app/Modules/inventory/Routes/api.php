<?php

use App\Modules\inventory\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;
// hello
Route::middleware('auth:sanctum')->prefix('inventory')->group(function () {

    Route::get('/stock', [InventoryController::class, 'stock']);
});
