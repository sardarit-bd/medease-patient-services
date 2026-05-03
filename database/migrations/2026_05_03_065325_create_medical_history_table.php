<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_history', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('patient_id');
            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patient_profiles')
                  ->onDelete('cascade');
            $table->enum('history_type', [
                'medical',
                'surgical'
            ]);
            $table->string('category', 100)->nullable();
            $table->string('condition_name', 255);
            $table->text('other_condition')->nullable();
            $table->date('event_date')->nullable();
            $table->enum('date_range', [
                '<1yr',
                '1-5yr',
                '>5yr'
            ])->nullable();
            $table->uuid('facility_id')->nullable();
            $table->string('facility_name', 255)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_history');
    }
};