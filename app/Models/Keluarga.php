<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    protected $fillable = [
        'siswa_id',
        'hubungan_keluarga',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_tinggal',
        'pekerjaan',
        'no_telepon',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
