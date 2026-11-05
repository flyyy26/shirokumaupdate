<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();

            $table->string('lokasi');
            $table->string('nama_kelas');

            $table->string('periode_bulan'); // contoh: Desember
            $table->year('periode_tahun');   // contoh: 2025

            $table->string('wali_kelas')->nullable();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('job_id')
                ->constrained('jobs')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};