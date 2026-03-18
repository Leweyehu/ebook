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
            
            // Check and add title column
            if (!in_array('title', $columns)) {
                $table->string('title')->after('id');
            }
            
            // Check and add slug column
            if (!in_array('slug', $columns)) {
                $table->string('slug')->unique()->after('title');
            }
            
            // Check and add content column
            if (!in_array('content', $columns)) {
                $table->text('content')->after('slug');
            }
            
            // Check and add category column
            if (!in_array('category', $columns)) {
                $table->string('category')->default('news')->after('content');
            }
            
            // Check and add event_date column
            if (!in_array('event_date', $columns)) {
                $table->date('event_date')->nullable()->after('category');
            }
            
            // Check and add event_location column
            if (!in_array('event_location', $columns)) {
                $table->string('event_location')->nullable()->after('event_date');
            }
            
            // Check and add featured_image column
            if (!in_array('featured_image', $columns)) {
                $table->string('featured_image')->nullable()->after('event_location');
            }
            
            // Check and add is_published column
            if (!in_array('is_published', $columns)) {
                $table->boolean('is_published')->default(true)->after('featured_image');
            }
            
            // Check and add views column
            if (!in_array('views', $columns)) {
                $table->integer('views')->default(0)->after('is_published');
            }
            
            // Check and add created_by column
            if (!in_array('created_by', $columns)) {
                $table->unsignedBigInteger('created_by')->nullable()->after('views');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            }
            
            // Check and add timestamps
            if (!in_array('created_at', $columns)) {
                $table->timestamps();
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
            
            $dropColumns = [];
            
            if (in_array('title', $columns)) $dropColumns[] = 'title';
            if (in_array('slug', $columns)) $dropColumns[] = 'slug';
            if (in_array('content', $columns)) $dropColumns[] = 'content';
            if (in_array('category', $columns)) $dropColumns[] = 'category';
            if (in_array('event_date', $columns)) $dropColumns[] = 'event_date';
            if (in_array('event_location', $columns)) $dropColumns[] = 'event_location';
            if (in_array('featured_image', $columns)) $dropColumns[] = 'featured_image';
            if (in_array('is_published', $columns)) $dropColumns[] = 'is_published';
            if (in_array('views', $columns)) $dropColumns[] = 'views';
            
            if (!empty($dropColumns)) {
                $table->dropColumn($dropColumns);
            }
            
            if (in_array('created_by', $columns)) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            }
        });
    }
};