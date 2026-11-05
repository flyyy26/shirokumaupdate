<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'program',
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp',
        'pendidikan_terakhir',
        'pernah_belajar_jepang',
        'jurusan',
        'alamat',
        'tinggi_badan',
        'berat_badan',
        'bukti_pembayaran',
        'status',
    ];
}