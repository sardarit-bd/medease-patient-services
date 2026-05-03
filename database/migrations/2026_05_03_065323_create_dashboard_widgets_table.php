<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dashboard_widgets', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->enum('widget_type', [
                'pillbox',
                'transport',
                'appointments',
                'documents',
                'vitals',
                'directory',
                'alerts',
                'prevention'
            ]);
            $table->boolean('is_active')->default(true);
            $table->integer('position')->default(0);
            $table->timestamps();

            // one widget type per user
            $table->unique(['user_id', 'widget_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dashboard_widgets');
    }
};