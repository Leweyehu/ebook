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
        Schema::table('messages', function (Blueprint $table) {
            // Add sender_id and receiver_id columns
            if (!Schema::hasColumn('messages', 'sender_id')) {
                $table->unsignedBigInteger('sender_id')->after('id');
                $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('messages', 'receiver_id')) {
                $table->unsignedBigInteger('receiver_id')->after('sender_id');
                $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            }
            
            // Make conversation_id nullable (for direct messages without conversation)
            $table->unsignedBigInteger('conversation_id')->nullable()->change();
            
            // Add indexes for the new columns
            $table->index(['sender_id', 'receiver_id']);
            $table->index(['receiver_id', 'is_read']);
        });
        
        // Migrate existing data if any
        // This assumes existing messages use user_id as sender and need a receiver
        if (Schema::hasColumn('messages', 'user_id') && Schema::hasTable('conversation_user')) {
            // You might want to migrate data here if needed
            // This is complex and depends on your conversation structure
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['sender_id']);
            $table->dropForeign(['receiver_id']);
            $table->dropColumn(['sender_id', 'receiver_id']);
            
            // Make conversation_id required again
            $table->unsignedBigInteger('conversation_id')->nullable(false)->change();
        });
    }
};