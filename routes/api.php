<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

require base_path('app/Modules/Auth/Routes/api.php');
require base_path('app/Modules/User/Routes/api.php');
require base_path('app/Modules/Medications/Routes/api.php');
require base_path('app/Modules/Inventory/Routes/api.php');
require base_path('app/Modules/Finance/Routes/api.php');
