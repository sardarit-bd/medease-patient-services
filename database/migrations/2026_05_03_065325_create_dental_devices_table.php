<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dental_devices', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('patient_id');
            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patient_profiles')
                  ->onDelete('cascade');
            $table->string('device_type', 100);
            $table->text('other_device')->nullable();
            $table->string('tooth_type', 50)->nullable();
            $table->enum('jaw_position', [
                'upper_left',
                'upper_right',
                'lower_left',
                'lower_right'
            ])->nullable();
            $table->date('placement_date')->nullable();
            $table->string('facility_name', 255)->nullable();
            $table->string('dentist_name', 255)->nullable();
            $table->json('documents')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dental_devices');
    }
};