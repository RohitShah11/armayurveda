<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const IMAGE_PATH = 'images/zenith-package.jpeg';

    public function up(): void
    {
        if (! Schema::hasTable('packages') || ! Schema::hasColumn('packages', 'image')) {
            return;
        }

        DB::table('packages')
            ->where('slug', 'zenith-package')
            ->update(['image' => self::IMAGE_PATH]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('packages') || ! Schema::hasColumn('packages', 'image')) {
            return;
        }

        DB::table('packages')
            ->where('slug', 'zenith-package')
            ->where('image', self::IMAGE_PATH)
            ->update(['image' => null]);
    }
};
