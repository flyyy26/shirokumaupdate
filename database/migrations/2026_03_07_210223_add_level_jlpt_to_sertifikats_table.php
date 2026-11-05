<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            // Menambahkan field level bahasa Jepang
            $table->string('level_jlpt', 10)->nullable()->after('nama_sertifikat');
        });
    }

    public function down(): void
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->dropColumn('level_jlpt');
        });
    }
};