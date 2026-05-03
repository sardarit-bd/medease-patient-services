<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('physical_activities', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('patient_id');
            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patient_profiles')
                  ->onDelete('cascade');
            $table->string('activity_name', 100);
            $table->enum('category', [
                'cardio',
                'fitness',
                'wellbeing',
                'team_sport',
                'other'
            ]);
            $table->text('other_activity')->nullable();
            $table->enum('frequency', [
                'daily',
                'occasional',
                'regular',
                'frequent'
            ])->nullable();
            $table->enum('avg_duration', [
                '15min',
                '30min',
                '45min',
                '1hr',
                '+1hr'
            ])->nullable();
            $table->enum('intensity', [
                'low',
                'moderate',
                'high'
            ])->nullable();
            $table->enum('objective', [
                'fitness',
                'weight_loss',
                'rehabilitation',
                'competitive',
                'wellbeing'
            ])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('physical_activities');
    }
};