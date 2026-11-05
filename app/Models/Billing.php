<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $fillable = [
        'siswa_id',
        'judul',
        'nominal',
        'jatuh_tempo',
        'keterangan',
        'status',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}