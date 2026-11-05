<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('pendaftarans', function (Blueprint $table) {
        $table->string('bukti_pembayaran')->nullable()->after('berat_badan');
    });
}

public function down()
{
    Schema::table('pendaftarans', function (Blueprint $table) {
        $table->dropColumn('bukti_pembayaran');
    });
}
};