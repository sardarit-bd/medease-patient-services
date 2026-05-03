<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('allergies', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('patient_id');
            $table->foreign('patient_id')
                  ->references('id')
                  ->on('patient_profiles')
                  ->onDelete('cascade');
            $table->enum('allergy_type', [
                'drug',
                'food',
                'environmental',
                'contact_skin',
                'venom_insect'
            ]);
            $table->string('substance_name', 255);
            $table->text('other_substance')->nullable();
            $table->json('reaction_types')->nullable();
            $table->enum('severity', [
                'mild',
                'moderate',
                'severe'
            ])->nullable();
            $table->date('reaction_date')->nullable();
            $table->enum('is_confirmed', [
                'confirmed',
                'suspected',
                'not_confirmed'
            ])->nullable();
            $table->json('emergency_treatment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('allergies');
    }
};