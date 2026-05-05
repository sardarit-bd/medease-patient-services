<?php

namespace App\Modules\Medications\Services;

use App\Models\Medication;
use App\Models\MedicationIntakeLog;
use App\Models\MedicationSchedule;
use App\Models\MedicationStock;
use App\Models\PatientProfile;
use App\Models\User;
use App\Models\VaccinationRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MedicationsService
{
    private function getPatient(User $user): ?PatientProfile
    {
        return PatientProfile::where('user_id', $user->id)->first();
    }

    public function today(User $user): array
    {
        $patient = $this->getPatient($user);

        if (! $patient) {
            return [
                'treatments_due_today' => 0,
                'treatments_confirmed' => 0,
                'medications' => [],
            ];
        }

        $today = Carbon::today()->toDateString();

        $medications = Medication::where('patient_id', $patient->id)
            ->where('is_active', true)
            ->with(['schedules' => function ($query) {

                $query->where(function ($q) {
                    $q->whereJsonContains('days', 'daily')
                        ->orWhereJsonContains('days', strtolower(Carbon::today()->englishDayOfWeek));
                });
            }])
            ->get();

        $result = [];
        $treatmentsDueToday = 0;
        $treatmentsConfirmed = 0;

        foreach ($medications as $medication) {
            foreach ($medication->schedules as $schedule) {
                $treatmentsDueToday++;

                $log = MedicationIntakeLog::where('schedule_id', $schedule->id)
                    ->whereDate('scheduled_at', $today)
                    ->first();

                if ($log && in_array($log->status, ['taken', 'delayed'])) {
                    $treatmentsConfirmed++;
                }

                $result[] = [
                    'medication' => [
                        'id' => $medication->id,
                        'name' => $medication->name,
                        'form' => $medication->form,
                        'dosage' => $medication->dosage,
                    ],
                    'schedule' => [
                        'id' => $schedule->id,
                        'time_of_day' => $schedule->time_of_day,
                        'moment' => $schedule->moment,
                        'quantity' => $schedule->quantity,
                        'unit' => $schedule->unit,
                        'instruction' => $schedule->instruction,
                    ],
                    'intake_log' => $log ? [
                        'status' => $log->status,
                        'taken_at' => $log->taken_at,
                        'notes' => $log->notes,
                    ] : [
                        'status' => 'pending',
                        'taken_at' => null,
                        'notes' => null,
                    ],
                ];
            }
        }

        return [
            'treatments_due_today' => $treatmentsDueToday,
            'treatments_confirmed' => $treatmentsConfirmed,
            'medications' => $result,
        ];
    }

    public function take(User $user, array $data): array
    {
        $patient = $this->getPatient($user);

        if (! $patient) {
            throw new \Exception('Patient profile not found.');
        }

        $schedule = MedicationSchedule::where('id', $data['schedule_id'])
            ->where('patient_id', $patient->id)
            ->firstOrFail();

        $today = Carbon::today()->toDateString();

        return DB::transaction(function () use ($schedule, $patient, $data, $today) {

            $log = MedicationIntakeLog::updateOrCreate(
                [
                    'schedule_id' => $schedule->id,
                    'patient_id' => $patient->id,
                    'scheduled_at' => $today.' '.$schedule->time_of_day,
                ],
                [
                    'status' => $data['status'],
                    'taken_at' => in_array($data['status'], ['taken', 'delayed'])
                                    ? now()
                                    : null,
                    'notes' => $data['notes'] ?? null,
                ]
            );

            $lowStockAlertTriggered = false;
            $newQuantity = null;

            if (in_array($data['status'], ['taken', 'delayed'])) {
                $stock = MedicationStock::where('medication_id', $schedule->medication_id)
                    ->where('patient_id', $patient->id)
                    ->first();

                if ($stock) {
                    $stock->current_quantity = max(0, $stock->current_quantity - $schedule->quantity);
                    $stock->last_updated = now();
                    $stock->save();

                    $newQuantity = $stock->current_quantity;

                    if ($stock->current_quantity < $stock->low_stock_threshold) {
                        $lowStockAlertTriggered = true;

                        DB::table('user_alerts')->insert([
                            'id' => (string) Str::uuid(),
                            'user_id' => auth()->id(),
                            'type' => 'medication',
                            'title' => 'Stock bas — '.$schedule->medication->name,
                            'message' => 'Il vous reste '.$stock->current_quantity
                                            .' '.$stock->unit.'. Pensez à renouveler.',
                            'priority' => 'high',
                            'is_read' => false,
                            'action_url' => '/patient/inventory/stock',
                            'created_at' => now(),
                        ]);
                    }
                }
            }

            return [
                'status' => $log->status,
                'taken_at' => $log->taken_at,
                'new_stock_quantity' => $newQuantity,
                'low_stock_alert_triggered' => $lowStockAlertTriggered,
            ];
        });
    }

    public function observance(User $user): array
    {
        $patient = $this->getPatient($user);

        if (! $patient) {
            return [
                'date' => Carbon::today()->toDateString(),
                'total_scheduled' => 0,
                'total_taken' => 0,
                'observance_percentage' => 0,
            ];
        }

        $today = Carbon::today()->toDateString();

        $total = MedicationIntakeLog::where('patient_id', $patient->id)
            ->whereDate('scheduled_at', $today)
            ->count();

        $taken = MedicationIntakeLog::where('patient_id', $patient->id)
            ->whereDate('scheduled_at', $today)
            ->whereIn('status', ['taken', 'delayed'])
            ->count();

        $percentage = $total > 0 ? round(($taken / $total) * 100) : 0;

        return [
            'date' => $today,
            'total_scheduled' => $total,
            'total_taken' => $taken,
            'observance_percentage' => $percentage,
        ];
    }

    public function vaccination(User $user): array
    {
        $patient = $this->getPatient($user);

        if (! $patient) {
            return [
                'all_up_to_date' => false,
                'total_vaccines' => 0,
                'vaccines' => [],
            ];
        }

        $vaccines = VaccinationRecord::where('patient_id', $patient->id)
            ->orderByDesc('vaccination_date')
            ->get();

        // Mandatory vaccines required in France
        $mandatoryRequired = ['DTPolio', 'ROR', 'Hépatite B', 'Méningocoque C'];

        $mandatoryDone = VaccinationRecord::where('patient_id', $patient->id)
            ->where('vaccine_category', 'mandatory')
            ->whereIn('dose_type', ['complete_schedule', 'booster'])
            ->pluck('vaccine_name')
            ->toArray();

        $allUpToDate = count(array_intersect($mandatoryRequired, $mandatoryDone))
                        === count($mandatoryRequired);

        return [
            'all_up_to_date' => $allUpToDate,
            'total_vaccines' => $vaccines->count(),
            'vaccines' => $vaccines->map(fn ($v) => [
                'id' => $v->id,
                'vaccine_name' => $v->vaccine_name,
                'vaccine_category' => $v->vaccine_category,
                'dose_type' => $v->dose_type,
                'vaccination_date' => $v->vaccination_date,
                'professional_name' => $v->professional_name,
                'facility_name' => $v->facility_name,
                'batch_number' => $v->batch_number,
            ])->values()->toArray(),
        ];
    }
}
