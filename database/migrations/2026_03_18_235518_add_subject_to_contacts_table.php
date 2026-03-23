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
        // Check if table exists before creating
        if (!Schema::hasTable('contacts')) {
            Schema::create('contacts', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email');
                $table->string('subject')->nullable();
                $table->text('message');
                $table->enum('status', ['read', 'unread'])->default('unread');
                $table->timestamps();
            });
        } else {
            // If table exists but missing subject column
            if (!Schema::hasColumn('contacts', 'subject')) {
                Schema::table('contacts', function (Blueprint $table) {
                    $table->string('subject')->nullable()->after('email');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};