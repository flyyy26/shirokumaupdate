<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('faq_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('color')->default('teal');
            $table->string('icon')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default categories
        $defaults = [
            ['name' => 'Umum', 'slug' => 'umum', 'color' => 'blue', 'icon' => 'mdi:help-circle'],
            ['name' => 'Produk', 'slug' => 'produk', 'color' => 'green', 'icon' => 'mdi:package-variant'],
            ['name' => 'Pembayaran', 'slug' => 'pembayaran', 'color' => 'yellow', 'icon' => 'mdi:credit-card'],
            ['name' => 'Pengiriman', 'slug' => 'pengiriman', 'color' => 'purple', 'icon' => 'mdi:truck-delivery'],
            ['name' => 'Retur & Garansi', 'slug' => 'retur', 'color' => 'red', 'icon' => 'mdi:return'],
            ['name' => 'Akun', 'slug' => 'akun', 'color' => 'teal', 'icon' => 'mdi:account'],
            ['name' => 'Lainnya', 'slug' => 'lainnya', 'color' => 'gray', 'icon' => 'mdi:dots-horizontal'],
        ];

        foreach ($defaults as $key => $cat) {
            $defaults[$key]['sort_order'] = $key + 1;
            $defaults[$key]['created_at'] = now();
            $defaults[$key]['updated_at'] = now();
        }

        DB::table('faq_categories')->insert($defaults);
    }

    public function down()
    {
        Schema::dropIfExists('faq_categories');
    }
};