<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('riwayat_pekerjaans', function (Blueprint $table) {

            $table->decimal('gaji_perbulan', 15, 2)->nullable()->after('pengalaman_jepang');

            $table->year('tahun_mulai')->nullable();
            $table->string('bulan_mulai')->nullable();

            $table->year('tahun_selesai')->nullable();
            $table->string('bulan_selesai')->nullable();

            $table->text('deskripsi_pekerjaan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_pekerjaans', function (Blueprint $table) {
            //
        });
    }
};
