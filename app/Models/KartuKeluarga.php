<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuKeluarga extends Model
{
    protected $fillable = [
        'siswa_id',
        'nomor_kk',
        'alamat_keluarga',
        'alamat_keluarga_katakana',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'desa',
        'rt_rw',
        'tanggal_dikeluarkan',
        'nama_kepala_dinas',
        'nip_kepala_dinas',
        'foto_kk',
        'ada_golongan_darah',
    ];

    protected $casts = [
        'tanggal_dikeluarkan' => 'date',
        'ada_golongan_darah' => 'boolean',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}