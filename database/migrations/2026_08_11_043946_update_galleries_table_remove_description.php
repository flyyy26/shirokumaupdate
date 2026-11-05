<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('galleries', function (Blueprint $table) {
            // Hapus kolom description
            if (Schema::hasColumn('galleries', 'description')) {
                $table->dropColumn('description');
            }
            
            // Buat title nullable
            $table->string('title')->nullable()->change();
            
            // Buat image nullable
            $table->string('image')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('title')->nullable(false)->change();
            $table->string('image')->nullable(false)->change();
            $table->text('description')->nullable()->after('image');
        });
    }
};