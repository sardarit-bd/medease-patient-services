<?php

namespace App\Modules\Finance\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Modules\Finance\Services\FinanceService;

class FinanceController extends Controller
{
    public function __construct(private FinanceService $service) {}


    public function expenses(Request $request)
    {
        $month = $request->query('month'); 

        $data = $this->service->expenses($request->user(), $month);

        return ApiResponse::success($data, 'Expenses fetched successfully');
    }


    public function prescriptions(Request $request)
    {
        $data = $this->service->prescriptions($request->user());

        return ApiResponse::success($data, 'Prescriptions fetched successfully');
    }
}