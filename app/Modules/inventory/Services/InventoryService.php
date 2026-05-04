<?php

namespace App\Modules\inventory\Services;

use App\Models\User;
use App\Models\PatientProfile;
use App\Models\MedicationStock;
use Carbon\Carbon;

class InventoryService
{

    private function getPatient(User $user): ?PatientProfile
    {
        return PatientProfile::where('user_id', $user->id)->first();
    }


    public function stock(User $user): array
    {
        $patient = $this->getPatient($user);

        if (!$patient) {
            return [
                'low_stock_count' => 0,
                'expired_count'   => 0,
                'stock'           => [],
            ];
        }

        $today = Carbon::today();

        $stocks = MedicationStock::where('patient_id', $patient->id)
            ->with('medication:id,name,form,dosage')
            ->get();

        $lowStockCount = 0;
        $expiredCount  = 0;

        $stockList = $stocks->map(function ($stock) use ($today, &$lowStockCount, &$expiredCount) {
            $isLowStock = $stock->current_quantity < $stock->low_stock_threshold;
            $isExpired  = $stock->expiry_date && Carbon::parse($stock->expiry_date)->lt($today);

            if ($isLowStock) $lowStockCount++;
            if ($isExpired)  $expiredCount++;

            return [
                'id'                  => $stock->id,
                'medication_id'       => $stock->medication_id,
                'medication_name'     => $stock->medication?->name,
                'medication_form'     => $stock->medication?->form,
                'medication_dosage'   => $stock->medication?->dosage,
                'current_quantity'    => $stock->current_quantity,
                'unit'                => $stock->unit,
                'low_stock_threshold' => $stock->low_stock_threshold,
                'expiry_date'         => $stock->expiry_date,
                'is_low_stock'        => $isLowStock,
                'is_expired'          => $isExpired,
                'last_updated'        => $stock->last_updated,
            ];
        })->values()->toArray();

        return [
            'low_stock_count' => $lowStockCount,
            'expired_count'   => $expiredCount,
            'stock'           => $stockList,
        ];
    }
}