<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'program',
        'no_hp',
        'email',
        'alamat_lengkap',
        'catatan',
    ];

    // Accessor untuk format tanggal
    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format('d M Y H:i');
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $keyword)
    {
        return $query->where('nama_lengkap', 'LIKE', "%{$keyword}%")
                     ->orWhere('program', 'LIKE', "%{$keyword}%")
                     ->orWhere('email', 'LIKE', "%{$keyword}%")
                     ->orWhere('no_hp', 'LIKE', "%{$keyword}%");
    }
}