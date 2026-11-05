<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_jp',      // 🔥 TAMBAHKAN
        'slug',
        'slug_jp',      // 🔥 TAMBAHKAN
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Relasi ke Gallery
     */
    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class, 'category_id');
    }

    /**
     * 🔥 METHOD UNTUK MENDAPATKAN NAMA BERDASARKAN BAHASA
     */
    public function getNameByLocale($locale = 'id')
    {
        if ($locale === 'jp' && $this->name_jp) {
            return $this->name_jp;
        }
        return $this->name;
    }

    public function getSlugByLocale($locale = 'id')
    {
        if ($locale === 'jp' && $this->slug_jp) {
            return $this->slug_jp;
        }
        return $this->slug;
    }
}