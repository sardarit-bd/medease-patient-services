<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medication_stock', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('medication_id');
            $table->foreign('medication_id')
                ->references('id')->on('medications')
                ->onDelete('cascade');

            $table->uuid('patient_id');
            $table->foreign('patient_id')
                ->references('id')->on('patient_profiles')
                ->onDelete('cascade');

            $table->float('current_quantity');
            $table->string('unit', 50)->nullable();

            $table->date('expiry_date')->nullable();
            $table->integer('low_stock_threshold')->default(5);

            $table->timestamp('last_updated')->useCurrent();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medication_stock');
    }
};
