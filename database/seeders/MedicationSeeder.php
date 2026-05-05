<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MedicationSeeder extends Seeder
{
    public function run(): void
    {
        $patient = DB::table('patient_profiles')->value('id');
        $doctor = DB::table('users')->where('role', 'professional')->value('id');
        $prescription = DB::table('prescriptions')->where('is_active', true)->value('id');

        $medications = [
            [
                'id' => Str::uuid(),
                'patient_id' => $patient,
                'prescription_id' => $prescription,
                'prescribed_by' => $doctor,
                'name' => 'Helicidine',
                'dci' => 'Carbocistéine',
                'form' => 'sirop',
                'dosage' => '5ml',
                'start_date' => '2026-04-01',
                'end_date' => '2026-06-01',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'patient_id' => $patient,
                'prescription_id' => $prescription,
                'prescribed_by' => $doctor,
                'name' => 'Asturgil',
                'dci' => 'Fluticasone',
                'form' => 'spray nasal',
                'dosage' => '50µg',
                'start_date' => '2026-03-15',
                'end_date' => '2026-09-15',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'patient_id' => $patient,
                'prescription_id' => $prescription,
                'prescribed_by' => $doctor,
                'name' => 'Doliprane',
                'dci' => 'Paracétamol',
                'form' => 'comprimé',
                'dosage' => '1000mg',
                'start_date' => '2026-01-01',
                'end_date' => null,          // ongoing
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'patient_id' => $patient,
                'prescription_id' => $prescription,
                'prescribed_by' => $doctor,
                'name' => 'Levothyrox',
                'dci' => 'Lévothyroxine',
                'form' => 'comprimé',
                'dosage' => '75µg',
                'start_date' => '2025-01-01',
                'end_date' => null,          // chronic, no end date
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('medications')->insert($medications);

        $this->command->info('✅ MedicationSeeder: 4 rows inserted.');
    }
}
