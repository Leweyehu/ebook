<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('year');
            $table->string('section')->nullable();
            $table->string('batch');
            $table->string('department')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('bio')->nullable();
            $table->text('achievements')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('student_id');
            $table->index('email');
            $table->index('year');
            $table->index('batch');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};