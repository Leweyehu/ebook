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
            
            // Add category column if it doesn't exist
            if (!in_array('category', $columns)) {
                $table->enum('category', ['news', 'event', 'announcement'])->default('news');
            }
            
            // Add event_date column if it doesn't exist
            if (!in_array('event_date', $columns)) {
                $table->date('event_date')->nullable();
            }
            
            // Add event_location column if it doesn't exist
            if (!in_array('event_location', $columns)) {
                $table->string('event_location')->nullable();
            }
            
            // Add is_published column if it doesn't exist (just in case)
            if (!in_array('is_published', $columns)) {
                $table->boolean('is_published')->default(true);
            }
            
            // Add views column if it doesn't exist
            if (!in_array('views', $columns)) {
                $table->integer('views')->default(0);
            }
            
            // Add created_by column if it doesn't exist
            if (!in_array('created_by', $columns)) {
                $table->foreignId('created_by')->nullable()->constrained('users');
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
            
            if (in_array('category', $columns)) {
                $table->dropColumn('category');
            }
            
            if (in_array('event_date', $columns)) {
                $table->dropColumn('event_date');
            }
            
            if (in_array('event_location', $columns)) {
                $table->dropColumn('event_location');
            }
            
            if (in_array('is_published', $columns)) {
                $table->dropColumn('is_published');
            }
            
            if (in_array('views', $columns)) {
                $table->dropColumn('views');
            }
            
            if (in_array('created_by', $columns)) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            }
        });
    }
};