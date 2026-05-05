<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MedicationScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $patient = DB::table('patient_profiles')->value('id');
        $medications = DB::table('medications')->pluck('id');

        $schedules = [
            [
                'id' => Str::uuid(),
                'medication_id' => $medications[0], // Helicidine
                'patient_id' => $patient,
                'time_of_day' => '09:00:00',
                'moment' => 'morning',        // Matin
                'quantity' => 1,
                'unit' => 'cuillère soupe',
                'instruction' => 'Avant le repas',
                'days' => json_encode(['daily']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'medication_id' => $medications[1], // Asturgil
                'patient_id' => $patient,
                'time_of_day' => '09:00:00',
                'moment' => 'morning',        // Matin
                'quantity' => 2,
                'unit' => 'pulvérisations',
                'instruction' => 'Une pulvérisation par narine',
                'days' => json_encode(['daily']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'medication_id' => $medications[2], // Doliprane
                'patient_id' => $patient,
                'time_of_day' => '12:30:00',
                'moment' => 'noon',           // Midi
                'quantity' => 1,
                'unit' => 'comprimé',
                'instruction' => 'Avec un grand verre d\'eau',
                'days' => json_encode(['daily']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'medication_id' => $medications[3], // Levothyrox
                'patient_id' => $patient,
                'time_of_day' => '18:00:00',
                'moment' => 'evening',        // Soir
                'quantity' => 1,
                'unit' => 'comprimé',
                'instruction' => 'À jeun, 30 min avant le dîner',
                'days' => json_encode(['daily']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('medication_schedule')->insert($schedules);

        $this->command->info('✅ MedicationScheduleSeeder: 4 rows inserted.');
        $this->command->info('   → Matches dashboard: Helicidine 09:00 / Asturgil 09:00 / Doliprane 12:30 / Levothyrox 18:00');
    }
}
