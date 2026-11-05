<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('faq_categories', function (Blueprint $table) {
            // Hapus kolom yang tidak perlu
            if (Schema::hasColumn('faq_categories', 'color')) {
                $table->dropColumn('color');
            }
            if (Schema::hasColumn('faq_categories', 'icon')) {
                $table->dropColumn('icon');
            }
        });
    }

    public function down()
    {
        Schema::table('faq_categories', function (Blueprint $table) {
            $table->string('color')->default('teal')->nullable();
            $table->string('icon')->nullable();
        });
    }
};