@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-teal-600 to-teal-800 rounded-0 md:rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <iconify-icon icon="mdi:frequently-asked-questions" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Manajemen FAQ</h1>
                    <p class="text-teal-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Kelola pertanyaan yang sering diajukan</p>
                </div>
            </div>
            
            <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.faq.categories') }}" 
                class="flex-1 sm:flex-none bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm sm:text-base">
                    <iconify-icon icon="mdi:tag-multiple" width="18" height="18" class="sm:w-5 sm:h-5"></iconify-icon>
                    <span>Kelola Kategori</span>
                </a>
                
                <button onclick="openFaqModal()" 
                        class="flex-1 sm:flex-none bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm sm:text-base">
                    <iconify-icon icon="mdi:plus" width="18" height="18" class="sm:w-5 sm:h-5"></iconify-icon>
                    <span>Tambah FAQ</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Notification Container -->
    <div id="notification-container" class="fixed top-5 right-5 z-50 space-y-3 w-96 max-w-full pointer-events-none"></div>

    <div id="notification-template-success" class="hidden">
        <div class="bg-gradient-to-r from-green-500/95 to-green-600/95 backdrop-blur-sm text-white p-4 rounded-xl shadow-2xl border border-green-400/30 flex items-start gap-3">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                    <iconify-icon icon="mdi:check-circle" width="20" height="20" class="text-white"></iconify-icon>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-white">Berhasil!</p>
                <p class="text-sm text-white/90 mt-0.5 message-placeholder"></p>
            </div>
            <button onclick="dismissNotification(this)" class="flex-shrink-0 text-white/70 hover:text-white transition-colors">
                <iconify-icon icon="mdi:close" width="18" height="18"></iconify-icon>
            </button>
        </div>
    </div>

    <div id="notification-template-error" class="hidden">
        <div class="bg-gradient-to-r from-red-500/95 to-red-600/95 backdrop-blur-sm text-white p-4 rounded-xl shadow-2xl border border-red-400/30 flex items-start gap-3">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                    <iconify-icon icon="mdi:alert-circle" width="20" height="20" class="text-white"></iconify-icon>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-white">Error!</p>
                <p class="text-sm text-white/90 mt-0.5 message-placeholder"></p>
            </div>
            <button onclick="dismissNotification(this)" class="flex-shrink-0 text-white/70 hover:text-white transition-colors">
                <iconify-icon icon="mdi:close" width="18" height="18"></iconify-icon>
            </button>
        </div>
    </div>

    <!-- Filter Categories -->
    <div class="mb-6 flex flex-wrap gap-2 items-center">
        <button onclick="filterFaq('all')" class="filter-btn active px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 bg-teal-600 text-white" data-filter="all">
            Semua
        </button>
        @foreach($categories as $cat)
        <button onclick="filterFaq('{{ $cat->slug }}')" 
                class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 bg-gray-700 text-gray-300 hover:bg-gray-600" 
                data-filter="{{ $cat->slug }}">
            <span class="w-2 h-2 inline-block rounded-full bg-{{ $cat->color }}-400 mr-1"></span>
            {{ $cat->name }}
        </button>
        @endforeach
    </div>

    <!-- FAQ List -->
    <div id="faqList" class="space-y-3">
        @if($faqs->count() > 0)
            @include('admin.faq._item', ['faq' => $faqs->first()])
        @endif
        <!-- Items akan di-load via JavaScript -->
    </div>

    <!-- 🔥 LOAD MORE -->
    <div id="loadMoreContainer" class="mt-6 text-center">
        <button id="loadMoreBtn" 
                onclick="loadMoreFaq()"
                class="px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2 mx-auto">
            <iconify-icon icon="mdi:reload" width="20" height="20"></iconify-icon>
            <span id="loadMoreText">Muat Lebih Banyak</span>
        </button>
        <div id="loadMoreLoading" class="hidden py-4">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-teal-500 border-t-transparent"></div>
            <p class="text-gray-400 text-sm mt-2">Memuat...</p>
        </div>
        <p id="loadMoreEnd" class="text-gray-500 text-sm hidden">Semua FAQ telah dimuat</p>
    </div>

    <!-- Total Count -->
    <div class="mt-6 p-4 bg-gray-800/50 rounded-xl border border-gray-700/50">
        <div class="flex items-center gap-2 text-gray-400 text-sm">
            <iconify-icon icon="mdi:information" width="16" height="16"></iconify-icon>
            <span>Total <span id="totalCount">{{ $faqs->total() }}</span> FAQ</span>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- MODAL FORM FAQ -->
