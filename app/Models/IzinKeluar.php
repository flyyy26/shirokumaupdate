<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzinKeluar extends Model
{
    protected $fillable = [
        'siswa_id',
        'alasan',
        'yang_menemani',
        'alamat_tujuan',
        'tanggal_keluar',
        'jam_keluar',
        'tanggal_kembali',
        'jam_kembali',
        'status'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}