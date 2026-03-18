<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseHelper
{
    public static function getCourseNoticesCount()
    {
        if (Schema::hasTable('course_notices')) {
            try {
                return DB::table('course_notices')->where('is_active', true)->count();
            } catch (\Exception $e) {
                return 0;
            }
        }
        return 0;
    }

    public static function getPendingGradingCount()
    {
        if (Schema::hasTable('assignment_submissions')) {
            try {
                return DB::table('assignment_submissions')->whereNull('score')->count();
            } catch (\Exception $e) {
                return 0;
            }
        }
        return 0;
    }
}