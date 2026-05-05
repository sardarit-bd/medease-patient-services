<?php

namespace App\Modules\Medications\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Modules\Medications\Requests\TakeMedicationRequest;
use App\Modules\Medications\Services\MedicationsService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

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

        } catch (ModelNotFoundException $e) {
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
