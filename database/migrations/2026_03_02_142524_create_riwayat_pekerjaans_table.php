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
        Schema::create('riwayat_pekerjaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');

            $table->string('nama_perusahaan');
            $table->string('nama_pekerjaan');
            $table->string('nama_pekerjaan_katakana')->nullable();

            $table->enum('tempat_bekerja', ['Indonesia', 'Jepang']);

            $table->string('pengalaman_jepang')->nullable(); 
            // magang, tokuteiginou, internship

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pekerjaans');
    }
};
