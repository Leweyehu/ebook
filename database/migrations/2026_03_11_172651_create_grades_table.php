<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
            
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('assignment_id')->references('id')->on('assignments')->onDelete('cascade');
            $table->foreign('graded_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};