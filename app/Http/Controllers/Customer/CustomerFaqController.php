<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class CustomerFaqController extends Controller
{
    public function index()
    {
        $locale = 'id';
        
        $faqs = Faq::with('category')
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $categories = FaqCategory::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $faqsWithoutCategory = $faqs->whereNull('category_id');

        return view('pertanyaan-umum', compact('faqs', 'categories', 'faqsWithoutCategory', 'locale'));
    }

    public function indexJP()
    {
        $locale = 'jp';
        
        $faqs = Faq::with('category')
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $categories = FaqCategory::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $faqsWithoutCategory = $faqs->whereNull('category_id');

        return view('pertanyaan-umum-jp', compact('faqs', 'categories', 'faqsWithoutCategory', 'locale'));
    }
}