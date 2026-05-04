<?php

namespace App\Modules\Medications\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Modules\Medications\Services\MedicationsService;
use App\Modules\Medications\Requests\TakeMedicationRequest;

class MedicationsController extends Controller
{
    public function __construct(private MedicationsService $service) {}

    public function today(Request $request)
    {
        $data = $this->service->today($request->user());

        return ApiResponse::success($data, 'Today\'s medications fetched successfully');
    }


    public function take(TakeMedicationRequest $request)
    {
        try {
            $data = $this->service->take($request->user(), $request->validated());

            return ApiResponse::success($data, 'Medication intake logged successfully');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::error('Schedule not found or does not belong to you.', 403);

        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }


    public function observance(Request $request)
    {
        $data = $this->service->observance($request->user());

        return ApiResponse::success($data, 'Observance calculated successfully');
    }


    public function vaccination(Request $request)
    {
        $data = $this->service->vaccination($request->user());

        return ApiResponse::success($data, 'Vaccination records fetched successfully');
    }
}