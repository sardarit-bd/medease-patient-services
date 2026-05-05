<?php

namespace App\Modules\Finance\Services;

use App\Models\MedicalExpense;
use App\Models\PatientProfile;
use App\Models\Prescription;
use App\Models\User;
use Carbon\Carbon;

class FinanceService
{
    private function getPatient(User $user): ?PatientProfile
    {
        return PatientProfile::where('user_id', $user->id)->first();
    }

    public function expenses(User $user, ?string $month = null): array
    {
        $patient = $this->getPatient($user);

        if (! $patient) {
            return [
                'month' => $month ?? Carbon::today()->format('Y-m'),
                'total_amount' => 0,
                'total_reimbursed' => 0,
                'total_remaining_charge' => 0,
                'expenses' => [],
            ];
        }

        try {
            $date = $month
                ? Carbon::createFromFormat('Y-m', $month)->startOfMonth()
                : Carbon::today()->startOfMonth();
        } catch (\Exception $e) {
            $date = Carbon::today()->startOfMonth();
        }

        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        $expenses = MedicalExpense::where('patient_id', $patient->id)
            ->whereBetween('expense_date', [$startOfMonth, $endOfMonth])
            ->orderByDesc('expense_date')
            ->get();

        $totalAmount = $expenses->sum('amount');
        $totalReimbursed = $expenses->sum('reimbursed');
        $totalRemainingCharge = $expenses->sum('remaining_charge');

        return [
            'month' => $date->format('Y-m'),
            'total_amount' => round($totalAmount, 2),
            'total_reimbursed' => round($totalReimbursed, 2),
            'total_remaining_charge' => round($totalRemainingCharge, 2),
            'expenses' => $expenses->map(fn ($e) => [
                'id' => $e->id,
                'label' => $e->label,
                'category' => $e->category,
                'amount' => $e->amount,
                'reimbursed' => $e->reimbursed,
                'remaining_charge' => $e->remaining_charge,
                'expense_date' => $e->expense_date?->toDateString(),
                'prescription_id' => $e->prescription_id,
            ])->values()->toArray(),
        ];
    }

    public function prescriptions(User $user): array
    {
        $patient = $this->getPatient($user);

        if (! $patient) {
            return [
                'active_count' => 0,
                'prescriptions' => [],
            ];
        }

        $today = Carbon::today();

        $prescriptions = Prescription::where('patient_id', $patient->id)
            ->where('is_active', true)
            ->orderBy('renewal_date')
            ->get();

        return [
            'active_count' => $prescriptions->count(),
            'prescriptions' => $prescriptions->map(fn ($p) => [
                'id' => $p->id,
                'issued_date' => $p->issued_date?->toDateString(),
                'renewal_date' => $p->renewal_date?->toDateString(),
                'days_until_renewal' => $p->renewal_date
                    ? max(0, $today->diffInDays($p->renewal_date, false))
                    : null,
                'is_active' => $p->is_active,
                'notes' => $p->notes,
                'document_url' => $p->document_url,
            ])->values()->toArray(),
        ];
    }
}
