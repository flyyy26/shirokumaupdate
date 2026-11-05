<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'message',
        'is_read',
        'is_replied',
        'read_at',
        'replied_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_replied' => 'boolean',
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public function markAsReplied()
    {
        $this->update([
            'is_replied' => true,
            'replied_at' => now(),
        ]);
    }
}