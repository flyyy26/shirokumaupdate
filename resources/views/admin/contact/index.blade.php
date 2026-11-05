@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-0 md:rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <iconify-icon icon="mdi:inbox" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Kotak Masuk</h1>
                    <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Kelola pesan dari form kontak</p>
                </div>
            </div>
            
            <div class="flex flex-wrap gap-2">
                <button onclick="filterInbox('all')" class="filter-btn active px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 bg-blue-600 text-white" data-filter="all">
                    Semua
                </button>
                <button onclick="filterInbox('unread')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 bg-gray-700 text-gray-300 hover:bg-gray-600" data-filter="unread">
                    Belum Dibaca
                    @if($unreadCount > 0)
                    <span class="ml-1 px-2 py-0.5 rounded-full bg-red-500 text-white text-xs">{{ $unreadCount }}</span>
                    @endif
                </button>
                <button onclick="filterInbox('read')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 bg-gray-700 text-gray-300 hover:bg-gray-600" data-filter="read">
                    Dibaca
                </button>
                <button onclick="filterInbox('replied')" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 bg-gray-700 text-gray-300 hover:bg-gray-600" data-filter="replied">
                    Dibalas
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

    <!-- Bulk Actions -->
    <div class="mb-4 flex items-center gap-3">
        <button onclick="deleteSelected()" class="px-4 py-2 bg-red-600/30 hover:bg-red-600/50 text-red-400 rounded-lg text-sm font-medium transition-all duration-300">
            Hapus Terpilih
        </button>
        <span class="text-gray-400 text-sm" id="selectedCount">0 dipilih</span>
    </div>

    <!-- Contact List -->
    <div id="contactList" class="space-y-3">
        @forelse($contacts as $contact)
            @include('admin.contact._item', ['contact' => $contact])
        @empty
        <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-dashed border-gray-700 rounded-2xl p-12 text-center backdrop-blur-sm">
            <div class="relative inline-block">
                <div class="absolute inset-0 bg-blue-500 blur-3xl opacity-20 rounded-full"></div>
                <div class="relative bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                    <iconify-icon icon="mdi:inbox-empty" width="32" height="32" class="text-gray-600"></iconify-icon>
                </div>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Kotak Masuk Kosong</h3>
            <p class="text-gray-500 text-sm max-w-xs mx-auto">Belum ada pesan yang masuk dari form kontak.</p>
        </div>
        @endforelse
    </div>

    <!-- Load More -->
    <div id="loadMoreContainer" class="mt-6 text-center">
        <button id="loadMoreBtn" onclick="loadMore()" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2 mx-auto">
            <iconify-icon icon="mdi:reload" width="20" height="20"></iconify-icon>
            <span id="loadMoreText">Muat Lebih Banyak</span>
        </button>
        <div id="loadMoreLoading" class="hidden py-4">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-blue-500 border-t-transparent"></div>
            <p class="text-gray-400 text-sm mt-2">Memuat...</p>
        </div>
        <p id="loadMoreEnd" class="text-gray-500 text-sm hidden">Semua pesan telah dimuat</p>
    </div>

    <!-- Total -->
    <div class="mt-6 p-4 bg-gray-800/50 rounded-xl border border-gray-700/50">
        <div class="flex items-center gap-2 text-gray-400 text-sm">
            <iconify-icon icon="mdi:information" width="16" height="16"></iconify-icon>
            <span>Total <span id="totalCount">{{ $contacts->total() }}</span> pesan</span>
            @if($unreadCount > 0)
            <span class="ml-2 text-red-400">• {{ $unreadCount }} belum dibaca</span>
            @endif
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- MODAL DETAIL PESAN -->
<!-- ============================================ -->
<div id="detailModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md transition-all duration-300">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-2xl rounded-2xl border border-gray-700/50 shadow-2xl mx-4 transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500/10 rounded-lg">
                    <iconify-icon icon="mdi:email-open" width="24" height="24" class="text-blue-400"></iconify-icon>
                </div>
                <h2 class="text-lg sm:text-xl font-bold text-white">Detail Pesan</h2>
            </div>
            <button onclick="closeDetailModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs text-gray-500 font-medium">Nama</label>
                    <p id="detailName" class="text-white font-medium"></p>
                </div>
                <div>
                    <label class="text-xs text-gray-500 font-medium">Telepon</label>
                    <p id="detailPhone" class="text-white font-medium"></p>
                </div>
                <div class="md:col-span-2">
                    <label class="text-xs text-gray-500 font-medium">Email</label>
                    <p id="detailEmail" class="text-white font-medium"></p>
                </div>
                <div class="md:col-span-2">
                    <label class="text-xs text-gray-500 font-medium">Status</label>
                    <p id="detailStatus"></p>
                </div>
                <div class="md:col-span-2">
                    <label class="text-xs text-gray-500 font-medium">Pesan</label>
                    <div id="detailMessage" class="text-gray-300 text-sm leading-relaxed whitespace-pre-line bg-gray-700/30 p-4 rounded-lg mt-1"></div>
                </div>
                <div class="md:col-span-2">
                    <label class="text-xs text-gray-500 font-medium">Dikirim</label>
                    <p id="detailDate" class="text-gray-400 text-sm"></p>
                </div>
            </div>

            <div class="flex flex-wrap gap-2 pt-4 border-t border-gray-700/50">
                <button id="markReadBtn" onclick="markRead()" class="px-4 py-2 bg-blue-600/30 hover:bg-blue-600/50 text-blue-400 rounded-lg text-sm font-medium transition-all duration-300">
                    <iconify-icon icon="mdi:check-circle" width="16" height="16" class="inline mr-1"></iconify-icon>
                    Tandai Dibaca
                </button>
                <button id="markRepliedBtn" onclick="markReplied()" class="px-4 py-2 bg-green-600/30 hover:bg-green-600/50 text-green-400 rounded-lg text-sm font-medium transition-all duration-300">
                    <iconify-icon icon="mdi:check" width="16" height="16" class="inline mr-1"></iconify-icon>
                    Tandai Dibalas
                </button>
                <button onclick="replyEmail()" class="px-4 py-2 bg-blue-600/30 hover:bg-blue-600/50 text-blue-400 rounded-lg text-sm font-medium transition-all duration-300">
                    <iconify-icon icon="mdi:email" width="16" height="16" class="inline mr-1"></iconify-icon>
                    Balas Email
                </button>
                <button onclick="deleteContact()" class="px-4 py-2 bg-red-600/30 hover:bg-red-600/50 text-red-400 rounded-lg text-sm font-medium transition-all duration-300">
                    <iconify-icon icon="mdi:delete" width="16" height="16" class="inline mr-1"></iconify-icon>
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

