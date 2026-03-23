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
        Schema::table('contacts', function (Blueprint $table) {
            // Add subject column if it doesn't exist
            if (!Schema::hasColumn('contacts', 'subject')) {
                $table->string('subject')->after('email')->nullable();
            }
            
            // Also check for other columns that might be missing
            if (!Schema::hasColumn('contacts', 'admin_reply')) {
                $table->text('admin_reply')->nullable()->after('message');
            }
            
            if (!Schema::hasColumn('contacts', 'ip_address')) {
                $table->string('ip_address')->nullable()->after('status');
            }
            
            if (!Schema::hasColumn('contacts', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('ip_address');
            }
            
            if (!Schema::hasColumn('contacts', 'replied_at')) {
                $table->timestamp('replied_at')->nullable()->after('user_agent');
            }
            
            if (!Schema::hasColumn('contacts', 'replied_by')) {
                $table->foreignId('replied_by')->nullable()->constrained('users')->after('replied_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn([
                'subject', 
                'admin_reply', 
                'ip_address', 
                'user_agent', 
                'replied_at', 
                'replied_by'
            ]);
        });
    }
};