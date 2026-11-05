<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryCategoryController extends Controller
{
    public function index()
    {
        $categories = GalleryCategory::withCount('galleries')
            ->orderBy('sort_order', 'asc')
            ->get();
            
        return view('admin.gallery.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:gallery_categories',
            'name_jp' => 'nullable|string|max:100',
        ]);

        $category = GalleryCategory::create([
            'name' => $request->name,
            'name_jp' => $request->name_jp,
            'slug' => Str::slug($request->name),
            'slug_jp' => $request->name_jp ? Str::slug($request->name_jp) : null,
            'sort_order' => GalleryCategory::max('sort_order') + 1,
            'is_active' => $request->has('is_active'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan',
            'category' => $category
        ]);
    }

    public function update(Request $request, GalleryCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:gallery_categories,name,' . $category->id,
            'name_jp' => 'nullable|string|max:100',
        ]);

        $category->update([
            'name' => $request->name,
            'name_jp' => $request->name_jp,
            'slug' => Str::slug($request->name),
            'slug_jp' => $request->name_jp ? Str::slug($request->name_jp) : null,
            'is_active' => $request->has('is_active'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui',
            'category' => $category
        ]);
    }

    public function destroy(GalleryCategory $category)
    {
        try {
            $galleryCount = $category->galleries()->count();
            
            if ($galleryCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori tidak dapat dihapus karena masih memiliki ' . $galleryCount . ' foto. Pindahkan atau hapus foto terlebih dahulu.'
                ], 400);
            }

            $categoryName = $category->name;
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kategori "' . $categoryName . '" berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kategori: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:gallery_categories,id',
            'orders.*.sort_order' => 'required|integer',
        ]);

        foreach ($request->orders as $order) {
            GalleryCategory::where('id', $order['id'])->update(['sort_order' => $order['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan kategori berhasil diperbarui'
        ]);
    }

    public function toggleActive(GalleryCategory $category)
    {
        $category->update(['is_active' => !$category->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status kategori berhasil diperbarui',
            'is_active' => $category->is_active
        ]);
    }
}