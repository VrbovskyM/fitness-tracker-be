<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->enum('level', ['debug', 'info', 'warn', 'error']);
            $table->timestamp('timestamp');
            $table->longText('stack')->nullable();
            $table->string('source')->nullable();
            $table->string('user_id')->nullable();
            $table->text('url')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('session_id')->nullable();
            $table->json('additional_data')->nullable(); // For the [key: string]: any part
            $table->timestamps();
            
            // Add indexes for commonly queried fields
            $table->index(['level', 'timestamp']);
            $table->index(['user_id', 'timestamp']);
            $table->index('session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
