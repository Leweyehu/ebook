<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('graduation_year');
            $table->string('degree');
            $table->string('current_job_title')->nullable();
            $table->string('current_company')->nullable();
            $table->string('location')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('website_url')->nullable();
            $table->text('bio')->nullable();
            $table->text('achievements')->nullable();
            $table->string('profile_image')->nullable();
            $table->boolean('show_in_directory')->default(true);
            $table->boolean('is_verified')->default(false);
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();
            
            $table->index('graduation_year');
            $table->index('email');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};