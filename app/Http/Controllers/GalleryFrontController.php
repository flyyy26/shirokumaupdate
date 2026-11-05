<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;

class GalleryFrontController extends Controller
{
    public function index()
    {
        $locale = 'id';
        
        // 🔥 SORT BY CREATED_AT DESC (TERBARU DI ATAS)
        $galleries = Gallery::with('category')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')  // 🔥 Perubahan: asc → desc
            ->get();

        $categories = GalleryCategory::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('gallery', compact('galleries', 'categories', 'locale'));
    }
    
    public function indexJP()
    {
        $locale = 'jp';
        
        // 🔥 SORT BY CREATED_AT DESC (TERBARU DI ATAS)
        $galleries = Gallery::with('category')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')  // 🔥 Perubahan: asc → desc
            ->get();

        $categories = GalleryCategory::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('gallery-jp', compact('galleries', 'categories', 'locale'));
    }
}