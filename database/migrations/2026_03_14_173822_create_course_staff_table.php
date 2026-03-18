<?php
// database/migrations/[timestamp]_create_course_staff_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('staff_id');
            $table->enum('role', ['primary', 'assistant', 'guest'])->default('primary');
            $table->string('academic_year')->nullable();
            $table->timestamps();
            
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
            $table->unique(['course_id', 'staff_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_staff');
    }
};