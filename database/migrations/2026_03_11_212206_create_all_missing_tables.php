<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create course_notices table
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
            echo "✅ course_notices table created\n";
        } else {
            echo "⚠️ course_notices table already exists\n";
        }

        // Create grades table
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
            echo "✅ grades table created\n";
        } else {
            echo "⚠️ grades table already exists\n";
        }

        // Create course_student pivot table
        if (!Schema::hasTable('course_student')) {
            Schema::create('course_student', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('course_id');
                $table->unsignedBigInteger('student_id');
                $table->string('academic_year')->nullable();
                $table->enum('status', ['enrolled', 'completed', 'dropped'])->default('enrolled');
                $table->timestamps();
                
                $table->unique(['course_id', 'student_id']);
            });
            echo "✅ course_student table created\n";
        } else {
            echo "⚠️ course_student table already exists\n";
        }

        // Create assignment_submissions table
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
                
                $table->unique(['assignment_id', 'student_id']);
            });
            echo "✅ assignment_submissions table created\n";
        } else {
            echo "⚠️ assignment_submissions table already exists\n";
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
        Schema::dropIfExists('course_student');
        Schema::dropIfExists('grades');
        Schema::dropIfExists('course_notices');
    }
};