@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-0 md:rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <iconify-icon icon="mdi:briefcase" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Manajemen Lowongan</h1>
                    <p class="text-indigo-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Kelola lowongan pekerjaan</p>
                </div>
            </div>
            
            <button onclick="openJobModal()" 
                    class="w-full sm:w-auto bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm sm:text-base">
                <iconify-icon icon="mdi:plus" width="18" height="18" class="sm:w-5 sm:h-5"></iconify-icon>
                <span>Tambah Lowongan</span>
            </button>
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

    <!-- Job List -->
    <div id="jobList" class="space-y-3">
        @forelse($jobs as $job)
        <div class="job-item group bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-xl border border-gray-700/50 shadow-xl backdrop-blur-sm p-4 hover:border-indigo-500/50 transition-all duration-300 cursor-grab"
             data-id="{{ $job->id }}"
             data-sort="{{ $job->sort_order }}">
            
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 flex-wrap">
                        <div class="cursor-grab opacity-0 group-hover:opacity-100 transition-opacity">
                            <iconify-icon icon="mdi:drag-horizontal" width="20" height="20" class="text-gray-500"></iconify-icon>
                        </div>
                        <div class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center flex-shrink-0">
                            <iconify-icon icon="mdi:briefcase" width="16" height="16" class="text-indigo-400"></iconify-icon>
                        </div>
                        <h3 class="text-white font-medium text-sm sm:text-base">{{ $job->title }}</h3>
                        @if($job->is_featured)
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-amber-500/20 text-amber-400 border border-amber-500/20">⭐ Unggulan</span>
                        @endif
                    </div>
                    <div class="mt-1 flex flex-wrap gap-2 text-xs text-gray-400">
                        <span>{{ $job->location ?? 'Lokasi tidak tersedia' }}</span>
                        <span>•</span>
                        <span>{{ $job->position_type ?? 'Tipe tidak tersedia' }}</span>
                        <span>•</span>
                        <span>{{ $job->deadline_display }}</span>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 flex-shrink-0">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $job->is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                        {{ $job->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                    
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button onclick="toggleFeatured({{ $job->id }})" 
                                class="p-1.5 rounded-lg transition-all duration-300 {{ $job->is_featured ? 'bg-amber-500/30 text-amber-400 hover:bg-amber-500/50' : 'bg-gray-600/30 text-gray-400 hover:bg-gray-600/50' }}">
                            <iconify-icon icon="{{ $job->is_featured ? 'mdi:star' : 'mdi:star-outline' }}" width="15" height="15"></iconify-icon>
                        </button>
                        <button onclick="toggleActive({{ $job->id }})" 
                                class="p-1.5 rounded-lg transition-all duration-300 {{ $job->is_active ? 'bg-green-500/30 text-green-400 hover:bg-green-500/50' : 'bg-red-500/30 text-red-400 hover:bg-red-500/50' }}">
                            <iconify-icon icon="{{ $job->is_active ? 'mdi:eye' : 'mdi:eye-off' }}" width="15" height="15"></iconify-icon>
                        </button>
                        <button onclick="openJobModal({{ $job->id }})" 
                                class="p-1.5 bg-yellow-600/30 hover:bg-yellow-600/50 text-yellow-400 rounded-lg transition-all duration-300">
                            <iconify-icon icon="mdi:pencil" width="15" height="15"></iconify-icon>
                        </button>
                        <button onclick="deleteJob({{ $job->id }})" 
                                class="p-1.5 bg-red-600/30 hover:bg-red-600/50 text-red-400 rounded-lg transition-all duration-300">
                            <iconify-icon icon="mdi:delete" width="15" height="15"></iconify-icon>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-dashed border-gray-700 rounded-2xl p-12 text-center backdrop-blur-sm">
                <div class="relative inline-block">
                    <div class="absolute inset-0 bg-indigo-500 blur-3xl opacity-20 rounded-full"></div>
                    <div class="relative bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-700">
                        <iconify-icon icon="mdi:briefcase-off" width="32" height="32" class="text-gray-600"></iconify-icon>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Belum Ada Lowongan</h3>
                <p class="text-gray-500 text-sm max-w-xs mx-auto mb-4">
                    Anda belum menambahkan lowongan pekerjaan. Silakan tambah lowongan baru.
                </p>
                <button onclick="openJobModal()" 
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300">
                    <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                    Tambah Lowongan
                </button>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $jobs->links() }}
    </div>
