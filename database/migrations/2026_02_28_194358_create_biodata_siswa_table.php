<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('biodata_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');

            $table->string('level_bahasa_jepang')->nullable();
            $table->string('rencana_lama_di_jepang')->nullable();
            $table->string('periode_mulai')->nullable();

            $table->string('nik')->nullable();
            $table->string('nomor_paspor')->nullable();
            $table->date('tanggal_pembuatan_paspor')->nullable();
            $table->date('tanggal_paspor_dikeluarkan')->nullable();
            $table->string('wilayah_alamat')->nullable();
            $table->integer('tinggi_badan')->nullable();
            $table->integer('berat_badan')->nullable();
            $table->string('tangan_dominan')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->string('buta_warna')->nullable();
            $table->string('alergi')->nullable();
            $table->string('merokok')->nullable();
            $table->string('peminum_alkohol')->nullable();
            $table->string('tatto')->nullable();
            $table->string('gigi_berlubang')->nullable();
            $table->string('riwayat_penyakit')->nullable();
            $table->string('kacamata')->nullable();
            $table->string('kondisi_mata_kiri')->nullable();
            $table->string('kondisi_mata_kanan')->nullable();
            $table->string('status_perkawinan')->nullable();
            $table->integer('jumlah_anak')->nullable();
            $table->text('hobi')->nullable();
            $table->text('keunggulan_diri')->nullable();
            $table->text('kekurangan_diri')->nullable();
            $table->text('dokumen')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('biodata_siswa');
    }
};