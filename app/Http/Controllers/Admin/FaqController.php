<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::with('category')->orderBy('sort_order', 'asc')->paginate(20);
        
        // 🔥 AMBIL KATEGORI DARI DATABASE
        $categories = FaqCategory::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();
            
        return view('admin.faq.index', compact('faqs', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category_id' => 'nullable|exists:faq_categories,id',
            'question_jp' => 'nullable|string|max:255',
            'answer_jp' => 'nullable|string',
        ]);

        $maxOrder = Faq::max('sort_order') ?? 0;

        $faq = Faq::create([
            'question' => $request->question,
            'question_jp' => $request->question_jp,
            'answer' => $request->answer,
            'answer_jp' => $request->answer_jp,
            'category_id' => $request->category_id,
            'sort_order' => $maxOrder + 1,
            'is_active' => $request->has('is_active'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'FAQ berhasil ditambahkan',
            'faq' => $faq
        ]);
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category_id' => 'nullable|exists:faq_categories,id',
            'question_jp' => 'nullable|string|max:255',
            'answer_jp' => 'nullable|string',
        ]);

        $faq->update([
            'question' => $request->question,
            'question_jp' => $request->question_jp,
            'answer' => $request->answer,
            'answer_jp' => $request->answer_jp,
            'category_id' => $request->category_id,
            'is_active' => $request->has('is_active'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'FAQ berhasil diperbarui',
            'faq' => $faq
        ]);
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return response()->json([
            'success' => true,
            'message' => 'FAQ berhasil dihapus'
        ]);
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:faqs,id',
            'orders.*.sort_order' => 'required|integer',
        ]);

        foreach ($request->orders as $order) {
            Faq::where('id', $order['id'])->update(['sort_order' => $order['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan FAQ berhasil diperbarui'
        ]);
    }

    public function toggleActive(Faq $faq)
    {
        $faq->update(['is_active' => !$faq->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status FAQ berhasil diperbarui',
            'is_active' => $faq->is_active
        ]);
    }

    public function loadMore(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 20;
        $category = $request->get('category', 'all');

        $query = Faq::with('category')->orderBy('sort_order', 'asc');

        if ($category !== 'all') {
            $query->whereHas('category', function($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        $faqs = $query->paginate($perPage, ['*'], 'page', $page);

        $html = '';
        foreach ($faqs as $faq) {
            $html .= view('admin.faq._item', compact('faq'))->render();
        }

        return response()->json([
            'success' => true,
            'html' => $html,
            'hasMore' => $faqs->hasMorePages(),
            'currentPage' => $faqs->currentPage(),
            'total' => $faqs->total(),
        ]);
    }
}