<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    protected $fillable = [
        'company_id',
        'job_id',
        'tanggal',
        'jenis_ginou',
        'lokasi'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function siswas()
    {
        return $this->belongsToMany(Siswa::class)
                    ->withPivot('hasil')
                    ->withTimestamps();
    }
}