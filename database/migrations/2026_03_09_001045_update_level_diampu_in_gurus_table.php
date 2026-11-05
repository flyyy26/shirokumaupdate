<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Cara paling aman untuk mengubah ENUM di MySQL via Laravel
        DB::statement("ALTER TABLE gurus MODIFY COLUMN level_diampu ENUM('N1', 'N2', 'N3', 'N4', 'N5') NOT NULL");
    }

    public function down(): void
    {
        // Kembalikan ke pilihan awal jika diperlukan (hati-hati jika sudah ada data N1/N2)
        DB::statement("ALTER TABLE gurus MODIFY COLUMN level_diampu ENUM('N3', 'N4', 'N5') NOT NULL");
    }
};