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
        Schema::table('siswas', function (Blueprint $table) {

            // Akte
            $table->string('dokumen_akte')->nullable();

            // KTP
            $table->string('dokumen_ktp')->nullable();

            // Paspor
            $table->string('nomor_paspor')->nullable();
            $table->date('tanggal_pembuatan_paspor')->nullable();
            $table->date('tanggal_keluar_paspor')->nullable();
            $table->string('dokumen_paspor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            //
        });
    }
};
