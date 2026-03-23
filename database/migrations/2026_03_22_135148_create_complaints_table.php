<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique();
            $table->string('complainant_type'); // student, staff, parent, other
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('student_id')->nullable(); // if student
            $table->string('staff_id')->nullable(); // if staff
            $table->string('department')->nullable();
            $table->string('year')->nullable(); // if student
            $table->string('category'); // academic, administrative, facilities, harassment, discrimination, other
            $table->string('sub_category')->nullable();
            $table->text('subject');
            $table->text('description');
            $table->text('attachment')->nullable();
            $table->string('priority')->default('medium'); // low, medium, high, urgent
            $table->string('status')->default('pending'); // pending, reviewing, resolved, rejected, escalated
            $table->text('admin_response')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            
            $table->index('reference_no');
            $table->index('email');
            $table->index('status');
            $table->index('priority');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};