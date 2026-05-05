<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vaccination_records', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('patient_id');
            $table->foreign('patient_id')
                ->references('id')
                ->on('patient_profiles')
                ->onDelete('cascade');
            $table->string('vaccine_name', 255);
            $table->enum('vaccine_category', [
                'mandatory',
                'recommended',
                'specific',
                'other',
            ])->nullable();
            $table->text('other_vaccine')->nullable();
            $table->enum('dose_type', [
                'first',
                'second',
                'booster',
                'complete_schedule',
            ])->nullable();
            $table->date('vaccination_date')->nullable();
            $table->string('professional_name', 255)->nullable();
            $table->string('facility_name', 255)->nullable();
            $table->string('batch_number', 100)->nullable();
            $table->json('documents')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vaccination_records');
    }
};
