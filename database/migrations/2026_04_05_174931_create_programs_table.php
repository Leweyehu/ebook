<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['undergraduate', 'postgraduate'])->default('undergraduate');
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->json('career_opportunities')->nullable();
            $table->json('specializations')->nullable();
            $table->integer('duration_years')->nullable();
            $table->string('duration_text')->nullable();
            $table->string('mode_of_delivery')->nullable();
            $table->string('teaching_method')->nullable();
            $table->integer('credit_hours')->nullable();
            $table->integer('ects')->nullable();
            $table->integer('semesters')->nullable();
            $table->integer('order_position')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('programs');
    }
};