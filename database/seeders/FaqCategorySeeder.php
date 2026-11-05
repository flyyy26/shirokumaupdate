<?php

namespace Database\Seeders;

use App\Models\FaqCategory;
use Illuminate\Database\Seeder;

class FaqCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Umum', 'slug' => 'umum', 'color' => 'blue', 'icon' => 'mdi:help-circle', 'sort_order' => 1],
            ['name' => 'Produk', 'slug' => 'produk', 'color' => 'green', 'icon' => 'mdi:package-variant', 'sort_order' => 2],
            ['name' => 'Pembayaran', 'slug' => 'pembayaran', 'color' => 'yellow', 'icon' => 'mdi:credit-card', 'sort_order' => 3],
            ['name' => 'Pengiriman', 'slug' => 'pengiriman', 'color' => 'purple', 'icon' => 'mdi:truck-delivery', 'sort_order' => 4],
            ['name' => 'Retur & Garansi', 'slug' => 'retur', 'color' => 'red', 'icon' => 'mdi:return', 'sort_order' => 5],
            ['name' => 'Akun', 'slug' => 'akun', 'color' => 'teal', 'icon' => 'mdi:account', 'sort_order' => 6],
            ['name' => 'Lainnya', 'slug' => 'lainnya', 'color' => 'gray', 'icon' => 'mdi:dots-horizontal', 'sort_order' => 7],
        ];

        foreach ($categories as $cat) {
            FaqCategory::create($cat);
        }
    }
}