<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('galleries', function (Blueprint $table) {
            // Drop old category column if exists
            if (Schema::hasColumn('galleries', 'category')) {
                $table->dropColumn('category');
            }
            
            // Add category_id foreign key
            $table->foreignId('category_id')
                  ->after('title')
                  ->constrained('gallery_categories')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            $table->string('category')->nullable()->after('title');
        });
    }
};