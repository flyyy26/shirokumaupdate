@extends('layouts_front.app')

@section('content_front')

{{-- Banner --}}
<div class="banner_page" style="background-image:url({{ asset('images/faq_page.jpg') }}) !important; background-position:center !important; background-size:cover;">
    <img src="{{ asset('images/overlay_page.png') }}" alt="">
</div>
<div class="divider"></div>

{{-- FAQ Layout --}}
<div class="faq_layout">
    <img src="images/visi-misi-left.svg" alt="" class="visi_misi_left hidden_top_header">
    <img src="images/visi-misi-right.svg" alt="" class="visi_misi_right hidden_top_header">

    {{-- Header --}}
    <div class="faq_header">
        <h1>Pertanyaan Umum</h1>
        <p>Temukan jawaban atas pertanyaan yang paling sering diajukan tentang produk dan layanan kami.</p>
    </div>

    {{-- Category Filter (TAB) --}}
    <div class="faq_categories" id="faqCategories">
        <button type="button" class="cat_btn active" data-category="all" onclick="filterFaqCategory('all')">Semua</button>
        @foreach($categories as $cat)
        <button type="button" class="cat_btn" data-category="{{ $cat->slug }}" onclick="filterFaqCategory('{{ $cat->slug }}')">{{ $cat->name }}</button>
        @endforeach
        @if($faqsWithoutCategory->isNotEmpty())
        <button type="button" class="cat_btn" data-category="lainnya" onclick="filterFaqCategory('lainnya')">Lainnya</button>
        @endif
    </div>

    {{-- FAQ List --}}
    <div class="faq_list" id="faqList">

        @if($categories->isNotEmpty())
            @foreach($categories as $category)
                @php
                    $categoryFaqs = $faqs->where('category_id', $category->id);
                @endphp
                @if($categoryFaqs->isNotEmpty())
                <div class="faq_category_section" data-category="{{ $category->slug }}">
                    <h2 class="category_title">{{ $category->name }}</h2>

                    @foreach($categoryFaqs as $faq)
                    <div class="faq_item">
                        <div class="faq_question" onclick="toggleFaqItem(this)">
                            <span>{{ $faq->question }}</span>
                            <svg class="faq_icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </div>
                        <div class="faq_answer">
                            <p>{{ $faq->answer }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            @endforeach
        @endif

        {{-- FAQ tanpa kategori --}}
        @if($faqsWithoutCategory->isNotEmpty())
        <div class="faq_category_section" data-category="lainnya">
            <h2 class="category_title">Lainnya</h2>
            @foreach($faqsWithoutCategory as $faq)
            <div class="faq_item">
                <div class="faq_question" onclick="toggleFaqItem(this)">
                    <span>{{ $faq->question }}</span>
                    <svg class="faq_icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </div>
                <div class="faq_answer">
                    <p>{{ $faq->answer }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Jika tidak ada FAQ sama sekali --}}
        @if($faqs->isEmpty())
        <div class="faq_no_result" style="display:flex;">
            <svg class="no_result_icon" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="9" y1="15" x2="15" y2="15"/>
                <line x1="9" y1="11" x2="15" y2="11"/>
            </svg>
            <h3>Belum Ada FAQ</h3>
            <p>Belum ada pertanyaan yang ditambahkan. Silakan cek kembali nanti.</p>
        </div>
        @endif

    </div>

    {{-- Still Have Questions --}}
    @if($faqs->isNotEmpty())
    <div class="faq_still_questions">
        <div class="still_questions_box">
            <svg class="still_icon" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#D2B780" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            <h3>Masih Ada Pertanyaan?</h3>
            <p>Jika pertanyaan Anda belum terjawab, jangan ragu untuk menghubungi kami.</p>
            <div class="still_buttons">
                <a href="{{ route('contact') }}" class="still_btn primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    Hubungi Kami
                </a>
                <a href="https://wa.me/6285121212200" class="still_btn secondary" target="_blank">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                    </svg>
                    Chat WhatsApp
                </a>
            </div>
        </div>
    </div>
    @endif

</div>
<div class="divider"></div>

@endsection

@section('scripts')
<script>
function setFaqState(item, isOpen) {
    var answer = item.querySelector('.faq_answer');
    var icon = item.querySelector('.faq_icon');

    item.classList.toggle('active', isOpen);

    if (answer) {
        answer.style.maxHeight = isOpen ? '9999px' : '0px';
        answer.style.overflow = 'hidden';
        answer.style.transition = 'max-height 0.12s ease, padding 0.08s ease';
        answer.style.padding = isOpen ? '0 1.5vw 1.2vw 1.5vw' : '0 1.5vw';
    }

    if (icon) {
        icon.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
        icon.style.transition = 'transform 0.18s ease';
    }
}

function toggleFaqItem(element) {
    var item = element.closest('.faq_item');
    if (!item) return;

    var isOpen = !item.classList.contains('active');

    document.querySelectorAll('.faq_item').forEach(function (currentItem) {
        if (currentItem !== item) {
            setFaqState(currentItem, false);
        }
    });

    setFaqState(item, isOpen);
}

function filterFaqCategory(category) {
    var tabs = document.querySelectorAll('.cat_btn');
    var sections = document.querySelectorAll('.faq_category_section');

    tabs.forEach(function (tab) {
        tab.classList.toggle('active', tab.getAttribute('data-category') === category);
    });

    sections.forEach(function (section) {
        var sectionCategory = section.getAttribute('data-category');
        section.style.display = (category === 'all' || sectionCategory === category) ? 'block' : 'none';
    });

    document.querySelectorAll('.faq_item.active').forEach(function (item) {
        setFaqState(item, false);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.faq_item').forEach(function (item) {
        setFaqState(item, false);
    });

    filterFaqCategory('all');
});
</script>
@endsection