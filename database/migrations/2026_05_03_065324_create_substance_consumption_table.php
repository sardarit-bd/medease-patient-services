<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('substance_consumption', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('patient_id');
            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patient_profiles')
                  ->onDelete('cascade');
            $table->string('substance_name', 100);
            $table->text('other_substance')->nullable();
            $table->enum('frequency', [
                'occasional',
                'monthly',
                'weekly',
                'daily'
            ])->nullable();
            $table->enum('mode', [
                'inhalation',
                'oral',
                'injection',
                'other'
            ])->nullable();
            $table->date('last_consumption')->nullable();
            $table->enum('context', [
                'recreational',
                'misused_medical',
                'festive',
                'other'
            ])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('substance_consumption');
    }
};