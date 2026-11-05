<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'question_jp',
        'answer',
        'answer_jp',
        'category_id',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(FaqCategory::class, 'category_id');
    }

    public function getCategoryNameAttribute()
    {
        return $this->category?->name ?? 'Tanpa Kategori';
    }

    // 🔥 TAMBAHKAN ACCESSOR UNTUK NAMA KATEGORI BAHASA JEPANG
    public function getCategoryNameJpAttribute()
    {
        return $this->category?->name_jp ?? $this->category?->name ?? 'その他';
    }

    public function getCategoryColorAttribute()
    {
        return $this->category?->color ?? 'gray';
    }

    public function getCategoryLabelAttribute()
    {
        return $this->category?->name ?? 'Tanpa Kategori';
    }

    // 🔥 TAMBAHKAN METHOD UNTUK MENDAPATKAN KATEGORI BERDASARKAN LOKAL
    public function getCategoryNameByLocale($locale = 'id')
    {
        if (!$this->category) {
            return $locale === 'jp' ? 'その他' : 'Tanpa Kategori';
        }
        return $this->category->getNameByLocale($locale);
    }
}