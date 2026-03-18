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
        // First, let's check if the table exists
        if (Schema::hasTable('course_student')) {
            // Check if column exists
            if (!Schema::hasColumn('course_student', 'enrollment_date')) {
                Schema::table('course_student', function (Blueprint $table) {
                    $table->date('enrollment_date')->nullable()->after('status');
                });
                echo "✅ enrollment_date column added successfully.\n";
            } else {
                echo "⚠️ enrollment_date column already exists.\n";
            }
        } else {
            echo "❌ course_student table does not exist.\n";
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('course_student') && Schema::hasColumn('course_student', 'enrollment_date')) {
            Schema::table('course_student', function (Blueprint $table) {
                $table->dropColumn('enrollment_date');
            });
        }
    }
};