<!-- ============================================ -->
<div id="faqModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md transition-all duration-300">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-2xl rounded-2xl border border-gray-700/50 shadow-2xl mx-4 transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-teal-500/10 rounded-lg">
                    <iconify-icon id="modalIcon" icon="mdi:help-circle" width="24" height="24" class="text-teal-400"></iconify-icon>
                </div>
                <h2 id="modalTitle" class="text-lg sm:text-xl font-bold text-white">Tambah FAQ</h2>
            </div>
            <button onclick="closeFaqModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <!-- Modal Body -->
        <form id="faqForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="faq_id" id="faqId">

            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <!-- Pertanyaan -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:format-quote-open" width="14" height="14"></iconify-icon>
                        Pertanyaan <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="question" id="question" 
                           placeholder="Masukkan pertanyaan yang sering diajukan"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition text-sm"
                           required>
                </div>
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:translate" width="14" height="14"></iconify-icon>
                        Pertanyaan (Jepang)
                    </label>
                    <input type="text" name="question_jp" id="question_jp" 
                        placeholder="日本語の質問を入力してください"
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition text-sm">
                </div>

                <!-- Kategori -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:tag" width="14" height="14"></iconify-icon>
                        Kategori
                    </label>
                    <select name="category_id" id="category_id" 
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition text-sm">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Jawaban -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:text" width="14" height="14"></iconify-icon>
                        Jawaban <span class="text-red-400">*</span>
                    </label>
                    <textarea name="answer" id="answer" rows="5"
                              placeholder="Masukkan jawaban untuk pertanyaan tersebut"
                              class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition text-sm"
                              required></textarea>
                </div>

                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:translate" width="14" height="14"></iconify-icon>
                        Jawaban (Jepang)
                    </label>
                    <textarea name="answer_jp" id="answer_jp" rows="5"
                            placeholder="日本語の回答を入力してください"
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition text-sm"></textarea>
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:eye" width="14" height="14"></iconify-icon>
                        Status
                    </label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 text-white cursor-pointer">
                            <input type="checkbox" name="is_active" id="is_active" value="1" checked
                                   class="w-4 h-4 text-teal-600 bg-gray-700 border-gray-600 rounded focus:ring-teal-500">
                            <span class="text-sm">Aktif</span>
                        </label>
                    </div>
                </div>

                <!-- Info -->
                <div class="bg-teal-500/5 border border-teal-500/20 rounded-lg p-3 flex items-start gap-2">
                    <iconify-icon icon="mdi:information" width="16" height="16" class="text-teal-400 flex-shrink-0 mt-0.5"></iconify-icon>
                    <p class="text-gray-400 text-xs">
                        Field dengan tanda <span class="text-red-400">*</span> wajib diisi. FAQ akan ditampilkan di halaman depan sesuai urutan yang diatur.
                    </p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 p-4 border-t border-gray-700/50">
                <button type="button" onclick="closeFaqModal()" 
                        class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                    Batal
                </button>
                <button type="submit" id="submitBtn"
                        class="px-6 py-2.5 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2 shadow-lg shadow-teal-900/20">
                    <iconify-icon icon="mdi:content-save" width="16" height="16"></iconify-icon>
                    <span id="submitText">Simpan FAQ</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================ -->
