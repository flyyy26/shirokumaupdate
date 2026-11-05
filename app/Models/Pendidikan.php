<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'jenjang_pendidikan',
        'nama_sekolah',
        'jurusan',
        'tahun_masuk',
        'bulan_masuk',
        'tanggal_lulus',
        'dokumen_ijazah',
    ];
}
