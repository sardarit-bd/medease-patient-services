<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_alerts', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->enum('type', [
                'medication',
                'appointment',
                'ai_flag',
                'emergency',
                'prevention',
                'system'
            ]);
            $table->string('title', 255);
            $table->text('message');
            $table->enum('priority', [
                'low',
                'medium',
                'high',
                'critical'
            ])->default('low');
            $table->boolean('is_read')->default(false);
            $table->string('action_url', 500)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_alerts');
    }
};