<?php
// database/migrations/xxxx_xx_xx_create_jiko_piarus_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jiko_piarus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
            $table->text('content_jp')->nullable(); // Konten dalam Bahasa Jepang
            $table->timestamps();
            
            // Index untuk performa
            $table->index('siswa_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jiko_piarus');
    }
};