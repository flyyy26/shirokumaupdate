<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPekerjaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'nama_perusahaan',
        'nama_pekerjaan',
        'nama_pekerjaan_katakana',
        'tempat_bekerja',
        'pengalaman_jepang',
        'gaji_perbulan',
        'tahun_mulai',
        'bulan_mulai',
        'tahun_selesai',
        'bulan_selesai',
        'deskripsi_pekerjaan',
    ];
}
