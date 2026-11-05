<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewLog extends Model
{
    protected $fillable = [
        'siswa_id',
        'company_id',
        'job_id',
        'tanggal_interview',
        'hasil'
    ];

    protected $casts = [
        'tanggal_interview' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}