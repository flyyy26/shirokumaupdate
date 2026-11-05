@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-teal-600 to-teal-800 rounded-0 md:rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <iconify-icon icon="mdi:tag-multiple" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Kategori FAQ</h1>
                    <p class="text-teal-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Kelola kategori pertanyaan yang sering diajukan</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.faq.index') }}" 
                   class="flex-1 sm:flex-none bg-white/20 hover:bg-white/30 text-white px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 text-sm sm:text-base">
                    <iconify-icon icon="mdi:arrow-left" width="18" height="18"></iconify-icon>
                    <span>Kembali</span>
                </a>
                
                <button onclick="openCategoryModal()" 
                        class="flex-1 sm:flex-none bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm sm:text-base">
                    <iconify-icon icon="mdi:plus" width="18" height="18" class="sm:w-5 sm:h-5"></iconify-icon>
                    <span>Tambah Kategori</span>
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

    <!-- Categories List -->
    <div id="categoriesGrid" class="space-y-3">
        @forelse($categories as $category)
        <div class="category-item group bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-xl border border-gray-700/50 shadow-xl backdrop-blur-sm p-4 hover:border-teal-500/50 transition-all duration-300 cursor-grab"
             data-id="{{ $category->id }}"
             data-sort="{{ $category->sort_order }}">
            
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-teal-500/20 flex items-center justify-center flex-shrink-0">
                        <iconify-icon icon="mdi:tag" width="16" height="16" class="text-teal-400"></iconify-icon>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-white font-semibold text-sm">{{ $category->name }}</h3>
                        <p class="text-xs text-gray-500">{{ $category->faqs_count ?? 0 }} FAQ</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 ml-2">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium status-badge {{ $category->is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                        {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                    
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-all duration-300">
                        <button onclick="openCategoryModal({{ $category->id }})" 
                                class="p-1.5 bg-yellow-600/30 hover:bg-yellow-600/50 text-yellow-400 rounded-lg transition-all duration-300">
                            <iconify-icon icon="mdi:pencil" width="15" height="15"></iconify-icon>
                        </button>
                        <button onclick="deleteCategory({{ $category->id }})" 
                                class="p-1.5 bg-red-600/30 hover:bg-red-600/50 text-red-400 rounded-lg transition-all duration-300">
                            <iconify-icon icon="mdi:delete" width="15" height="15"></iconify-icon>
                        </button>
                    </div>
                    
                    <div class="cursor-grab opacity-0 group-hover:opacity-100 transition-all duration-300 ml-1">
                        <iconify-icon icon="mdi:drag-horizontal" width="20" height="20" class="text-gray-500"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-dashed border-gray-700 rounded-2xl p-12 text-center backdrop-blur-sm">
                <div class="relative inline-block">
                    <div class="absolute inset-0 bg-teal-500 blur-3xl opacity-20 rounded-full"></div>
                    <div class="relative bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                        <iconify-icon icon="mdi:tag-off" width="32" height="32" class="text-gray-600"></iconify-icon>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Belum Ada Kategori</h3>
                <p class="text-gray-500 text-sm max-w-xs mx-auto mb-4">
                    Anda belum menambahkan kategori FAQ. Silakan tambah kategori baru.
                </p>
                <button onclick="openCategoryModal()" 
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300">
                    <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                    Tambah Kategori
                </button>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Total Count -->
    <div class="mt-6 p-4 bg-gray-800/50 rounded-xl border border-gray-700/50">
        <div class="flex items-center gap-2 text-gray-400 text-sm">
            <iconify-icon icon="mdi:information" width="16" height="16"></iconify-icon>
            <span>Total {{ $categories->count() }} kategori</span>
        </div>
    </div>
</div>

