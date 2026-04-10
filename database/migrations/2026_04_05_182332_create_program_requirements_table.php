<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('program_requirements', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->integer('number_of_courses');
            $table->integer('credit_hours');
            $table->integer('ects');
            $table->integer('order_position')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('program_requirements');
    }
};