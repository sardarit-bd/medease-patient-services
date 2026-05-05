<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medication_schedule', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('medication_id');
            $table->foreign('medication_id')
                ->references('id')->on('medications')
                ->onDelete('cascade');

            $table->uuid('patient_id');
            $table->foreign('patient_id')
                ->references('id')->on('patient_profiles')
                ->onDelete('cascade');

            $table->time('time_of_day');
            $table->string('moment', 20)->nullable();

            $table->float('quantity');
            $table->string('unit', 50)->nullable();

            $table->text('instruction')->nullable();

            $table->json('days')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medication_schedule');
    }
};