<!-- MODAL LIHAT JAWABAN LENGKAP -->
<!-- ============================================ -->
<div id="answerModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md transition-all duration-300">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-2xl rounded-2xl border border-gray-700/50 shadow-2xl mx-4 transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-teal-500/10 rounded-lg">
                    <iconify-icon icon="mdi:format-quote-open" width="24" height="24" class="text-teal-400"></iconify-icon>
                </div>
                <h2 id="answerModalTitle" class="text-lg sm:text-xl font-bold text-white">Jawaban FAQ</h2>
            </div>
            <button onclick="closeAnswerModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
            <!-- Pertanyaan -->
            <div class="space-y-1">
                <p class="text-xs text-gray-500 font-medium">Pertanyaan</p>
                <p id="answerModalQuestion" class="text-white font-medium text-base"></p>
            </div>
            
            <!-- Kategori -->
            <div class="space-y-1">
                <p class="text-xs text-gray-500 font-medium">Kategori</p>
                <p id="answerModalCategory" class="text-gray-300 text-sm"></p>
            </div>
            
            <!-- Jawaban Lengkap -->
            <div class="space-y-1">
                <p class="text-xs text-gray-500 font-medium">Jawaban</p>
                <div id="answerModalAnswer" class="text-gray-300 text-sm leading-relaxed whitespace-pre-line"></div>
            </div>
            
            <!-- Status -->
            <div class="space-y-1">
                <p class="text-xs text-gray-500 font-medium">Status</p>
                <span id="answerModalStatus" class="px-3 py-1 rounded-full text-xs font-medium"></span>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end gap-3 p-4 border-t border-gray-700/50">
            <button type="button" onclick="closeAnswerModal()" 
                    class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- DELETE CONFIRMATION MODAL -->
