<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class FaqCategoryController extends Controller
{
    public function index()
    {
        $categories = FaqCategory::withCount('faqs')
            ->orderBy('sort_order', 'asc')
            ->get();
            
        return view('admin.faq.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:100|unique:faq_categories',
                'name_jp' => 'nullable|string|max:100',
            ]);

            $category = FaqCategory::create([
                'name' => $request->name,
                'name_jp' => $request->name_jp,
                'slug' => Str::slug($request->name),
                'slug_jp' => $request->name_jp ? Str::slug($request->name_jp) : null,
                'sort_order' => FaqCategory::max('sort_order') + 1,
                'is_active' => $request->has('is_active'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori FAQ berhasil ditambahkan',
                'category' => $category
            ]);

        } catch (\Exception $e) {
            Log::error('Store Category Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan kategori: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, FaqCategory $category)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:100|unique:faq_categories,name,' . $category->id,
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
                'message' => 'Kategori FAQ berhasil diperbarui',
                'category' => $category
            ]);

        } catch (\Exception $e) {
            Log::error('Update Category Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui kategori: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(FaqCategory $category)
    {
        try {
            $faqCount = $category->faqs()->count();
            
            if ($faqCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori tidak dapat dihapus karena masih memiliki ' . $faqCount . ' FAQ.'
                ], 400);
            }

            $categoryName = $category->name;
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kategori "' . $categoryName . '" berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error('Delete Category Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kategori: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateOrder(Request $request)
    {
        try {
            $request->validate([
                'orders' => 'required|array',
                'orders.*.id' => 'required|exists:faq_categories,id',
                'orders.*.sort_order' => 'required|integer',
            ]);

            foreach ($request->orders as $order) {
                FaqCategory::where('id', $order['id'])->update(['sort_order' => $order['sort_order']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Urutan kategori FAQ berhasil diperbarui'
            ]);

        } catch (\Exception $e) {
            Log::error('Update Order Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui urutan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleActive(FaqCategory $category)
    {
        try {
            $category->update(['is_active' => !$category->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Status kategori FAQ berhasil diperbarui',
                'is_active' => $category->is_active
            ]);

        } catch (\Exception $e) {
            Log::error('Toggle Active Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage()
            ], 500);
        }
    }
}