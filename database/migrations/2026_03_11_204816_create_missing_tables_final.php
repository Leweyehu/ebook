<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create course_notices table if missing
        if (!Schema::hasTable('course_notices')) {
            Schema::create('course_notices', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('course_id');
                $table->unsignedBigInteger('posted_by');
                $table->string('title');
                $table->text('content');
                $table->string('attachment_path')->nullable();
                $table->string('attachment_name')->nullable();
                $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
                $table->boolean('is_active')->default(true);
                $table->timestamp('expires_at')->nullable();
                $table->timestamps();
            });
        }

        // Create grades table if missing
        if (!Schema::hasTable('grades')) {
            Schema::create('grades', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('student_id');
                $table->unsignedBigInteger('course_id');
                $table->unsignedBigInteger('assignment_id')->nullable();
                $table->decimal('score', 5, 2);
                $table->decimal('percentage', 5, 2)->nullable();
                $table->string('letter_grade')->nullable();
                $table->text('remarks')->nullable();
                $table->enum('grade_type', ['assignment', 'quiz', 'midterm', 'final', 'project', 'lab', 'participation'])->default('assignment');
                $table->unsignedBigInteger('graded_by');
                $table->timestamps();
            });
        }

        // Create course_student table if missing
        if (!Schema::hasTable('course_student')) {
            Schema::create('course_student', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('course_id');
                $table->unsignedBigInteger('student_id');
                $table->string('academic_year')->nullable();
                $table->enum('status', ['enrolled', 'completed', 'dropped'])->default('enrolled');
                $table->timestamps();
            });
        }

        // Create assignment_submissions table if missing
        if (!Schema::hasTable('assignment_submissions')) {
            Schema::create('assignment_submissions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('assignment_id');
                $table->unsignedBigInteger('student_id');
                $table->string('file_path');
                $table->string('file_name');
                $table->text('comments')->nullable();
                $table->timestamp('submitted_at');
                $table->boolean('is_late')->default(false);
                $table->integer('score')->nullable();
                $table->text('feedback')->nullable();
                $table->timestamp('graded_at')->nullable();
                $table->unsignedBigInteger('graded_by')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // Don't drop anything to avoid data loss
    }
};