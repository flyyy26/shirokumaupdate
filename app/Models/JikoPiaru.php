<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JikoPiaru extends Model
{
    protected $fillable = [
        'siswa_id',
        'content_jp',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}