<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('company');
            $table->string('location')->nullable();
            $table->string('job_type')->default('full-time'); // full-time, part-time, internship, remote
            $table->text('description');
            $table->text('requirements');
            $table->text('benefits')->nullable();
            $table->string('contact_email');
            $table->string('application_link')->nullable();
            $table->date('deadline');
            $table->boolean('is_active')->default(true);
            $table->integer('views')->default(0);
            $table->timestamps();
            
            $table->index('is_active');
            $table->index('deadline');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_jobs');
    }
};