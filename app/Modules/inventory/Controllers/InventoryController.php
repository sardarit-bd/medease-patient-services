<?php

namespace App\Modules\inventory\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Modules\inventory\Services\InventoryService;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function __construct(private InventoryService $service) {}

    public function stock(Request $request)
    {
        $data = $this->service->stock($request->user());

        return ApiResponse::success($data, 'Stock fetched successfully');
    }
}
