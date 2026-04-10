<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_structures', function (Blueprint $table) {
            $table->id();
            $table->integer('year'); // 1, 2, 3, 4
            $table->integer('semester'); // 1, 2
            $table->string('course_code');
            $table->string('course_name');
            $table->integer('ects');
            $table->integer('credit_hours');
            $table->text('description')->nullable();
            $table->boolean('is_elective')->default(false);
            $table->string('status')->default('active');
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->index('year');
            $table->index('semester');
            $table->index('course_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_structures');
    }
};