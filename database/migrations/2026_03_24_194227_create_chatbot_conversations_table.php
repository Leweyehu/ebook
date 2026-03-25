<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chatbot_conversations', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->string('user_ip')->nullable();
            $table->text('user_message');
            $table->text('bot_response');
            $table->string('intent')->nullable();
            $table->boolean('is_helpful')->nullable();
            $table->timestamps();
            
            $table->index('session_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chatbot_conversations');
    }
};