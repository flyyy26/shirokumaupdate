<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('category')
            ->latest()
            ->paginate(20);
        
        $categories = GalleryCategory::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();
            
        return view('admin.gallery.index', compact('galleries', 'categories'));
    }
    
    // 🔥 STORE UNTUK IMAGE
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:gallery_categories,id',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'titles' => 'nullable|array',
            'titles.*' => 'nullable|string|max:255',
        ]);

        $uploadedCount = 0;
        $maxOrder = Gallery::max('sort_order') ?? 0;

        foreach ($request->file('images') as $index => $image) {
            $imagePath = $image->store('gallery', 'public');
            $title = $request->titles[$index] ?? 'Foto Galeri';

            Gallery::create([
                'title' => $title,
                'category_id' => $request->category_id,
                'image' => $imagePath,
                'type' => 'image',
                'sort_order' => $maxOrder + $index + 1,
                'is_active' => $request->has('is_active'),
            ]);

            $uploadedCount++;
        }

        return response()->json([
            'success' => true,
            'message' => $uploadedCount . ' foto berhasil ditambahkan'
        ]);
    }

    // 🔥 STORE UNTUK VIDEO
    public function storeVideo(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:gallery_categories,id',
            'video_url' => 'required|url|max:255',
            'title' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $maxOrder = Gallery::max('sort_order') ?? 0;

        $gallery = Gallery::create([
            'title' => $request->title ?? 'Video Galeri',
            'category_id' => $request->category_id,
            'video_url' => $request->video_url,
            'type' => 'video',
            'sort_order' => $maxOrder + 1,
            'is_active' => $request->has('is_active'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Video berhasil ditambahkan',
            'data' => $gallery
        ]);
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'category_id' => 'required|exists:gallery_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'title' => $request->title ?? 'Foto Galeri',
            'category_id' => $request->category_id,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }
            $data['image'] = $request->file('image')->store('gallery', 'public');
            $data['type'] = 'image';
        }

        $gallery->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil diperbarui'
        ]);
    }

    // 🔥 UPDATE VIDEO
    public function updateVideo(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'category_id' => 'required|exists:gallery_categories,id',
            'video_url' => 'required|url|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $gallery->update([
            'title' => $request->title ?? 'Video Galeri',
            'category_id' => $request->category_id,
            'video_url' => $request->video_url,
            'is_active' => $request->has('is_active'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Video berhasil diperbarui'
        ]);
    }

    public function destroy(Gallery $gallery)
    {
        try {
            Log::info('Delete Gallery:', [
                'id' => $gallery->id,
                'image' => $gallery->image,
                'type' => $gallery->type,
            ]);

            // Hapus file gambar jika ada
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }

            $gallery->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Delete Gallery Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:galleries,id',
            'orders.*.sort_order' => 'required|integer',
        ]);

        foreach ($request->orders as $order) {
            Gallery::where('id', $order['id'])->update(['sort_order' => $order['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan berhasil diperbarui'
        ]);
    }

    public function toggleActive(Gallery $gallery)
    {
        $gallery->update(['is_active' => !$gallery->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui',
            'is_active' => $gallery->is_active
        ]);
    }

    public function loadMore(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 20;
        $category = $request->get('category', 'all');

        $query = Gallery::with('category');

        $query->orderBy('created_at', 'desc');

        if ($category !== 'all') {
            $query->whereHas('category', function($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        $galleries = $query->paginate($perPage, ['*'], 'page', $page);

        $html = '';
        foreach ($galleries as $gallery) {
            $html .= view('admin.gallery._item', compact('gallery'))->render();
        }

        return response()->json([
            'success' => true,
            'html' => $html,
            'hasMore' => $galleries->hasMorePages(),
            'currentPage' => $galleries->currentPage(),
            'total' => $galleries->total(),
        ]);
    }
}