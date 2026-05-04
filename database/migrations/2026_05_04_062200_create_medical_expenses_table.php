<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_expenses', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('patient_id');
            $table->foreign('patient_id')
                  ->references('id')->on('patient_profiles')
                  ->onDelete('cascade');

            $table->uuid('prescription_id')->nullable();
            $table->foreign('prescription_id')
                  ->references('id')->on('prescriptions')
                  ->onDelete('set null');

            $table->string('label', 255)->nullable();
        
            $table->string('category', 100)->nullable();
   

            $table->float('amount');                       
            $table->float('reimbursed')->default(0);        
            $table->float('remaining_charge')->nullable();
  

            $table->date('expense_date');

            $table->timestamps();    
            $table->softDeletes();  
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_expenses');
    }
};