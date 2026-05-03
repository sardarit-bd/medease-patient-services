<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emergency_contacts', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('patient_id');
            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patient_profiles')
                  ->onDelete('cascade');
            $table->string('full_name', 255);
            $table->string('phone', 20);
            $table->string('email', 255)->nullable();
            $table->enum('relationship', [
                'spouse',
                'parent',
                'child',
                'sibling',
                'physician',
                'nurse',
                'friend',
                'legal_guardian',
                'other'
            ]);
            $table->boolean('can_decide')->default(false);
            $table->boolean('is_primary')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emergency_contacts');
    }
};