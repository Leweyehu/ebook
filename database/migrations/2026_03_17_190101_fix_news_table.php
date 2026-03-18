<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('news')) {
            Schema::create('news', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('content');
                $table->string('featured_image')->nullable();
                $table->enum('category', ['news', 'event', 'announcement'])->default('news');
                $table->date('event_date')->nullable();
                $table->string('event_location')->nullable();
                $table->boolean('is_published')->default(true);
                $table->integer('views')->default(0);
                $table->unsignedBigInteger('created_by');
                $table->timestamps();
                
                $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};