<!-- MODAL FORM KATEGORI -->
<div id="categoryModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md transition-all duration-300">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-md rounded-2xl border border-gray-700/50 shadow-2xl mx-4 transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-teal-500/10 rounded-lg">
                    <iconify-icon id="categoryModalIcon" icon="mdi:tag-plus" width="24" height="24" class="text-teal-400"></iconify-icon>
                </div>
                <h2 id="categoryModalTitle" class="text-lg sm:text-xl font-bold text-white">Tambah Kategori</h2>
            </div>
            <button onclick="closeCategoryModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <!-- Modal Body -->
        <form id="categoryForm" method="POST">
            @csrf
            <!-- 🔥 METHOD AKAN DIISI OLEH JAVASCRIPT -->
            <input type="hidden" name="_method" id="categoryFormMethod" value="POST">
            <input type="hidden" name="category_id" id="categoryId">

            <div class="p-6 space-y-4">
                <!-- Nama Kategori -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:format-title" width="14" height="14"></iconify-icon>
                        Nama Kategori <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="name" id="categoryName" 
                           placeholder="Contoh: Pelatihan, Magang, Wisuda"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition text-sm"
                           required>
                </div>

                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:translate" width="14" height="14"></iconify-icon>
                        Nama Kategori (Jepang)
                    </label>
                    <input type="text" name="name_jp" id="categoryNameJp" 
                        placeholder="例: トレーニング, インターンシップ, 卒業式"
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition text-sm">
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:eye" width="14" height="14"></iconify-icon>
                        Status
                    </label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 text-white cursor-pointer">
                            <input type="checkbox" name="is_active" id="categoryIsActive" value="1" checked
                                   class="w-4 h-4 text-teal-600 bg-gray-700 border-gray-600 rounded focus:ring-teal-500">
                            <span class="text-sm">Aktif</span>
                        </label>
                    </div>
                </div>

                <!-- Info -->
                <div class="bg-teal-500/5 border border-teal-500/20 rounded-lg p-3 flex items-start gap-2">
                    <iconify-icon icon="mdi:information" width="16" height="16" class="text-teal-400 flex-shrink-0 mt-0.5"></iconify-icon>
                    <p class="text-gray-400 text-xs">
                        Field dengan tanda <span class="text-red-400">*</span> wajib diisi. Kategori yang sudah memiliki FAQ tidak dapat dihapus.
                    </p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 p-4 border-t border-gray-700/50">
                <button type="button" onclick="closeCategoryModal()" 
                        class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                    Batal
                </button>
                <button type="submit" id="categorySubmitBtn"
                        class="px-6 py-2.5 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2 shadow-lg shadow-teal-900/20">
                    <iconify-icon icon="mdi:content-save" width="16" height="16"></iconify-icon>
                    <span id="categorySubmitText">Simpan Kategori</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div id="deleteModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md transition-all duration-300">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-md rounded-2xl border border-gray-700/50 shadow-2xl mx-4 transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-3 bg-red-500/10 rounded-full">
                    <iconify-icon icon="mdi:alert" width="28" height="28" class="text-red-400"></iconify-icon>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Hapus Kategori</h3>
                    <p class="text-sm text-gray-400">Apakah Anda yakin?</p>
                </div>
            </div>
            <p class="text-gray-300 text-sm mb-6" id="deleteMessage">Kategori yang dihapus tidak dapat dikembalikan.</p>
            
            {{-- 🔥 FORM DELETE DENGAN METHOD DELETE --}}
            <form id="deleteForm" method="POST" action="">
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
    .category-item {
        transition: all 0.3s ease;
    }
    .category-item:hover {
        transform: translateX(4px);
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
    const categories = @json($categories);

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
    // SORTABLE
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const grid = document.getElementById('categoriesGrid');
        if (grid) {
            new Sortable(grid, {
                animation: 150,
                handle: '.cursor-grab',
                ghostClass: 'sortable-ghost',
                onEnd: function() { updateCategoryOrder(); }
            });
        }
    });

    function updateCategoryOrder() {
        const items = document.querySelectorAll('.category-item');
        const orders = [];
        items.forEach((item, index) => {
            const id = item.dataset.id;
            if (id) orders.push({ id: parseInt(id), sort_order: index + 1 });
        });
        if (orders.length === 0) return;
        fetch('{{ route("admin.faq.categories.update-order") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ orders: orders })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                orders.forEach(order => {
                    const item = document.querySelector(`.category-item[data-id="${order.id}"]`);
                    if (item) item.dataset.sort = order.sort_order;
                });
                showNotification('Urutan kategori berhasil diperbarui', 'success');
            }
        })
        .catch(error => console.error('Error updating order:', error));
    }

    // ============================================
    // TOGGLE ACTIVE
    // ============================================
    function toggleCategoryActive(id) {
        fetch(`/admin/faq/categories/${id}/toggle-active`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = document.querySelector(`.category-item[data-id="${id}"]`);
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
    function openCategoryModal(id = null) {
        const modal = document.getElementById('categoryModal');
        const modalContent = modal.querySelector('.modal-show');
        const form = document.getElementById('categoryForm');
        const formMethod = document.getElementById('categoryFormMethod');
        const submitText = document.getElementById('categorySubmitText');
        const modalTitle = document.getElementById('categoryModalTitle');
        const modalIcon = document.getElementById('categoryModalIcon');

        form.reset();
        document.getElementById('categoryIsActive').checked = true;
        document.getElementById('categoryId').value = '';
        document.getElementById('categoryNameJp').value = ''; // Reset field Jepang

        if (id) {
            const category = categories.find(c => c.id === id);
            if (category) {
                modalTitle.textContent = 'Edit Kategori';
                modalIcon.setAttribute('icon', 'mdi:pencil');
                submitText.textContent = 'Update Kategori';
                formMethod.value = 'PUT';
                form.action = `/admin/faq/categories/${id}`;
                
                document.getElementById('categoryName').value = category.name;
                document.getElementById('categoryNameJp').value = category.name_jp || '';
                document.getElementById('categoryIsActive').checked = category.is_active;
                document.getElementById('categoryId').value = category.id;
            }
        } else {
            modalTitle.textContent = 'Tambah Kategori';
            modalIcon.setAttribute('icon', 'mdi:tag-plus');
            submitText.textContent = 'Simpan Kategori';
            formMethod.value = 'POST';
            form.action = '{{ route("admin.faq.categories.store") }}';
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeCategoryModal() {
        const modal = document.getElementById('categoryModal');
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
    function deleteCategory(id) {
        const category = categories.find(c => c.id === id);
        if (!category) {
            showNotification('Kategori tidak ditemukan', 'error');
            return;
        }

        // Cek apakah kategori memiliki FAQ
        if ((category.faqs_count || 0) > 0) {
            showNotification(`❌ Kategori "${category.name}" memiliki ${category.faqs_count} FAQ. Pindahkan atau hapus FAQ terlebih dahulu.`, 'error');
            return;
        }

        const modal = document.getElementById('deleteModal');
        const modalContent = modal.querySelector('.modal-show');
        const deleteForm = document.getElementById('deleteForm');
        const deleteMessage = document.getElementById('deleteMessage');

        // 🔥 GUNAKAN ROUTE NAME
        const url = `{{ route('admin.faq.categories.destroy', ['category' => ':id']) }}`.replace(':id', id);
        deleteForm.action = url;
        deleteMessage.textContent = `Kategori "${category.name}" akan dihapus permanen. Apakah Anda yakin?`;

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
    document.getElementById('categoryForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const submitBtn = document.getElementById('categorySubmitBtn');
        const submitText = document.getElementById('categorySubmitText');

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
                closeCategoryModal();
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification(data.message || 'Terjadi kesalahan', 'error');
                submitBtn.disabled = false;
                submitText.textContent = document.getElementById('categoryId').value ? 'Update Kategori' : 'Simpan Kategori';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan pada server', 'error');
            submitBtn.disabled = false;
            submitText.textContent = document.getElementById('categoryId').value ? 'Update Kategori' : 'Simpan Kategori';
        });
    });

    // ============================================
    // DELETE FORM SUBMIT
    // ============================================
    document.getElementById('deleteForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<iconify-icon icon="mdi:loading" width="16" height="16" class="animate-spin"></iconify-icon> Menghapus...';
        
        // 🔥 AMBIL URL DARI ACTION FORM
        const url = this.action;
        
        fetch(url, {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    let errorMsg = 'Server error: ' + response.status;
                    try {
                        const data = JSON.parse(text);
                        errorMsg = data.message || errorMsg;
                    } catch (e) {}
                    throw new Error(errorMsg);
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                closeDeleteModal();
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification(data.message || 'Terjadi kesalahan', 'error');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Gagal menghapus kategori: ' + error.message, 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });

    // ============================================
    // KEYBOARD SHORTCUTS
    // ============================================
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCategoryModal();
            closeDeleteModal();
        }
    });

    document.querySelectorAll('.modal').forEach(modal => {
        modal?.addEventListener('click', function(e) {
            if (e.target === this) {
                if (this.id === 'categoryModal') closeCategoryModal();
                if (this.id === 'deleteModal') closeDeleteModal();
            }
        });
    });

    // ============================================
    // EXPOSE FUNCTIONS
    // ============================================
    window.openCategoryModal = openCategoryModal;
    window.closeCategoryModal = closeCategoryModal;
    window.toggleCategoryActive = toggleCategoryActive;
    window.deleteCategory = deleteCategory;
    window.closeDeleteModal = closeDeleteModal;
    window.showNotification = showNotification;
    window.dismissNotification = dismissNotification;
</script>
@endsection