<!-- ============================================ -->
<div id="deleteModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md transition-all duration-300">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-md rounded-2xl border border-gray-700/50 shadow-2xl mx-4 transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-3 bg-red-500/10 rounded-full">
                    <iconify-icon icon="mdi:alert" width="28" height="28" class="text-red-400"></iconify-icon>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Hapus FAQ</h3>
                    <p class="text-sm text-gray-400">Apakah Anda yakin?</p>
                </div>
            </div>
            <p class="text-gray-300 text-sm mb-6">FAQ yang dihapus tidak dapat dikembalikan.</p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeDeleteModal()" 
                            class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2">
                        <iconify-icon icon="mdi:delete" width="16" height="16"></iconify-icon>
                        Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<style>
    .modal-show {
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-track { background: #1f2937; }
    ::-webkit-scrollbar-thumb { background: #4b5563; border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: #6b7280; }
    .faq-item {
        transition: all 0.3s ease;
    }
    .faq-item:hover {
        transform: translateX(4px);
    }
    .filter-btn.active {
        background-color: #0d9488;
        color: white;
    }
    .filter-btn:not(.active):hover {
        background-color: #374151;
    }
    .sortable-ghost {
        opacity: 0.4;
        border: 2px dashed #0d9488;
    }
</style>

<script>
    // ============================================
    // DATA
    // ============================================
    const faqs = @json($faqs->items());
    let currentPage = 1;
    let currentCategory = 'all';
    let isLoading = false;
    let hasMore = true;
    let totalItems = {{ $faqs->total() }};

    // ============================================
    // NOTIFICATION
    // ============================================
    function showNotification(message, type = 'success') {
        const container = document.getElementById('notification-container');
        const template = document.getElementById(`notification-template-${type}`);
        if (template && container) {
            const notification = template.cloneNode(true);
            notification.id = '';
            notification.classList.remove('hidden');
            notification.classList.add('notification');
            const messageEl = notification.querySelector('.message-placeholder');
            if (messageEl) messageEl.textContent = message;
            container.appendChild(notification);
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
                notification.style.opacity = '1';
            }, 10);
            setTimeout(() => {
                dismissNotification(notification.querySelector('button'));
            }, 5000);
        }
    }

    function dismissNotification(button) {
        const notification = button.closest('.notification');
        if (notification) {
            notification.style.transform = 'translateX(100%)';
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 500);
        }
    }

    // ============================================
    // FILTER
    // ============================================
    function filterFaq(category) {
        currentCategory = category;
        currentPage = 1;
        hasMore = true;
        
        document.getElementById('faqList').innerHTML = '';
        document.getElementById('loadMoreLoading').classList.remove('hidden');
        document.getElementById('loadMoreBtn').classList.add('hidden');
        document.getElementById('loadMoreEnd').classList.add('hidden');
        
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.filter === category) {
                btn.classList.add('active');
            }
        });
        
        loadMoreFaq(true);
    }

    // ============================================
    // LOAD MORE
    // ============================================
    function loadMoreFaq(reset = false) {
        if (isLoading) return;
        if (!hasMore && !reset) return;
        
        isLoading = true;
        const btn = document.getElementById('loadMoreBtn');
        const loading = document.getElementById('loadMoreLoading');
        const end = document.getElementById('loadMoreEnd');
        const text = document.getElementById('loadMoreText');
        
        btn.classList.add('hidden');
        loading.classList.remove('hidden');
        end.classList.add('hidden');
        
        const url = new URL('{{ route("admin.faq.load-more") }}');
        url.searchParams.set('page', currentPage);
        url.searchParams.set('category', currentCategory);
        
        fetch(url, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const list = document.getElementById('faqList');
                if (reset) list.innerHTML = '';
                
                // 🔥 CEK APAKAH ADA HTML YANG DIKEMBALIKAN
                if (data.html && data.html.trim() !== '') {
                    list.insertAdjacentHTML('beforeend', data.html);
                } else if (reset && list.innerHTML === '') {
                    // 🔥 TAMPILKAN PESAN KOSONG JIKA TIDAK ADA DATA
                    list.innerHTML = `
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
                    `;
                }
                
                document.getElementById('totalCount').textContent = data.total || 0;
                totalItems = data.total || 0;
                
                hasMore = data.hasMore || false;
                currentPage = data.currentPage ? data.currentPage + 1 : 1;
                
                loading.classList.add('hidden');
                
                const remaining = (data.total || 0) - ((data.currentPage || 0) * 20);
                
                if (hasMore && remaining > 0) {
                    btn.classList.remove('hidden');
                    text.textContent = 'Muat Lebih Banyak (' + remaining + ' tersisa)';
                } else {
                    end.classList.remove('hidden');
                    btn.classList.add('hidden');
                }
                
                initSortable();
                attachFaqEvents();
            } else {
                throw new Error(data.message || 'Gagal memuat data');
            }
        })
        .catch(error => {
            console.error('Error loading more:', error);
            loading.classList.add('hidden');
            btn.classList.remove('hidden');
            text.textContent = 'Coba Lagi';
            showNotification('Gagal memuat data: ' + error.message, 'error');
        })
        .finally(() => {
            isLoading = false;
        });
    }

    // ============================================
    // ATTACH FAQ EVENTS
    // ============================================
    function attachFaqEvents() {
        // Events already attached via onclick
    }

    // ============================================
    // MODAL JAWABAN LENGKAP
    // ============================================
    function getFaqById(id) {
        const item = document.querySelector(`.faq-item[data-id="${id}"]`);
        if (!item) {
            return faqs.find(f => f.id === id) || null;
        }

        return {
            id: Number(id),
            question: item.dataset.question || '',
            answer: item.dataset.answer || '',
            question_jp: item.dataset.questionJp || '',
            answer_jp: item.dataset.answerJp || '',
            category_id: item.dataset.categoryId || null,
            category_label: item.dataset.category || 'Tidak ada kategori',
            is_active: item.dataset.isActive === '1'
        };
    }

    function openAnswerModal(id) {
        const faq = getFaqById(id);
        if (!faq) return;

        const modal = document.getElementById('answerModal');
        const modalContent = modal.querySelector('.modal-show');

        document.getElementById('answerModalQuestion').textContent = faq.question;
        document.getElementById('answerModalAnswer').textContent = faq.answer;
        document.getElementById('answerModalCategory').textContent = faq.category_label || 'Tidak ada kategori';
        
        const statusEl = document.getElementById('answerModalStatus');
        if (faq.is_active) {
            statusEl.textContent = 'Aktif';
            statusEl.className = 'px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400';
        } else {
            statusEl.textContent = 'Nonaktif';
            statusEl.className = 'px-3 py-1 rounded-full text-xs font-medium bg-red-500/20 text-red-400';
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeAnswerModal() {
        const modal = document.getElementById('answerModal');
        const modalContent = modal.querySelector('.modal-show');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 300);
    }

    // ============================================
    // EXPOSE ANSWER MODAL FUNCTIONS
    // ============================================
    window.openAnswerModal = openAnswerModal;
    window.closeAnswerModal = closeAnswerModal;

    // ============================================
    // SORTABLE
    // ============================================
    function initSortable() {
        const list = document.getElementById('faqList');
        if (!list) return;
        
        if (window.sortableInstance) {
            try { window.sortableInstance.destroy(); } catch(e) {}
        }
        
        window.sortableInstance = new Sortable(list, {
            animation: 150,
            handle: '.cursor-grab',
            ghostClass: 'sortable-ghost',
            onEnd: function() { updateFaqOrder(); }
        });
    }

    function updateFaqOrder() {
        const items = document.querySelectorAll('.faq-item');
        const orders = [];
        items.forEach((item, index) => {
            const id = item.dataset.id;
            if (id) orders.push({ id: parseInt(id), sort_order: index + 1 });
        });
        if (orders.length === 0) return;
        fetch('{{ route("admin.faq.update-order") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ orders: orders })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                orders.forEach(order => {
                    const item = document.querySelector(`.faq-item[data-id="${order.id}"]`);
                    if (item) item.dataset.sort = order.sort_order;
                });
                showNotification('Urutan FAQ berhasil diperbarui', 'success');
            }
        })
        .catch(error => console.error('Error updating order:', error));
    }

    // ============================================
    // TOGGLE ACTIVE
    // ============================================
    function toggleFaqActive(id) {
        fetch(`/admin/faq/${id}/toggle-active`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = document.querySelector(`.faq-item[data-id="${id}"]`);
                if (item) {
                    const badge = item.querySelector('.status-badge');
                    const iconBtn = item.querySelector('.toggle-active-btn');
                    if (data.is_active) {
                        badge.textContent = 'Aktif';
                        badge.className = 'px-2 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-400 status-badge';
                        iconBtn.className = 'p-1.5 rounded-lg transition-all duration-300 bg-green-500/30 text-green-400 hover:bg-green-500/50 toggle-active-btn';
                        iconBtn.querySelector('iconify-icon').setAttribute('icon', 'mdi:eye');
                    } else {
                        badge.textContent = 'Nonaktif';
                        badge.className = 'px-2 py-0.5 rounded-full text-xs font-medium bg-red-500/20 text-red-400 status-badge';
                        iconBtn.className = 'p-1.5 rounded-lg transition-all duration-300 bg-red-500/30 text-red-400 hover:bg-red-500/50 toggle-active-btn';
                        iconBtn.querySelector('iconify-icon').setAttribute('icon', 'mdi:eye-off');
                    }
                }
                showNotification(data.message, 'success');
            }
        })
        .catch(error => {
            console.error('Error toggling active:', error);
            showNotification('Gagal mengubah status', 'error');
        });
    }

    // ============================================
    // MODAL FUNCTIONS
    // ============================================
    function openFaqModal(id = null) {
        const modal = document.getElementById('faqModal');
        const modalContent = modal.querySelector('.modal-show');
        const form = document.getElementById('faqForm');
        const formMethod = document.getElementById('formMethod');
        const submitText = document.getElementById('submitText');
        const modalTitle = document.getElementById('modalTitle');
        const modalIcon = document.getElementById('modalIcon');
        
        form.reset();
        document.getElementById('is_active').checked = true;
        document.getElementById('faqId').value = '';
        
        if (id) {
            const faq = getFaqById(id);
            if (faq) {
                modalTitle.textContent = 'Edit FAQ';
                modalIcon.setAttribute('icon', 'mdi:pencil');
                submitText.textContent = 'Update FAQ';
                formMethod.value = 'PUT';
                form.action = '{{ url("faq") }}/' + id;
                
                document.getElementById('question').value = faq.question;
                document.getElementById('question_jp').value = faq.question_jp || '';
                document.getElementById('answer').value = faq.answer;
                document.getElementById('answer_jp').value = faq.answer_jp || '';
                document.getElementById('category_id').value = faq.category_id || '';
                document.getElementById('is_active').checked = faq.is_active;
                document.getElementById('faqId').value = faq.id;
            }
        } else {
            modalTitle.textContent = 'Tambah FAQ';
            modalIcon.setAttribute('icon', 'mdi:help-circle');
            submitText.textContent = 'Simpan FAQ';
            formMethod.value = 'POST';
            form.action = '{{ route("admin.faq.store") }}';
        }
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeFaqModal() {
        const modal = document.getElementById('faqModal');
        const modalContent = modal.querySelector('.modal-show');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 300);
    }

    // ============================================
    // DELETE
    // ============================================
    function deleteFaq(id) {
        const modal = document.getElementById('deleteModal');
        const modalContent = modal.querySelector('.modal-show');
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = '{{ url("faq") }}/' + id;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const modalContent = modal.querySelector('.modal-show');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 300);
    }

    // ============================================
    // FORM SUBMIT
    // ============================================
    document.getElementById('faqForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const formMethod = document.getElementById('formMethod');

        formData.set('_method', formMethod.value || 'POST');

        submitBtn.disabled = true;
        submitText.textContent = 'Menyimpan...';

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeFaqModal();
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification(data.message || 'Terjadi kesalahan', 'error');
                submitBtn.disabled = false;
                submitText.textContent = document.getElementById('faqId').value ? 'Update FAQ' : 'Simpan FAQ';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan pada server', 'error');
            submitBtn.disabled = false;
            submitText.textContent = document.getElementById('faqId').value ? 'Update FAQ' : 'Simpan FAQ';
        });
    });

    // ============================================
    // DELETE FORM SUBMIT
    // ============================================
    document.getElementById('deleteForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.set('_method', 'DELETE');

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeDeleteModal();
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification(data.message || 'Terjadi kesalahan', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan pada server', 'error');
        });
    });

    // ============================================
    // KEYBOARD SHORTCUTS
    // ============================================
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeFaqModal();
            closeDeleteModal();
            closeAnswerModal();
        }
    });

    document.querySelectorAll('.modal').forEach(modal => {
        modal?.addEventListener('click', function(e) {
            if (e.target === this) {
                if (this.id === 'faqModal') closeFaqModal();
                if (this.id === 'deleteModal') closeDeleteModal();
                if (this.id === 'answerModal') closeAnswerModal();
            }
        });
    });

    // ============================================
    // INIT
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        loadMoreFaq(true);
        console.log('Admin FAQ initialized');
    });

    // ============================================
    // EXPOSE FUNCTIONS
    // ============================================
    window.filterFaq = filterFaq;
    window.loadMoreFaq = loadMoreFaq;
    window.toggleFaqActive = toggleFaqActive;
    window.deleteFaq = deleteFaq;
    window.closeDeleteModal = closeDeleteModal;
    window.openFaqModal = openFaqModal;
    window.closeFaqModal = closeFaqModal;
    window.showNotification = showNotification;
    window.dismissNotification = dismissNotification;
</script>
@endsection