<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained()->onDelete('cascade');
            $table->foreignId('kelas_sesi_id')->constrained()->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status', ['hadir','izin','sakit','alfa'])->default('hadir');
            $table->timestamps();

            $table->unique(['kelas_sesi_id','siswa_id','tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
