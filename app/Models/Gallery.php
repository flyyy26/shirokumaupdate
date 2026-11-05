<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'image',
        'video_url', // 🔥 TAMBAHKAN
        'type', // 🔥 TAMBAHKAN: 'image' atau 'video'
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Relation to category
    public function category(): BelongsTo
    {
        return $this->belongsTo(GalleryCategory::class, 'category_id');
    }

    // Accessor for category name
    public function getCategoryNameAttribute()
    {
        return $this->category?->name ?? 'Tanpa Kategori';
    }

    // Accessor for category color
    public function getCategoryColorAttribute()
    {
        return $this->category?->color ?? 'gray';
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getCategoryLabelAttribute()
    {
        return $this->category?->name ?? 'Tanpa Kategori';
    }

    // 🔥 GET YOUTUBE EMBED URL
    public function getYoutubeEmbedUrlAttribute()
    {
        if (!$this->video_url) return null;
        
        // Extract video ID dari berbagai format URL YouTube
        $videoId = $this->extractYoutubeId($this->video_url);
        
        if ($videoId) {
            return 'https://www.youtube.com/embed/' . $videoId;
        }
        
        return null;
    }

    // 🔥 GET YOUTUBE THUMBNAIL
    public function getYoutubeThumbnailAttribute()
    {
        if (!$this->video_url) return null;
        
        $videoId = $this->extractYoutubeId($this->video_url);
        
        if ($videoId) {
            return 'https://img.youtube.com/vi/' . $videoId . '/hqdefault.jpg';
        }
        
        return null;
    }

    // 🔥 EXTRACT YOUTUBE ID
    private function extractYoutubeId($url)
    {
        $patterns = [
            '/(?:youtube\.com\/watch\?v=)([a-zA-Z0-9_-]{11})/',
            '/(?:youtu\.be\/)([a-zA-Z0-9_-]{11})/',
            '/(?:youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/',
            '/(?:youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/',
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }
        
        return null;
    }

    // 🔥 CEK APAKAH VIDEO
    public function getIsVideoAttribute()
    {
        return $this->type === 'video' && !empty($this->video_url);
    }

    // 🔥 CEK APAKAH IMAGE
    public function getIsImageAttribute()
    {
        return $this->type === 'image' || empty($this->video_url);
    }
}