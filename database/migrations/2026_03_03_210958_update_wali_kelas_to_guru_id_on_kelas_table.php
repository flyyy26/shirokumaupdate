<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelas', function (Blueprint $table) {

            // hapus kolom lama
            $table->dropColumn('wali_kelas');

            // tambah kolom baru
            $table->foreignId('guru_id')
                ->nullable()
                ->after('periode_tahun')
                ->constrained('gurus')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {

            $table->dropForeign(['guru_id']);
            $table->dropColumn('guru_id');

            $table->string('wali_kelas')->nullable();
        });
    }
};