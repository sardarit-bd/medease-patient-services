<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PrescriptionSeeder extends Seeder
{
    public function run(): void
    {
        // Grab first 2 patients and first doctor from existing data
        $patients = DB::table('patient_profiles')->limit(2)->pluck('id');
        $doctor = DB::table('users')->where('role', 'professional')->value('id');

        $prescriptions = [
            [
                'id' => Str::uuid(),
                'patient_id' => $patients[0],
                'prescribed_by' => $doctor,
                'issued_date' => '2025-03-01',
                'renewal_date' => '2026-05-12',  // "renouvellement dans 8 jours"
                'is_active' => true,
                'document_url' => null,
                'notes' => 'Traitement hypertension chronique',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'patient_id' => $patients[0],
                'prescribed_by' => $doctor,
                'issued_date' => '2025-10-15',
                'renewal_date' => '2026-06-15',
                'is_active' => true,
                'document_url' => null,
                'notes' => 'Traitement thyroïde',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'patient_id' => $patients[0],
                'prescribed_by' => $doctor,
                'issued_date' => '2025-11-01',
                'renewal_date' => '2026-07-01',
                'is_active' => true,
                'document_url' => null,
                'notes' => 'Antidouleur ponctuel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'patient_id' => $patients[1] ?? $patients[0],
                'prescribed_by' => $doctor,
                'issued_date' => '2024-06-20',
                'renewal_date' => '2025-06-20',
                'is_active' => false,   // expired prescription
                'document_url' => null,
                'notes' => 'Ancienne ordonnance antibiotiques',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('prescriptions')->insert($prescriptions);

        $this->command->info('✅ PrescriptionSeeder: 4 rows inserted.');
    }
}
