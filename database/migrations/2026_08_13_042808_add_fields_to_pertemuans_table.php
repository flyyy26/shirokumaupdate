<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pertemuans', function (Blueprint $table) {
            // Tambahkan kolom baru
            if (!Schema::hasColumn('pertemuans', 'no_hp')) {
                $table->string('no_hp')->nullable()->after('program');
            }
            if (!Schema::hasColumn('pertemuans', 'email')) {
                $table->string('email')->nullable()->after('no_hp');
            }
            if (!Schema::hasColumn('pertemuans', 'catatan')) {
                $table->text('catatan')->nullable()->after('alamat_lengkap');
            }
        });
    }

    public function down()
    {
        Schema::table('pertemuans', function (Blueprint $table) {
            $table->dropColumn(['no_hp', 'email', 'catatan']);
        });
    }
};