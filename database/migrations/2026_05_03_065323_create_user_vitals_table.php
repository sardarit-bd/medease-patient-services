<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_vitals', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('patient_id');
            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patient_profiles')
                  ->onDelete('cascade');
            $table->enum('type', [
                'blood_pressure',
                'heart_rate',
                'glucose',
                'temperature',
                'weight',
                'oxygen_saturation'
            ]);
            $table->float('value');
            $table->string('unit', 20);
            $table->enum('source', [
                'manual',
                'device',
                'telemonitoring'
            ])->default('manual');
            $table->text('notes')->nullable();
            $table->timestamp('recorded_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_vitals');
    }
};