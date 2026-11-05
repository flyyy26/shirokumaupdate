<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');

            // Info Job
            $table->string('jenis_pekerjaan');
            $table->string('jenis_ginou');
            $table->integer('kuota')->nullable();
            $table->date('tanggal_interview')->nullable();

            // Gaji & tipe
            $table->decimal('gaji_pokok', 12, 2)->nullable();
            $table->enum('tipe_gaji',['jam','bulan'])->default('bulan');

            // Lembur
            $table->boolean('lembur')->default(false);
            $table->integer('estimasi_lembur_jam')->nullable();

            // Kontrak, lokasi, fasilitas, deskripsi
            $table->integer('kontrak_tahun')->nullable();
            $table->string('lokasi_kerja')->nullable();
            $table->string('fasilitas')->nullable();
            $table->text('deskripsi')->nullable();

            // Status Job
            $table->enum('status',['Draft','Interview','Close'])->default('Draft');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};