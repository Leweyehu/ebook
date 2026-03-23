<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_code')->unique();
            $table->string('course_name');
            $table->string('slug')->unique();
            $table->integer('credit_hours');
            $table->integer('year_level'); // 1,2,3,4
            $table->string('semester'); // 1 or 2
            $table->text('description');
            $table->text('objectives')->nullable();
            $table->text('syllabus')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('instructor')->nullable();
            $table->string('prerequisites')->nullable();
            $table->integer('capacity')->default(60);
            $table->string('status')->default('active'); // active, inactive, archived
            $table->boolean('is_elective')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->index('course_code');
            $table->index('year_level');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};