</div>

<!-- ============================================ -->
<!-- MODAL FORM JOB VACANCY -->
<!-- ============================================ -->
<div id="jobModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md transition-all duration-300">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-2xl rounded-2xl border border-gray-700/50 shadow-2xl mx-4 transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-500/10 rounded-lg">
                    <iconify-icon id="modalIcon" icon="mdi:briefcase-plus" width="24" height="24" class="text-indigo-400"></iconify-icon>
                </div>
                <h2 id="modalTitle" class="text-lg sm:text-xl font-bold text-white">Tambah Lowongan</h2>
            </div>
            <button onclick="closeJobModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <form id="jobForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="job_id" id="jobId">

            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <!-- Title -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium">Judul Posisi <span class="text-red-400">*</span></label>
                    <input type="text" name="title" id="title" 
                           placeholder="Contoh: Scaffolding, Printing, Welding"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition text-sm"
                           required>
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                              placeholder="Deskripsi lowongan pekerjaan"
                              class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition text-sm"></textarea>
                </div>

                <!-- Requirements -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium">Persyaratan</label>
                    <div id="requirementsContainer" class="space-y-2">
                        <div class="flex gap-2 requirement-item">
                            <input type="text" name="requirements[]" 
                                   placeholder="Contoh: Pria"
                                   class="flex-1 bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition text-sm">
                            <button type="button" onclick="removeRequirement(this)" 
                                    class="px-3 py-2 bg-red-600/30 hover:bg-red-600/50 text-red-400 rounded-lg transition">
                                <iconify-icon icon="mdi:close" width="18" height="18"></iconify-icon>
                            </button>
                        </div>
                    </div>
                    <button type="button" onclick="addRequirement()" 
                            class="text-indigo-400 hover:text-indigo-300 text-sm flex items-center gap-1 transition">
                        <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                        Tambah Persyaratan
                    </button>
                </div>

                <!-- Location & Position Type -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium">Lokasi</label>
                        <input type="text" name="location" id="location" 
                               placeholder="Contoh: Jepang, Indonesia"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition text-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium">Tipe Posisi</label>
                        <select name="position_type" id="position_type" 
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition text-sm">
                            <option value="">Pilih Tipe</option>
                            <option value="Full-time">Full-time</option>
                            <option value="Part-time">Part-time</option>
                            <option value="Contract">Contract</option>
                            <option value="Internship">Internship</option>
                        </select>
                    </div>
                </div>

                <!-- Gender, Age, Education -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium">Gender</label>
                        <select name="gender" id="gender" 
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition text-sm">
                            <option value="">Semua</option>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium">Usia Min</label>
                        <input type="number" name="min_age" id="min_age" 
                               placeholder="18"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition text-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium">Usia Max</label>
                        <input type="number" name="max_age" id="max_age" 
                               placeholder="27"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition text-sm">
                    </div>
                </div>

                <!-- Education & Salary -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium">Pendidikan</label>
                        <select name="education" id="education" 
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition text-sm">
                            <option value="">Pilih Pendidikan</option>
                            <option value="SMA/K">SMA/K</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium">Gaji</label>
                        <input type="text" name="salary" id="salary" 
                               placeholder="Contoh: Rp 5.000.000 - Rp 7.000.000"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition text-sm">
                    </div>
                </div>

                <!-- Deadline & Image -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium">Deadline</label>
                        <input type="date" name="deadline" id="deadline" 
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition text-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-gray-300 text-sm font-medium">Gambar</label>
                        <input type="file" name="image" id="image" accept="image/*"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:text-white hover:file:bg-indigo-700">
                        <p class="text-xs text-gray-500">Format: JPG, PNG, WebP. Max 2MB</p>
                        <div id="currentPhoto" class="hidden mt-2">
                            <p class="text-xs text-gray-400">Gambar saat ini:</p>
                            <img id="currentPhotoImg" src="" class="w-16 h-16 object-cover rounded-lg mt-1">
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium">Status</label>
                    <div class="flex flex-wrap items-center gap-6">
                        <label class="flex items-center gap-2 text-white cursor-pointer">
                            <input type="checkbox" name="is_active" id="is_active" value="1" checked
                                   class="w-4 h-4 text-indigo-600 bg-gray-700 border-gray-600 rounded focus:ring-indigo-500">
                            <span class="text-sm">Aktif</span>
                        </label>
                        <label class="flex items-center gap-2 text-white cursor-pointer">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                   class="w-4 h-4 text-amber-500 bg-gray-700 border-gray-600 rounded focus:ring-amber-500">
                            <span class="text-sm">⭐ Unggulan</span>
                        </label>
                    </div>
                </div>

                <!-- Info -->
                <div class="bg-indigo-500/5 border border-indigo-500/20 rounded-lg p-3 flex items-start gap-2">
                    <iconify-icon icon="mdi:information" width="16" height="16" class="text-indigo-400 flex-shrink-0 mt-0.5"></iconify-icon>
                    <p class="text-gray-400 text-xs">
                        Field dengan tanda <span class="text-red-400">*</span> wajib diisi.
                    </p>
                </div>
            </div>

            <div class="flex justify-end gap-3 p-4 border-t border-gray-700/50">
                <button type="button" onclick="closeJobModal()" 
                        class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                    Batal
                </button>
                <button type="submit" id="submitBtn"
                        class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2 shadow-lg shadow-indigo-900/20">
                    <iconify-icon icon="mdi:content-save" width="16" height="16"></iconify-icon>
                    <span id="submitText">Simpan Lowongan</span>
                </button>
            </div>
        </form>
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
                    <h3 class="text-lg font-bold text-white">Hapus Lowongan</h3>
                    <p class="text-sm text-gray-400">Apakah Anda yakin?</p>
                </div>
            </div>
            <p class="text-gray-300 text-sm mb-6">Lowongan yang dihapus tidak dapat dikembalikan.</p>
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
    .job-item { transition: all 0.3s ease; }
    .job-item:hover { transform: translateX(4px); }
    .sortable-ghost { opacity: 0.4; border: 2px dashed #6366f1; }
</style>

<script>
    // ============================================
    // DATA
    // ============================================
    const jobs = @json($jobs->items());

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
    // REQUIREMENTS
    // ============================================
    function addRequirement(value = '') {
        const container = document.getElementById('requirementsContainer');
        const div = document.createElement('div');
        div.className = 'flex gap-2 requirement-item';
        div.innerHTML = `
            <input type="text" name="requirements[]" value="${value}" 
                   placeholder="Contoh: Pria"
                   class="flex-1 bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition text-sm">
            <button type="button" onclick="removeRequirement(this)" 
                    class="px-3 py-2 bg-red-600/30 hover:bg-red-600/50 text-red-400 rounded-lg transition">
                <iconify-icon icon="mdi:close" width="18" height="18"></iconify-icon>
            </button>
        `;
        container.appendChild(div);
    }

    function removeRequirement(button) {
        const container = document.getElementById('requirementsContainer');
        if (container.querySelectorAll('.requirement-item').length > 1) {
            button.closest('.requirement-item').remove();
        } else {
            showNotification('Minimal 1 persyaratan harus diisi', 'error');
        }
    }

    // ============================================
    // SORTABLE
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const list = document.getElementById('jobList');
        if (list) {
            new Sortable(list, {
                animation: 150,
                handle: '.cursor-grab',
                ghostClass: 'sortable-ghost',
                onEnd: function() { updateOrder(); }
            });
        }
    });

    function updateOrder() {
        const items = document.querySelectorAll('.job-item');
        const orders = [];
        items.forEach((item, index) => {
            const id = item.dataset.id;
            if (id) orders.push({ id: parseInt(id), sort_order: index + 1 });
        });
        if (orders.length === 0) return;
        fetch('{{ route("admin.job-vacancy.update-order") }}', {
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
                    const item = document.querySelector(`.job-item[data-id="${order.id}"]`);
                    if (item) item.dataset.sort = order.sort_order;
                });
                showNotification('Urutan lowongan berhasil diperbarui', 'success');
            }
        })
        .catch(error => console.error('Error updating order:', error));
    }

    // ============================================
    // TOGGLE ACTIVE - PERBAIKI
    // ============================================
    function toggleActive(id) {
        fetch(`/job-vacancy/${id}/toggle-active`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`Server error: ${response.status} - ${text.substring(0, 100)}`);
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const item = document.querySelector(`.job-item[data-id="${id}"]`);
                if (item) {
                    const badge = item.querySelector('.px-2.py-0.5.rounded-full.text-xs.font-medium:first-child');
                    const iconBtn = item.querySelector('.bg-green-500\\/30, .bg-red-500\\/30');
                    if (data.is_active) {
                        badge.textContent = 'Aktif';
                        badge.className = 'px-2 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-400';
                    } else {
                        badge.textContent = 'Nonaktif';
                        badge.className = 'px-2 py-0.5 rounded-full text-xs font-medium bg-red-500/20 text-red-400';
                    }
                }
                showNotification(data.message, 'success');
            } else {
                showNotification(data.message || 'Terjadi kesalahan', 'error');
            }
        })
        .catch(error => {
            console.error('Error toggling active:', error);
            showNotification('Error: ' + error.message, 'error');
        });
    }

    // ============================================
    // TOGGLE FEATURED - PERBAIKI
    // ============================================
    function toggleFeatured(id) {
        fetch(`/job-vacancy/${id}/toggle-featured`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`Server error: ${response.status} - ${text.substring(0, 100)}`);
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const item = document.querySelector(`.job-item[data-id="${id}"]`);
                if (item) {
                    const titleDiv = item.querySelector('.flex.items-center.gap-3.flex-wrap');
                    const existingBadge = titleDiv?.querySelector('.bg-amber-500\\/20');
                    const iconBtn = item.querySelector('.bg-amber-500\\/30, .bg-gray-600\\/30');
                    
                    if (data.is_featured) {
                        if (!existingBadge) {
                            const span = document.createElement('span');
                            span.className = 'px-2 py-0.5 rounded-full text-xs font-medium bg-amber-500/20 text-amber-400 border border-amber-500/20';
                            span.textContent = '⭐ Unggulan';
                            titleDiv.appendChild(span);
                        }
                        if (iconBtn) {
                            iconBtn.className = 'p-1.5 rounded-lg transition-all duration-300 bg-amber-500/30 text-amber-400 hover:bg-amber-500/50';
                            iconBtn.querySelector('iconify-icon').setAttribute('icon', 'mdi:star');
                        }
                    } else {
                        if (existingBadge) existingBadge.remove();
                        if (iconBtn) {
                            iconBtn.className = 'p-1.5 rounded-lg transition-all duration-300 bg-gray-600/30 text-gray-400 hover:bg-gray-600/50';
                            iconBtn.querySelector('iconify-icon').setAttribute('icon', 'mdi:star-outline');
                        }
                    }
                }
                showNotification(data.message, 'success');
            } else {
                showNotification(data.message || 'Terjadi kesalahan', 'error');
            }
        })
        .catch(error => {
            console.error('Error toggling featured:', error);
            showNotification('Error: ' + error.message, 'error');
        });
    }

    // ============================================
    // MODAL FUNCTIONS
    // ============================================
    function openJobModal(id = null) {
        const modal = document.getElementById('jobModal');
        const modalContent = modal.querySelector('.modal-show');
        const form = document.getElementById('jobForm');
        const formMethod = document.getElementById('formMethod');
        const submitText = document.getElementById('submitText');
        const modalTitle = document.getElementById('modalTitle');
        const modalIcon = document.getElementById('modalIcon');

        // Reset form
        form.reset();
        document.getElementById('is_active').checked = true;
        document.getElementById('is_featured').checked = false;
        document.getElementById('jobId').value = '';
        document.getElementById('currentPhoto').classList.add('hidden');

        // Reset requirements
        document.getElementById('requirementsContainer').innerHTML = '';
        addRequirement();

        if (id) {
            const job = jobs.find(j => j.id === id);
            if (job) {
                modalTitle.textContent = 'Edit Lowongan';
                modalIcon.setAttribute('icon', 'mdi:pencil');
                submitText.textContent = 'Update Lowongan';
                formMethod.value = 'PUT';
                form.action = `/job-vacancy/${id}`;

                document.getElementById('title').value = job.title;
                document.getElementById('description').value = job.description || '';
                document.getElementById('location').value = job.location || '';
                document.getElementById('position_type').value = job.position_type || '';
                document.getElementById('gender').value = job.gender || '';
                document.getElementById('min_age').value = job.min_age || '';
                document.getElementById('max_age').value = job.max_age || '';
                document.getElementById('education').value = job.education || '';
                document.getElementById('salary').value = job.salary || '';
                document.getElementById('deadline').value = job.deadline || '';
                document.getElementById('is_active').checked = job.is_active;
                document.getElementById('is_featured').checked = job.is_featured;
                document.getElementById('jobId').value = job.id;

                // Requirements
                document.getElementById('requirementsContainer').innerHTML = '';
                if (job.requirements && job.requirements.length > 0) {
                    job.requirements.forEach(req => addRequirement(req));
                } else {
                    addRequirement();
                }

                // Image
                if (job.image) {
                    document.getElementById('currentPhotoImg').src = job.image_url;
                    document.getElementById('currentPhoto').classList.remove('hidden');
                }
            }
        } else {
            modalTitle.textContent = 'Tambah Lowongan';
            modalIcon.setAttribute('icon', 'mdi:briefcase-plus');
            submitText.textContent = 'Simpan Lowongan';
            formMethod.value = 'POST';
            form.action = '{{ route("admin.job-vacancy.store") }}';
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeJobModal() {
        const modal = document.getElementById('jobModal');
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
    function deleteJob(id) {
        const modal = document.getElementById('deleteModal');
        const modalContent = modal.querySelector('.modal-show');
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = `/job-vacancy/${id}`;
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
    // FORM SUBMIT - PERBAIKI
    // ============================================
    document.getElementById('jobForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');

        submitBtn.disabled = true;
        submitText.textContent = 'Menyimpan...';

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    let errorMsg = `Server error: ${response.status}`;
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
                closeJobModal();
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification(data.message || 'Terjadi kesalahan', 'error');
                submitBtn.disabled = false;
                submitText.textContent = document.getElementById('jobId').value ? 'Update Lowongan' : 'Simpan Lowongan';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error: ' + error.message, 'error');
            submitBtn.disabled = false;
            submitText.textContent = document.getElementById('jobId').value ? 'Update Lowongan' : 'Simpan Lowongan';
        });
    });

    // ============================================
    // DELETE FORM SUBMIT - PERBAIKI
    // ============================================
    document.getElementById('deleteForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<iconify-icon icon="mdi:loading" width="16" height="16" class="animate-spin"></iconify-icon> Menghapus...';

        fetch(this.action, {
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
                    let errorMsg = `Server error: ${response.status}`;
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
            showNotification('Error: ' + error.message, 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });

    // ============================================
    // KEYBOARD SHORTCUTS
    // ============================================
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeJobModal();
            closeDeleteModal();
        }
    });

    document.querySelectorAll('.modal').forEach(modal => {
        modal?.addEventListener('click', function(e) {
            if (e.target === this) {
                if (this.id === 'jobModal') closeJobModal();
                if (this.id === 'deleteModal') closeDeleteModal();
            }
        });
    });
</script>
@endsection