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
        Schema::create('pendidikans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');

            $table->string('jenjang_pendidikan');
            $table->string('nama_sekolah');
            $table->string('jurusan')->nullable();
            $table->year('tahun_masuk')->nullable();
            $table->string('bulan_masuk')->nullable();
            $table->date('tanggal_lulus')->nullable();
            $table->string('dokumen_ijazah')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendidikans');
    }
};
