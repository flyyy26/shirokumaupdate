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
        Schema::create('kartu_keluargas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('siswa_id')
                ->constrained('siswas')
                ->onDelete('cascade');

            $table->string('nomor_kk')->unique();
            $table->text('alamat_keluarga');
            $table->text('alamat_keluarga_katakana')->nullable();

            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('desa');

            $table->string('rt_rw')->nullable();
            $table->date('tanggal_dikeluarkan');

            $table->string('nama_kepala_dinas');
            $table->string('nip_kepala_dinas');

            $table->string('foto_kk')->nullable();

            $table->boolean('ada_golongan_darah')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kartu_keluargas');
    }
};
