<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_perusahaan',
        'nama_jepang',
        'prefektur',
        'alamat',
        'nama_pic',
        'nama_pic_jepang',
        'jabatan_pic',
        'no_hp_pic',
        'email_pic',
        'website',
        'logo',
        'bidang_usaha',
    ];

    protected $casts = [
        'bidang_usaha' => 'array',
    ];

    /**
     * Relasi: satu perusahaan punya banyak job
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }
}