<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cs_courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_code')->unique();
            $table->string('course_title');
            $table->integer('ects');
            $table->decimal('credit_hours', 3, 1);
            $table->integer('lecture_hours')->default(0);
            $table->integer('lab_hours')->default(0);
            $table->integer('tutorial_hours')->default(0);
            $table->enum('category', ['compulsory', 'elective', 'supportive', 'common']);
            $table->integer('year');
            $table->integer('semester');
            $table->text('description')->nullable();
            $table->string('instructor')->nullable();
            $table->string('syllabus_path')->nullable();
            $table->string('image_path')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->json('additional_files')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Create course materials table for additional resources
        Schema::create('course_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cs_course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('file_path');
            $table->string('file_type');
            $table->integer('file_size')->nullable();
            $table->enum('material_type', ['syllabus', 'lecture_note', 'lab_manual', 'assignment', 'reference', 'image', 'other']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_materials');
        Schema::dropIfExists('cs_courses');
    }
};