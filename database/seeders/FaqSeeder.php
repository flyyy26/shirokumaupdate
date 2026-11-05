<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run()
    {
        $faqs = [
            [
                'question' => 'Apa itu LPK SHIROKUMA?',
                'answer' => 'LPK SHIROKUMA adalah Lembaga Pelatihan Kerja yang bergerak di bidang pelatihan keterampilan bahasa Jepang dan persiapan magang ke Jepang. Kami telah berpengalaman sejak tahun 2020 dan telah meluluskan ratusan peserta yang berhasil magang di Jepang.',
                'category' => 'umum',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Di mana lokasi LPK SHIROKUMA?',
                'answer' => 'Kami berlokasi di Perum Winayajaya Blok A.26, RT.002/RW.003 Kelurahan Sambongjaya, Kecamatan Mangkubumi, Kota Tasikmalaya, Jawa Barat.',
                'category' => 'umum',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Apa saja program pelatihan yang tersedia?',
                'answer' => 'Kami menyediakan program pelatihan Bahasa Jepang, pelatihan keterampilan kerja, persiapan magang ke Jepang, dan konsultasi karir. Semua program dirancang untuk mempersiapkan peserta menghadapi dunia kerja di Jepang.',
                'category' => 'program',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}