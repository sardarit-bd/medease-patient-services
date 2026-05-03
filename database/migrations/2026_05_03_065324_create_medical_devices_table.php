<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_devices', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('patient_id');
            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patient_profiles')
                  ->onDelete('cascade');
            $table->string('device_type', 100);
            $table->string('device_name', 255)->nullable();
            $table->text('other_device')->nullable();
            $table->string('body_location', 100)->nullable();
            $table->date('implant_date')->nullable();
            $table->enum('date_range', [
                '<1yr',
                '1-5yr',
                '>5yr',
                'unknown'
            ])->nullable();
            $table->uuid('facility_id')->nullable();
            $table->enum('follow_up', [
                'yes',
                'no',
                'pending'
            ])->nullable();
            $table->json('documents')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_devices');
    }
};