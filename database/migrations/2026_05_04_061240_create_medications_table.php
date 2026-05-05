<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medications', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('patient_id');
            $table->foreign('patient_id')
                ->references('id')->on('patient_profiles')
                ->onDelete('cascade');

            $table->uuid('prescription_id')->nullable();
            $table->foreign('prescription_id')
                ->references('id')->on('prescriptions')
                ->onDelete('set null');

            $table->uuid('prescribed_by')->nullable();
            $table->foreign('prescribed_by')
                ->references('id')->on('users')
                ->onDelete('set null');

            $table->string('name', 255);
            $table->string('dci', 255)->nullable();
            $table->string('form', 100)->nullable();
            $table->string('dosage', 100)->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
