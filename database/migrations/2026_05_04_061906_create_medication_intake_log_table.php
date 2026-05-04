<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medication_intake_log', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));

            $table->uuid('schedule_id');
            $table->foreign('schedule_id')
                  ->references('id')->on('medication_schedule')
                  ->onDelete('cascade');

            $table->uuid('patient_id');
            $table->foreign('patient_id')
                  ->references('id')->on('patient_profiles')
                  ->onDelete('cascade');

            $table->timestamp('scheduled_at');      
            $table->timestamp('taken_at')->nullable(); 

            $table->enum('status', [
                'taken',    
                'missed',   
                'delayed',  
                'skipped'   
            ]);
           

            $table->text('notes')->nullable();

            $table->timestamps();   
           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medication_intake_log'); 
    }
};