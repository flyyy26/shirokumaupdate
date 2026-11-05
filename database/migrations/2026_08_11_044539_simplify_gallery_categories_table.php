<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('gallery_categories', function (Blueprint $table) {
            // Hapus kolom yang tidak perlu
            if (Schema::hasColumn('gallery_categories', 'icon')) {
                $table->dropColumn('icon');
            }
            if (Schema::hasColumn('gallery_categories', 'color')) {
                $table->dropColumn('color');
            }
            if (Schema::hasColumn('gallery_categories', 'description')) {
                $table->dropColumn('description');
            }
        });
    }

    public function down()
    {
        Schema::table('gallery_categories', function (Blueprint $table) {
            $table->string('icon')->nullable();
            $table->string('color')->default('blue');
            $table->text('description')->nullable();
        });
    }
};