<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advance_directives', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('patient_id')->unique();
            // one directive per patient
            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patient_profiles')
                  ->onDelete('cascade');
            $table->enum('status', [
                'want_to_write',
                'already_have',
                'dont_want'
            ])->nullable();
            $table->enum('resuscitation', [
                'accepted',
                'refused',
                'discuss'
            ])->nullable();
            $table->enum('ventilation', [
                'accepted',
                'refused',
                'discuss'
            ])->nullable();
            $table->enum('dialysis', [
                'accepted',
                'refused',
                'discuss'
            ])->nullable();
            $table->enum('artificial_nutrition', [
                'accepted',
                'refused',
                'discuss'
            ])->nullable();
            $table->enum('artificial_hydration', [
                'accepted',
                'refused',
                'discuss'
            ])->nullable();
            $table->boolean('limit_treatments')->default(false);
            $table->string('document_url', 500)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advance_directives');
    }
};