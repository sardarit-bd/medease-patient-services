<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('user_id')->unique();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', [
                'male',
                'female',
                'other',
                'prefer_not_to_say',
            ])->nullable();
            $table->string('nationality', 100)->nullable();
            $table->string('language', 100)->nullable();
            $table->enum('blood_group', [
                'A+',
                'B+',
                'AB+',
                'O+',
                'A-',
                'B-',
                'AB-',
                'O-',
                'unknown',
            ])->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email', 255)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 100)->default('France');
            $table->decimal('height_cm', 5, 2)->nullable();
            $table->decimal('weight_kg', 5, 2)->nullable();
            $table->bigInteger('imc')->nullable();
            $table->date('dob_of_height_and_weight')->nullable();
            $table->boolean('profile_completed')->default(false);
            $table->string('photo_url', 500)->nullable();
            $table->string('social_security_number', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_profiles');
    }
};
