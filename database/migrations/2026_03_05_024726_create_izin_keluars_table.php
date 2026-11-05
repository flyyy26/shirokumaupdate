<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('izin_keluars', function (Blueprint $table) {
            $table->id();

            $table->foreignId('siswa_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->text('alasan');
            $table->string('yang_menemani')->nullable();
            $table->string('alamat_tujuan');

            $table->date('tanggal_keluar');
            $table->time('jam_keluar');

            $table->date('tanggal_kembali');
            $table->time('jam_kembali');

            $table->enum('status', ['menunggu','disetujui','ditolak'])
                ->default('menunggu');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('izin_keluars');
    }
};