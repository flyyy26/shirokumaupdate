<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('izin_keluars', function (Blueprint $table) {

            $table->foreignId('siswa_id')->constrained()->cascadeOnDelete();

            $table->text('alasan');
            $table->string('yang_menemani')->nullable();
            $table->string('alamat_tujuan');

            $table->date('tanggal_keluar');
            $table->time('jam_keluar');

            $table->date('tanggal_kembali');
            $table->time('jam_kembali');

            $table->enum('status', ['menunggu','disetujui','ditolak'])
                ->default('menunggu');
        });
    }

    public function down()
    {
        Schema::table('izin_keluars', function (Blueprint $table) {

            $table->dropColumn([
                'alasan',
                'yang_menemani',
                'alamat_tujuan',
                'tanggal_keluar',
                'jam_keluar',
                'tanggal_kembali',
                'jam_kembali',
                'status'
            ]);
        });
    }
};