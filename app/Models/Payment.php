<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'billing_id',
        'nama_bank',
        'nomor_rekening',
        'bukti_pembayaran',
    ];

    public function billing()
    {
        return $this->belongsTo(Billing::class);
    }
}