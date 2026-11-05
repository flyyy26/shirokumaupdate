<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('faqs', function (Blueprint $table) {
            // Hapus kolom category lama jika ada
            if (Schema::hasColumn('faqs', 'category')) {
                $table->dropColumn('category');
            }
            
            // Tambahkan category_id foreign key
            $table->foreignId('category_id')
                  ->nullable()
                  ->after('question')
                  ->constrained('faq_categories')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            $table->string('category')->nullable();
        });
    }
};