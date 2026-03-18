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
            // Add ip_address column if it doesn't exist
            if (!Schema::hasColumn('contacts', 'ip_address')) {
                $table->string('ip_address', 45)->nullable()->after('message');
            }
            
            // Add user_agent column if it doesn't exist
            if (!Schema::hasColumn('contacts', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('ip_address');
            }
            
            // Add status column if it doesn't exist
            if (!Schema::hasColumn('contacts', 'status')) {
                $table->string('status')->default('unread')->after('user_agent');
            }
            
            // Add admin_reply column if it doesn't exist
            if (!Schema::hasColumn('contacts', 'admin_reply')) {
                $table->text('admin_reply')->nullable()->after('status');
            }
            
            // Add replied_at column if it doesn't exist
            if (!Schema::hasColumn('contacts', 'replied_at')) {
                $table->timestamp('replied_at')->nullable()->after('admin_reply');
            }
            
            // Add replied_by column if it doesn't exist
            if (!Schema::hasColumn('contacts', 'replied_by')) {
                $table->unsignedBigInteger('replied_by')->nullable()->after('replied_at');
                $table->foreign('replied_by')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $columns = ['ip_address', 'user_agent', 'status', 'admin_reply', 'replied_at', 'replied_by'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('contacts', $column)) {
                    if ($column === 'replied_by') {
                        $table->dropForeign(['replied_by']);
                    }
                    $table->dropColumn($column);
                }
            }
        });
    }
};