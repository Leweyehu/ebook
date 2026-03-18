<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('staff', 'order')) {
            Schema::table('staff', function (Blueprint $table) {
                $table->integer('order')->default(0)->after('staff_type');
            });
        }
    }

    public function down(): void
    {
        // Optional: only drop if you want to
    }
};