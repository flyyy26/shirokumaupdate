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
        Schema::table('biodata_siswa', function (Blueprint $blueprint) {
            // patah_tulang biasanya berisi "Pernah" atau "Tidak Pernah"
            $blueprint->string('patah_tulang')->nullable()->after('riwayat_penyakit'); 
            
            // ukuran_sepatu dan pinggang disimpan sebagai string agar fleksibel (misal: "26" atau "26.5")
            $blueprint->string('ukuran_sepatu')->nullable()->after('patah_tulang');
            $blueprint->string('ukuran_pinggang')->nullable()->after('ukuran_sepatu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biodata_siswa', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['patah_tulang', 'ukuran_sepatu', 'ukuran_pinggang']);
        });
    }
};