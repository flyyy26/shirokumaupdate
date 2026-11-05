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
    Schema::create('interview_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('siswa_id')->constrained()->cascadeOnDelete();
        $table->foreignId('company_id')->constrained()->cascadeOnDelete();
        $table->foreignId('job_id')->constrained()->cascadeOnDelete();
        $table->date('tanggal_interview')->nullable();
        $table->enum('hasil', ['lulus','gagal'])->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_logs');
    }
};
