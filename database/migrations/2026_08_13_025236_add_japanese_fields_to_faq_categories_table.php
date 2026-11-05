<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faq_categories', function (Blueprint $table) {
            // CEK DULU APAKAH KOLOM SUDAH ADA
            if (!Schema::hasColumn('faq_categories', 'name_jp')) {
                $table->string('name_jp', 100)->nullable()->after('name');
            }
            if (!Schema::hasColumn('faq_categories', 'slug_jp')) {
                $table->string('slug_jp', 100)->nullable()->after('slug');
            }
        });
    }

    public function down(): void
    {
        Schema::table('faq_categories', function (Blueprint $table) {
            $table->dropColumn(['name_jp', 'slug_jp']);
        });
    }
};