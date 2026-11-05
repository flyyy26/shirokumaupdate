<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keberangkatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'tanggal_berangkat',
        'bandara_asal',
        'bandara_tujuan',
        'maskapai',
        'nomor_penerbangan',
        'jam_keberangkatan',
        'keterangan'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}