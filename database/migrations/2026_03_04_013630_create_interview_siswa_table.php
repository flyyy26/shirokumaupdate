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
        Schema::create('interview_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_id')->constrained()->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained()->cascadeOnDelete();
            $table->enum('hasil', ['lulus','tidak_lulus'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interview_siswa');
    }
};
