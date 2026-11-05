<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasSesi extends Model
{
    protected $fillable = [
        'kelas_id',
        'nama_sesi',
        'jam_mulai',
        'jam_selesai',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
