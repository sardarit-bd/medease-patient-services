<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MedicationStockSeeder extends Seeder
{
    public function run(): void
    {
        $patient = DB::table('patient_profiles')->value('id');
        $medications = DB::table('medications')->pluck('id');

        $stocks = [
            [
                'id' => Str::uuid(),
                'medication_id' => $medications[0], // Helicidine
                'patient_id' => $patient,
                'current_quantity' => 2,               // ⚠️ LOW STOCK → triggers "Stock bas: 02"
                'unit' => 'flacons',
                'expiry_date' => '2026-08-01',
                'low_stock_threshold' => 3,
                'last_updated' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'medication_id' => $medications[1], // Asturgil
                'patient_id' => $patient,
                'current_quantity' => 1,               // ⚠️ LOW STOCK
                'unit' => 'sprays',
                'expiry_date' => '2025-12-01',    // ⚠️ EXPIRED → triggers "Médicaments périmés"
                'low_stock_threshold' => 2,
                'last_updated' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'medication_id' => $medications[2], // Doliprane
                'patient_id' => $patient,
                'current_quantity' => 20,              // ✅ sufficient
                'unit' => 'comprimés',
                'expiry_date' => '2025-10-15',    // ⚠️ EXPIRED
                'low_stock_threshold' => 5,
                'last_updated' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'medication_id' => $medications[3], // Levothyrox
                'patient_id' => $patient,
                'current_quantity' => 28,              // ✅ sufficient
                'unit' => 'comprimés',
                'expiry_date' => '2027-03-01',    // ✅ not expired
                'low_stock_threshold' => 7,
                'last_updated' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('medication_stock')->insert($stocks);

        $this->command->info('✅ MedicationStockSeeder: 4 rows inserted.');
        $this->command->info('   → 2 low stock alerts will fire (Helicidine, Asturgil)');
        $this->command->info('   → 2 expired alerts will fire (Asturgil, Doliprane)');
    }
}
