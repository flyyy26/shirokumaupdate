<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'lokasi',
        'nama_kelas',
        'periode_bulan',
        'periode_tahun',
        'guru_id',
        'company_id',
        'job_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }
    public function sesi()
    {
        return $this->hasMany(KelasSesi::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}