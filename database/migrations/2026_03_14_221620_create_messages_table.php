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
            // Add direct messaging columns if they don't exist
            if (!Schema::hasColumn('messages', 'sender_id')) {
                $table->foreignId('sender_id')->after('id')->constrained('users')->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('messages', 'receiver_id')) {
                $table->foreignId('receiver_id')->after('sender_id')->constrained('users')->onDelete('cascade');
            }
            
            // Make conversation_id nullable
            $table->unsignedBigInteger('conversation_id')->nullable()->change();
            
            // Keep user_id but maybe rename for clarity? Or keep as is
            // $table->renameColumn('user_id', 'sender_id'); // Option to rename
            
            // Add soft delete columns if missing
            if (!Schema::hasColumn('messages', 'is_deleted_by_sender')) {
                $table->boolean('is_deleted_by_sender')->default(false)->after('read_at');
            }
            
            if (!Schema::hasColumn('messages', 'is_deleted_by_receiver')) {
                $table->boolean('is_deleted_by_receiver')->default(false)->after('is_deleted_by_sender');
            }
            
            // Add indexes
            $table->index(['sender_id', 'receiver_id']);
            $table->index(['receiver_id', 'is_read']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['sender_id']);
            $table->dropForeign(['receiver_id']);
            $table->dropColumn(['sender_id', 'receiver_id', 'is_deleted_by_sender', 'is_deleted_by_receiver']);
            
            // Make conversation_id required again
            $table->unsignedBigInteger('conversation_id')->nullable(false)->change();
        });
    }
};