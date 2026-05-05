<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MedicalExpenseSeeder extends Seeder
{
    public function run(): void
    {
        $patient = DB::table('patient_profiles')->value('id');
        $prescription = DB::table('prescriptions')->where('is_active', true)->value('id');

        // Month context: May 2026 — total should = 127,50€ as shown on dashboard
        $expenses = [
            [
                'id' => Str::uuid(),
                'patient_id' => $patient,
                'prescription_id' => $prescription,
                'label' => 'Consultation Dr. Martin',
                'category' => 'consultation',
                'amount' => 60.00,
                'reimbursed' => 42.00,    // sécu covers 70%
                'remaining_charge' => 18.00,    // reste à charge
                'expense_date' => '2026-05-02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'patient_id' => $patient,
                'prescription_id' => $prescription,
                'label' => 'Pharmacie Centrale — Levothyrox + Doliprane',
                'category' => 'pharmacy',
                'amount' => 32.50,
                'reimbursed' => 22.25,
                'remaining_charge' => 10.25,
                'expense_date' => '2026-05-03',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'patient_id' => $patient,
                'prescription_id' => null,
                'label' => 'Radio thoracique — Centre d\'imagerie',
                'category' => 'radiology',
                'amount' => 25.00,
                'reimbursed' => 17.50,
                'remaining_charge' => 7.50,
                'expense_date' => '2026-05-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'patient_id' => $patient,
                'prescription_id' => null,
                'label' => 'Transport médical — Ambulance',
                'category' => 'transport',
                'amount' => 10.00,
                'reimbursed' => 7.50,
                'remaining_charge' => 2.50,
                'expense_date' => '2026-05-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Total amount     : 60 + 32.50 + 25 + 10 = 127.50€ ✅ matches dashboard
        // Total reimbursed : 42 + 22.25 + 17.50 + 7.50 = 89.25€
        // Reste à charge   : 18 + 10.25 + 7.50 + 2.50 = 38.25€ ✅ matches dashboard

        DB::table('medical_expenses')->insert($expenses);

        $this->command->info('✅ MedicalExpenseSeeder: 4 rows inserted.');
        $this->command->info('   → Total: 127.50€ ✅');
        $this->command->info('   → Reste à charge: 38.25€ ✅');
        $this->command->info('   → Matches dashboard exactly!');
    }
}