<style>
    .modal-show {
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .filter-btn.active {
        background-color: #2563eb;
        color: white;
    }
    .filter-btn:not(.active):hover {
        background-color: #374151;
    }
    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-track { background: #1f2937; }
    ::-webkit-scrollbar-thumb { background: #4b5563; border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: #6b7280; }
</style>

<script>
    // ============================================
    // DATA
    // ============================================
    const contacts = @json($contacts->items());
    let currentPage = 1;
    let currentStatus = 'all';
    let isLoading = false;
    let hasMore = true;
    let totalItems = {{ $contacts->total() }};
    let selectedIds = [];
    let currentContactId = null;

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
    function filterInbox(status) {
        currentStatus = status;
        currentPage = 1;
        hasMore = true;
        
        document.getElementById('contactList').innerHTML = '';
        document.getElementById('loadMoreLoading').classList.remove('hidden');
        document.getElementById('loadMoreBtn').classList.add('hidden');
        document.getElementById('loadMoreEnd').classList.add('hidden');
        
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.filter === status) {
                btn.classList.add('active');
            }
        });
        
        loadMore(true);
    }

    // ============================================
    // LOAD MORE - PERBAIKI URL
    // ============================================
    function loadMore(reset = false) {
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
        
        // 🔥 Gunakan route helper Laravel agar path selalu sesuai
        const url = new URL('{{ route("admin.contact.load-more") }}', window.location.origin);
        url.searchParams.set('page', currentPage);
        url.searchParams.set('status', currentStatus);
        
        fetch(url, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`Server error: ${response.status}`);
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const list = document.getElementById('contactList');
                if (reset) list.innerHTML = '';
                
                // 🔥 CEK APAKAH ADA DATA
                if (data.html && data.html.trim() !== '') {
                    list.insertAdjacentHTML('beforeend', data.html);
                } else if (reset) {
                    // Tampilkan pesan kosong
                    list.innerHTML = `
                        <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-dashed border-gray-700 rounded-2xl p-12 text-center backdrop-blur-sm">
                            <div class="relative inline-block">
                                <div class="absolute inset-0 bg-blue-500 blur-3xl opacity-20 rounded-full"></div>
                                <div class="relative bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                                    <iconify-icon icon="mdi:inbox-empty" width="32" height="32" class="text-gray-600"></iconify-icon>
                                </div>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">Kotak Masuk Kosong</h3>
                            <p class="text-gray-500 text-sm max-w-xs mx-auto">Belum ada pesan yang masuk dari form kontak.</p>
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
    // SELECT / DESELECT
    // ============================================
    function toggleSelect(id) {
        const checkbox = document.querySelector(`input[value="${id}"]`);
        if (checkbox) {
            checkbox.checked = !checkbox.checked;
            updateSelected();
        }
    }

    function updateSelected() {
        const checkboxes = document.querySelectorAll('.contact-checkbox:checked');
        selectedIds = Array.from(checkboxes).map(cb => parseInt(cb.value));
        document.getElementById('selectedCount').textContent = selectedIds.length + ' dipilih';
    }

    function selectAll() {
        const checkboxes = document.querySelectorAll('.contact-checkbox');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        checkboxes.forEach(cb => cb.checked = !allChecked);
        updateSelected();
    }

    // ============================================
    // BULK DELETE
    // ============================================
    function deleteSelected() {
        if (selectedIds.length === 0) {
            showNotification('Pilih pesan yang akan dihapus', 'error');
            return;
        }
        if (!confirm('Hapus ' + selectedIds.length + ' pesan yang dipilih?')) return;
        
        fetch('{{ route("admin.contact.bulk-delete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ ids: selectedIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
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
    }

    // ============================================
    // DETAIL MODAL
    // ============================================
    function updateDetailStatus(contact) {
        const statusEl = document.getElementById('detailStatus');
        const readBtn = document.getElementById('markReadBtn');
        const repliedBtn = document.getElementById('markRepliedBtn');

        if (contact.is_replied) {
            statusEl.innerHTML = '<span class="px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400">Dibalas</span>';
            if (readBtn) readBtn.classList.add('opacity-50', 'cursor-not-allowed');
            if (repliedBtn) repliedBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else if (contact.is_read) {
            statusEl.innerHTML = '<span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400">Dibaca</span>';
            if (readBtn) readBtn.classList.add('opacity-50', 'cursor-not-allowed');
            if (repliedBtn) repliedBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            statusEl.innerHTML = '<span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-400">Belum Dibaca</span>';
            if (readBtn) readBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            if (repliedBtn) repliedBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    function openDetail(id) {
        const contact = contacts.find(c => c.id === id);
        if (!contact) return;

        currentContactId = id;
        const modal = document.getElementById('detailModal');
        const modalContent = modal.querySelector('.modal-show');

        document.getElementById('detailName').textContent = contact.name;
        document.getElementById('detailPhone').textContent = contact.phone;
        document.getElementById('detailEmail').textContent = contact.email;
        document.getElementById('detailMessage').textContent = contact.message;
        document.getElementById('detailDate').textContent = new Date(contact.created_at).toLocaleString('id-ID');
        updateDetailStatus(contact);

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeDetailModal() {
        const modal = document.getElementById('detailModal');
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
    // MARK READ
    // ============================================
    function markRead() {
        if (!currentContactId) return;
        const contact = contacts.find(c => c.id === currentContactId);
        if (!contact || contact.is_read) return;

        fetch(`/inbox/${currentContactId}/mark-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                contact.is_read = true;
                contact.read_at = data.read_at || new Date().toISOString();
                updateDetailStatus(contact);
                showNotification(data.message, 'success');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan', 'error');
        });
    }

    // ============================================
    // MARK REPLIED
    // ============================================
    function markReplied() {
        if (!currentContactId) return;
        const contact = contacts.find(c => c.id === currentContactId);
        if (!contact || contact.is_replied) return;

        fetch(`/inbox/${currentContactId}/mark-replied`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                contact.is_replied = true;
                contact.replied_at = data.replied_at || new Date().toISOString();
                contact.is_read = true;
                updateDetailStatus(contact);
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1500);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan', 'error');
        });
    }

    // ============================================
    // DELETE
    // ============================================
    function deleteContact() {
        if (!currentContactId) return;
        if (!confirm('Hapus pesan ini?')) return;
        fetch(`/inbox/${currentContactId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                closeDetailModal();
                setTimeout(() => location.reload(), 1500);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan', 'error');
        });
    }

    // ============================================
    // REPLY EMAIL
    // ============================================
    function replyEmail() {
        if (!currentContactId) return;
        const contact = contacts.find(c => c.id === currentContactId);
        if (!contact) return;
        window.location.href = `mailto:${contact.email}?subject=Balasan: Pesan dari LPK SHIROKUMA Indonesia`;
    }

    // ============================================
    // KEYBOARD SHORTCUTS
    // ============================================
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDetailModal();
        }
    });

    document.getElementById('detailModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeDetailModal();
    });

    // ============================================
    // INIT
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        loadMore(true);
        console.log('Admin Inbox initialized with ' + contacts.length + ' contacts');
    });

    // ============================================
    // EXPOSE FUNCTIONS
    // ============================================
    window.filterInbox = filterInbox;
    window.loadMore = loadMore;
    window.openDetail = openDetail;
    window.closeDetailModal = closeDetailModal;
    window.toggleSelect = toggleSelect;
    window.selectAll = selectAll;
    window.deleteSelected = deleteSelected;
    window.markRead = markRead;
    window.markReplied = markReplied;
    window.deleteContact = deleteContact;
    window.replyEmail = replyEmail;
    window.showNotification = showNotification;
    window.dismissNotification = dismissNotification;
</script>
@endsection