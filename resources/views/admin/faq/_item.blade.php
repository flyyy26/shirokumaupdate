@if($faq)
<div class="faq-item group bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-xl border border-gray-700/50 shadow-xl backdrop-blur-sm p-4 hover:border-teal-500/50 transition-all duration-300 cursor-grab"
     data-id="{{ $faq->id }}"
     data-sort="{{ $faq->sort_order }}"
     data-question="{{ e($faq->question) }}"
     data-question-jp="{{ e($faq->question_jp ?? '') }}"
     data-answer="{{ e($faq->answer) }}"
     data-answer-jp="{{ e($faq->answer_jp ?? '') }}"
     data-category="{{ e($faq->category?->name ?? 'Tidak ada kategori') }}"
     data-category-id="{{ $faq->category_id ?? '' }}"
     data-is-active="{{ $faq->is_active ? '1' : '0' }}">
    
    <div class="flex items-start justify-between gap-4">
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-3 flex-wrap">
                <div class="cursor-grab opacity-0 group-hover:opacity-100 transition-opacity">
                    <iconify-icon icon="mdi:drag-horizontal" width="20" height="20" class="text-gray-500"></iconify-icon>
                </div>
                <div class="w-8 h-8 rounded-lg bg-teal-500/20 flex items-center justify-center flex-shrink-0">
                    <iconify-icon icon="mdi:format-quote-open" width="16" height="16" class="text-teal-400"></iconify-icon>
                </div>
                <h3 class="text-white font-medium text-sm sm:text-base truncate">{{ $faq->question }}</h3>
            </div>
            
            {{-- Jawaban Singkat (1-2 baris) --}}
            <div class="mt-2 text-gray-400 text-sm pl-11 line-clamp-2">{{ $faq->answer }}</div>
            
            {{-- Tombol Lihat Selengkapnya --}}
            <button onclick="openAnswerModal({{ $faq->id }})" 
                    class="mt-1.5 ml-11 text-teal-400 hover:text-teal-300 text-xs font-medium transition-colors flex items-center gap-1">
                <iconify-icon icon="mdi:eye" width="14" height="14"></iconify-icon>
                Lihat Selengkapnya
            </button>
        </div>
        
        <div class="flex items-center gap-2 flex-shrink-0">
            @if($faq->category)
            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $faq->category_color }}-500/20 text-{{ $faq->category_color }}-400 border border-{{ $faq->category_color }}-500/20">
                {{ $faq->category_label }}
            </span>
            @endif
            
            <span class="px-2 py-0.5 rounded-full text-xs font-medium status-badge {{ $faq->is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                {{ $faq->is_active ? 'Aktif' : 'Nonaktif' }}
            </span>
            
            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                <button onclick="openFaqModal({{ $faq->id }})" 
                        class="p-1.5 bg-yellow-600/30 hover:bg-yellow-600/50 text-yellow-400 rounded-lg transition-all duration-300">
                    <iconify-icon icon="mdi:pencil" width="15" height="15"></iconify-icon>
                </button>
                <button onclick="deleteFaq({{ $faq->id }})" 
                        class="p-1.5 bg-red-600/30 hover:bg-red-600/50 text-red-400 rounded-lg transition-all duration-300">
                    <iconify-icon icon="mdi:delete" width="15" height="15"></iconify-icon>
                </button>
            </div>
        </div>
    </div>
</div>
@else
{{-- Tampilkan pesan jika tidak ada data --}}
<div class="col-span-full">
    <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-dashed border-gray-700 rounded-2xl p-12 text-center backdrop-blur-sm">
        <div class="relative inline-block">
            <div class="absolute inset-0 bg-teal-500 blur-3xl opacity-20 rounded-full"></div>
            <div class="relative bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                <iconify-icon icon="mdi:help-circle" width="32" height="32" class="text-gray-600"></iconify-icon>
            </div>
        </div>
        <h3 class="text-lg font-bold text-white mb-2">Belum Ada FAQ</h3>
        <p class="text-gray-500 text-sm max-w-xs mx-auto mb-4">
            Anda belum menambahkan FAQ. Silakan tambah FAQ baru.
        </p>
        <button onclick="openFaqModal()" 
                class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300">
            <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
            Tambah FAQ
        </button>
    </div>
</div>
@endif