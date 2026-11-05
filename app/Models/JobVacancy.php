<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class JobVacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'requirements',
        'position_type',
        'location',
        'salary',
        'deadline',
        'gender',
        'min_age',
        'max_age',
        'education',
        'image',
        'sort_order',
        'is_active',
        'is_featured',
    ];

    protected $appends = ['image_url'];

    protected $casts = [
        'requirements' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'deadline' => 'date',
    ];

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($job) {
            $job->slug = Str::slug($job->title) . '-' . time();
        });
    }

    // Accessor for requirements as array
    public function getRequirementsListAttribute()
    {
        return $this->requirements ? json_decode($this->requirements, true) : [];
    }

    // Accessor for image URL
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    // Check if deadline is expired
    public function getIsExpiredAttribute()
    {
        return $this->deadline && $this->deadline->isPast();
    }

    // Get deadline formatted
    public function getDeadlineFormattedAttribute()
    {
        return $this->deadline ? $this->deadline->format('d M Y') : '-';
    }

    // Get deadline for display (s/d 30 November 2025)
    public function getDeadlineDisplayAttribute()
    {
        return $this->deadline ? 's/d ' . $this->deadline->format('d F Y') : '-';
    }
}