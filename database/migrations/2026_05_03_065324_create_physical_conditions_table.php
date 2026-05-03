<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('physical_conditions', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('patient_id');
            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patient_profiles')
                  ->onDelete('cascade');
            $table->string('condition_type', 100)->nullable();
            $table->string('condition_name', 255);
            $table->text('other_condition')->nullable();
            $table->string('body_location', 100)->nullable();
            $table->date('diagnosis_date')->nullable();
            $table->enum('date_range', [
                '<1yr',
                '1-5yr',
                '>5yr'
            ])->nullable();
            $table->enum('severity', [
                'mild',
                'moderate',
                'severe'
            ])->nullable();
            $table->json('current_treatment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('physical_conditions');
    }
};