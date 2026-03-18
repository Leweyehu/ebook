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
        Schema::table('news', function (Blueprint $table) {
            $columns = Schema::getColumnListing('news');
            
            // Add is_published if it doesn't exist
            if (!in_array('is_published', $columns)) {
                $table->boolean('is_published')->default(true);
            }
            
            // Check if event_location exists, if not add it too
            if (!in_array('event_location', $columns)) {
                $table->string('event_location')->nullable();
            }
            
            // Check if event_date exists
            if (!in_array('event_date', $columns)) {
                $table->date('event_date')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $columns = Schema::getColumnListing('news');
            
            if (in_array('is_published', $columns)) {
                $table->dropColumn('is_published');
            }
        });
    }
};