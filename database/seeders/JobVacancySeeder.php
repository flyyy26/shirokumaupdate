<?php

namespace Database\Seeders;

use App\Models\JobVacancy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobVacancySeeder extends Seeder
{
    public function run()
    {
        $jobs = [
            [
                'title' => 'Scaffolding (Kumiai)',
                'description' => 'Lowongan pekerjaan sebagai Scaffolding (Perancah) di Jepang. Pekerjaan ini bertanggung jawab untuk pemasangan dan pembongkaran perancah bangunan di proyek konstruksi Jepang.',
                'requirements' => ['Pria', 'Usia 19 s/d 32 Tahun', 'SMA/K Sederajat', 'Tidak buta warna', 'Tinggi minimal 160 cm', 'Berat badan proporsional', 'Sehat jasmani dan rohani'],
                'position_type' => 'Full-time',
                'location' => 'Jepang (Tokyo, Osaka, Nagoya)',
                'salary' => 'Rp 18.000.000 - Rp 25.000.000/bulan',
                'deadline' => now()->addDays(60),
                'gender' => 'Pria',
                'min_age' => 19,
                'max_age' => 32,
                'education' => 'SMA/K',
                'sort_order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'Teknik Las (Welding)',
                'description' => 'Lowongan pekerjaan sebagai Teknik Las (Welder) di Jepang. Bertanggung jawab untuk pekerjaan pengelasan di industri manufaktur dan konstruksi Jepang.',
                'requirements' => ['Pria', 'Usia 19 s/d 30 Tahun', 'SMA/K Sederajat', 'Memiliki sertifikat las', 'Tidak buta warna', 'Sehat jasmani dan rohani'],
                'position_type' => 'Full-time',
                'location' => 'Jepang (Tokyo, Osaka, Nagoya)',
                'salary' => 'Rp 16.000.000 - Rp 22.000.000/bulan',
                'deadline' => now()->addDays(60),
                'gender' => 'Pria',
                'min_age' => 19,
                'max_age' => 30,
                'education' => 'SMA/K',
                'sort_order' => 2,
                'is_featured' => true,
            ],
            [
                'title' => 'Perawat Lansia (Kaigo)',
                'description' => 'Lowongan pekerjaan sebagai Perawat Lansia (Kaigo) di panti jompo Jepang. Bertanggung jawab untuk merawat dan membantu aktivitas sehari-hari lansia di Jepang.',
                'requirements' => ['Pria/Wanita', 'Usia 19 s/d 35 Tahun', 'SMA/K Sederajat', 'Memiliki pengalaman merawat lansia', 'Memiliki sertifikat Kaigo', 'Sehat jasmani dan rohani'],
                'position_type' => 'Full-time',
                'location' => 'Jepang (Tokyo, Osaka, Nagoya)',
                'salary' => 'Rp 14.000.000 - Rp 18.000.000/bulan',
                'deadline' => now()->addDays(60),
                'gender' => 'Semua',
                'min_age' => 19,
                'max_age' => 35,
                'education' => 'SMA/K',
                'sort_order' => 3,
                'is_featured' => true,
            ],
            // Tambahkan pekerjaan lain sesuai kebutuhan...
        ];

        foreach ($jobs as $job) {
            JobVacancy::create($job);
        }
    }
}