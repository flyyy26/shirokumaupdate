<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Guru extends Model
{
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nama_panggilan',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_hp',
        'alamat',
        'level_diampu',
        'status',
        'foto'
    ];

    // Hitung usia otomatis
    public function getUsiaAttribute()
    {
        return Carbon::parse($this->tanggal_lahir)->age;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}