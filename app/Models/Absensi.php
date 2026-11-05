<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'kelas_id',
        'kelas_sesi_id',
        'siswa_id',
        'tanggal',
        'status',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function sesi()
    {
        return $this->belongsTo(KelasSesi::class, 'kelas_sesi_id');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
