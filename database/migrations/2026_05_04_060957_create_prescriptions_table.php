<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));

            $table->uuid('patient_id');
            $table->foreign('patient_id')
                  ->references('id')->on('patient_profiles')
                  ->onDelete('cascade');

            $table->uuid('prescribed_by')->nullable();
            $table->foreign('prescribed_by')
                  ->references('id')->on('users')
                  ->onDelete('set null');

            $table->date('issued_date');
            $table->date('renewal_date')->nullable();   
            $table->boolean('is_active')->default(true);
            $table->string('document_url', 500)->nullable(); 
            $table->text('notes')->nullable();

            $table->timestamps();       
            $table->softDeletes();      
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions'); // hard delete on rollback
    }
};