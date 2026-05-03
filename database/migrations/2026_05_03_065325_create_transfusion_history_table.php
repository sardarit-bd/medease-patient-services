<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfusion_history', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('patient_id');
            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patient_profiles')
                  ->onDelete('cascade');
            $table->date('transfusion_date')->nullable();
            $table->string('facility_name', 255)->nullable();
            $table->enum('department', [
                'emergencies',
                'operating_room',
                'intensive_care',
                'surgery',
                'hematology',
                'maternity',
                'other'
            ])->nullable();
            $table->integer('units_count')->nullable();
            $table->enum('reason', [
                'surgery',
                'hemorrhage',
                'accident',
                'hematological_disease',
                'childbirth',
                'other'
            ])->nullable();
            $table->text('other_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfusion_history');
    }
};