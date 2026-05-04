<?php

namespace App\Modules\inventory\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Modules\inventory\Services\InventoryService;

class InventoryController extends Controller
{
    public function __construct(private InventoryService $service) {}

  
    public function stock(Request $request)
    {
        $data = $this->service->stock($request->user());

        return ApiResponse::success($data, 'Stock fetched successfully');
    }
}