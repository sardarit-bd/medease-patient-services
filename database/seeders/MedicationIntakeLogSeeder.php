<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MedicationIntakeLogSeeder extends Seeder
{
    public function run(): void
    {
        $patient   = DB::table('patient_profiles')->value('id');
        $schedules = DB::table('medication_schedule')->pluck('id');

        // Today's date for dashboard context
        $today = now()->format('Y-m-d');

        $logs = [
            [
                'id'           => Str::uuid(),
                'schedule_id'  => $schedules[0],        // Helicidine 09:00
                'patient_id'   => $patient,
                'scheduled_at' => $today . ' 09:00:00',
                'taken_at'     => $today . ' 09:05:00', // ✅ taken on time
                'status'       => 'taken',
                'notes'        => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id'           => Str::uuid(),
                'schedule_id'  => $schedules[1],        // Asturgil 09:00
                'patient_id'   => $patient,
                'scheduled_at' => $today . ' 09:00:00',
                'taken_at'     => $today . ' 09:45:00', // ⏰ taken late (delayed)
                'status'       => 'delayed',
                'notes'        => 'Pris en retard ce matin',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id'           => Str::uuid(),
                'schedule_id'  => $schedules[2],        // Doliprane 12:30
                'patient_id'   => $patient,
                'scheduled_at' => $today . ' 12:30:00',
                'taken_at'     => null,                 // ❌ not taken yet (pending)
                'status'       => 'missed',
                'notes'        => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id'           => Str::uuid(),
                'schedule_id'  => $schedules[3],        // Levothyrox 18:00
                'patient_id'   => $patient,
                'scheduled_at' => $today . ' 18:00:00',
                'taken_at'     => null,                 // ⏭️ skipped intentionally
                'status'       => 'skipped',
                'notes'        => 'Pas pris ce soir - voyage',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ];

        // Observance calculation from this data:
        // taken: 1 out of 4 = 25% (close to the 50% shown in dashboard)
        // taken + delayed: 2 out of 4 = 50% ← matches dashboard exactly ✅

        DB::table('medication_intake_log')->insert($logs);

        $this->command->info('✅ MedicationIntakeLogSeeder: 4 rows inserted.');
        $this->command->info('   → taken: 1, delayed: 1, missed: 1, skipped: 1');
        $this->command->info('   → Observance = (taken + delayed) / total = 2/4 = 50% ✅');
    }
}