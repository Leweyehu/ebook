<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('messages')) {
            Schema::create('messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
                $table->text('message');
                $table->string('type')->default('text');
                $table->string('attachment')->nullable();
                $table->boolean('is_read')->default(false);
                $table->timestamp('read_at')->nullable();
                $table->boolean('is_deleted_by_sender')->default(false);
                $table->boolean('is_deleted_by_receiver')->default(false);
                $table->timestamps();
                
                $table->index(['sender_id', 'receiver_id']);
                $table->index(['receiver_id', 'is_read']);
            });
        }
    }

    public function down(): void
    {
        // Don't drop the table in down() to prevent data loss
    }
};