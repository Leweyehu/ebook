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
        if (!Schema::hasTable('messages')) {
            Schema::create('messages', function (Blueprint $table) {
                $table->id();
                
                // Direct messaging columns (what your code expects)
                $table->unsignedBigInteger('sender_id');
                $table->unsignedBigInteger('receiver_id');
                
                // Message content
                $table->text('message');
                $table->string('type')->default('text');
                $table->string('attachment')->nullable();
                
                // Status columns
                $table->boolean('is_read')->default(false);
                $table->timestamp('read_at')->nullable();
                
                // Soft delete options
                $table->boolean('is_deleted_by_sender')->default(false);
                $table->boolean('is_deleted_by_receiver')->default(false);
                
                $table->timestamps();
                
                // Foreign keys
                $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
                
                // Indexes
                $table->index(['sender_id', 'receiver_id']);
                $table->index(['receiver_id', 'is_read']);
                $table->index('created_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};