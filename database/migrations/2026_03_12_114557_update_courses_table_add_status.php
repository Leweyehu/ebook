<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // Add status column if it doesn't exist
            if (!Schema::hasColumn('courses', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('year');
            }
            
            // Add created_by column if it doesn't exist
            if (!Schema::hasColumn('courses', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('status');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            }
            
            // Add semester column if it doesn't exist
            if (!Schema::hasColumn('courses', 'semester')) {
                $table->string('semester')->nullable()->after('ects');
            }
            
            // Add description column if it doesn't exist
            if (!Schema::hasColumn('courses', 'description')) {
                $table->text('description')->nullable()->after('course_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $columns = ['status', 'created_by', 'semester', 'description'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('courses', $column)) {
                    if ($column === 'created_by') {
                        $table->dropForeign(['created_by']);
                    }
                    $table->dropColumn($column);
                }
            }
        });
    }
};