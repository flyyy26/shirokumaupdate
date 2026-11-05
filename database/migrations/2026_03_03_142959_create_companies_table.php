<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->string('nama_jepang')->nullable();
            $table->string('prefektur')->nullable();
            $table->string('alamat')->nullable();

            // PIC
            $table->string('nama_pic')->nullable();
            $table->string('jabatan_pic')->nullable();
            $table->string('no_hp_pic')->nullable();
            $table->string('email_pic')->nullable();

            // Legal / Info Tambahan
            $table->string('website')->nullable();
            $table->enum('status_kerjasama', ['Active', 'Non Active'])->default('Active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};