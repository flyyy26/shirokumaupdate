@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- Header -->
    <div class="mb-6 sm:mb-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-0 md:rounded-2xl shadow-xl p-4 sm:p-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="p-2 sm:p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <iconify-icon icon="mdi:image-multiple" width="24" height="24" class="sm:w-8 sm:h-8"></iconify-icon>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold">Manajemen Galeri</h1>
                    <p class="text-blue-100 text-xs sm:text-sm mt-0.5 sm:mt-1">Kelola foto galeri LPK SHIROKUMA</p>
                </div>
            </div>
            
            <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.gallery.categories') }}" 
                   class="flex-1 sm:flex-none bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm sm:text-base">
                    <iconify-icon icon="mdi:tag-multiple" width="18" height="18" class="sm:w-5 sm:h-5"></iconify-icon>
                    <span>Kelola Kategori</span>
                </a>
                
                <button onclick="openGalleryModal()" 
                        class="flex-1 sm:flex-none bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm sm:text-base">
                    <iconify-icon icon="mdi:plus" width="18" height="18" class="sm:w-5 sm:h-5"></iconify-icon>
                    <span>Tambah Foto</span>
                </button>
                
                <button onclick="openVideoModal()" 
                        class="flex-1 sm:flex-none bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-sm sm:text-base">
                    <iconify-icon icon="mdi:youtube" width="18" height="18" class="sm:w-5 sm:h-5"></iconify-icon>
                    <span>Tambah Video</span>
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
        <button onclick="filterGallery('all')" class="filter-btn active px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 bg-blue-600 text-white" data-filter="all">
            Semua
        </button>
        @foreach($categories as $cat)
        <button onclick="filterGallery('{{ $cat->slug }}')" 
                class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 bg-gray-700 text-gray-300 hover:bg-gray-600" 
                data-filter="{{ $cat->slug }}">
            <span class="w-2 h-2 inline-block rounded-full bg-{{ $cat->color ?? 'blue' }}-400 mr-1"></span>
            {{ $cat->name }}
        </button>
        @endforeach
    </div>

    <!-- Gallery Grid -->
    <div id="galleryGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @include('admin.gallery._item', ['gallery' => $galleries->first()])
        <!-- Items akan di-load via JavaScript -->
    </div>

    <div id="loadMoreContainer" class="mt-6 text-center">
        <button id="loadMoreBtn" 
                onclick="loadMore()"
                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2 mx-auto">
            <iconify-icon icon="mdi:reload" width="20" height="20"></iconify-icon>
            <span id="loadMoreText">Muat Lebih Banyak</span>
        </button>
        <div id="loadMoreLoading" class="hidden py-4">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-blue-500 border-t-transparent"></div>
            <p class="text-gray-400 text-sm mt-2">Memuat...</p>
        </div>
        <p id="loadMoreEnd" class="text-gray-500 text-sm hidden">Semua foto telah dimuat</p>
    </div>

    <!-- Total Count -->
    <div class="mt-6 p-4 bg-gray-800/50 rounded-xl border border-gray-700/50 flex flex-wrap items-center justify-between gap-2">
        <div class="flex items-center gap-2 text-gray-400 text-sm">
            <iconify-icon icon="mdi:information" width="16" height="16"></iconify-icon>
            <span>Total <span id="totalCount">{{ $galleries->total() }}</span> foto dalam galeri</span>
        </div>
        <a href="{{ route('admin.gallery.categories') }}" 
        class="inline-flex items-center gap-1 text-purple-400 hover:text-purple-300 text-sm transition-colors">
            <iconify-icon icon="mdi:tag-multiple" width="16" height="16"></iconify-icon>
            Kelola Kategori
            <iconify-icon icon="mdi:chevron-right" width="16" height="16"></iconify-icon>
        </a>
    </div>
</div>

<!-- ============================================ -->
<!-- MODAL TAMBAH FOTO (MULTIPLE UPLOAD) -->
<!-- ============================================ -->
<div id="galleryModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md transition-all duration-300">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-2xl rounded-2xl border border-gray-700/50 shadow-2xl mx-4 transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500/10 rounded-lg">
                    <iconify-icon id="modalIcon" icon="mdi:image-plus" width="24" height="24" class="text-blue-400"></iconify-icon>
                </div>
                <h2 id="modalTitle" class="text-lg sm:text-xl font-bold text-white">Tambah Foto</h2>
            </div>
            <button onclick="closeGalleryModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <form id="galleryForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="gallery_id" id="galleryId">

            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                <!-- Kategori -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:tag" width="14" height="14"></iconify-icon>
                        Kategori <span class="text-red-400">*</span>
                    </label>
                    <select name="category_id" id="category_id" 
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition text-sm"
                            required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- 🔥 DRAG & DROP UPLOAD AREA -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:camera" width="14" height="14"></iconify-icon>
                        Upload Foto <span class="text-red-400">*</span>
                        <span class="text-gray-500 text-xs ml-2">(bisa pilih banyak)</span>
                    </label>
                    
                    <div id="dropZone" 
                         class="border-2 border-dashed border-gray-600 rounded-xl p-8 text-center hover:border-blue-500 transition-all duration-300 cursor-pointer bg-gray-700/30 hover:bg-gray-700/50">
                        <div class="flex flex-col items-center gap-3">
                            <iconify-icon icon="mdi:cloud-upload" width="48" height="48" class="text-gray-500"></iconify-icon>
                            <p class="text-gray-400 text-sm">
                                <span class="font-semibold text-blue-400">Klik untuk upload</span> atau drag & drop
                            </p>
                            <p class="text-gray-500 text-xs">Format: JPG, PNG, WebP. Maksimal 2MB per file</p>
                            <input type="file" name="images[]" id="fileInput" accept="image/*" multiple class="hidden">
                            <button type="button" onclick="document.getElementById('fileInput').click()" 
                                    class="mt-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm transition-all">
                                Pilih File
                            </button>
                        </div>
                    </div>

                    <!-- 🔥 PREVIEW GAMBAR YANG DIPILIH -->
                    <div id="filePreviewContainer" class="grid grid-cols-3 sm:grid-cols-4 gap-3 mt-3 hidden">
                        <!-- Akan diisi oleh JavaScript -->
                    </div>

                    <!-- 🔥 INPUT TITLE PER GAMBAR (akan muncul setelah upload) -->
                    <div id="titleInputsContainer" class="mt-3 hidden">
                        <p class="text-gray-400 text-sm mb-2">Masukkan judul untuk setiap foto:</p>
                        <div id="titleInputs" class="space-y-2">
                            <!-- Akan diisi oleh JavaScript -->
                        </div>
                    </div>
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
                                   class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500">
                            <span class="text-sm">Aktif</span>
                        </label>
                    </div>
                </div>

                <!-- Info -->
                <div class="bg-blue-500/5 border border-blue-500/20 rounded-lg p-3 flex items-start gap-2">
                    <iconify-icon icon="mdi:information" width="16" height="16" class="text-blue-400 flex-shrink-0 mt-0.5"></iconify-icon>
                    <p class="text-gray-400 text-xs">
                        Field dengan tanda <span class="text-red-400">*</span> wajib diisi. Anda dapat memilih banyak foto sekaligus.
                    </p>
                </div>
            </div>

            <div class="flex justify-end gap-3 p-4 border-t border-gray-700/50">
                <button type="button" onclick="closeGalleryModal()" 
                        class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                    Batal
                </button>
                <button type="submit" id="submitBtn"
                        class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2 shadow-lg shadow-blue-900/20">
                    <iconify-icon icon="mdi:content-save" width="16" height="16"></iconify-icon>
                    <span id="submitText">Upload Foto</span>
                </button>
            </div>
        </form>
    </div>
</div>

<div id="editModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md transition-all duration-300">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-md rounded-2xl border border-gray-700/50 shadow-2xl mx-4 transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-yellow-500/10 rounded-lg">
                    <iconify-icon icon="mdi:pencil" width="24" height="24" class="text-yellow-400"></iconify-icon>
                </div>
                <h2 class="text-lg sm:text-xl font-bold text-white">Edit Foto</h2>
            </div>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="edit_gallery_id" id="editGalleryId">

            <div class="p-6 space-y-4">
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium">Judul Foto</label>
                    <input type="text" name="title" id="editTitle" 
                           placeholder="Masukkan judul foto"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm">
                </div>

                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium">Kategori</label>
                    <select name="category_id" id="editCategoryId" 
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition text-sm"
                            required>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium">Ganti Foto</label>
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-20 h-20 bg-gray-700 rounded-lg border border-gray-600 overflow-hidden flex items-center justify-center" id="editPhotoPreview">
                                <iconify-icon icon="mdi:camera-plus" width="32" height="32" class="text-gray-500"></iconify-icon>
                            </div>
                        </div>
                        <div>
                            <input type="file" name="image" id="editImage" accept="image/*" class="hidden">
                            <label for="editImage" class="inline-flex items-center gap-2 bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg cursor-pointer transition-all text-sm">
                                <iconify-icon icon="mdi:cloud-upload" width="18" height="18"></iconify-icon>
                                Pilih Foto
                            </label>
                            <p class="text-xs text-gray-500 mt-2">Kosongkan jika tidak ingin mengganti</p>
                        </div>
                    </div>
                    <div id="editCurrentPhoto" class="hidden mt-2">
                        <p class="text-xs text-gray-400">Foto saat ini:</p>
                        <img id="editCurrentPhotoImg" src="" class="w-16 h-16 object-cover rounded-lg mt-1">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium">Status</label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 text-white cursor-pointer">
                            <input type="checkbox" name="is_active" id="editIsActive" value="1"
                                   class="w-4 h-4 text-yellow-600 bg-gray-700 border-gray-600 rounded focus:ring-yellow-500">
                            <span class="text-sm">Aktif</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 p-4 border-t border-gray-700/50">
                <button type="button" onclick="closeEditModal()" 
                        class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                    Batal
                </button>
                <button type="submit"
                        class="px-6 py-2.5 bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2 shadow-lg shadow-yellow-900/20">
                    <iconify-icon icon="mdi:content-save" width="16" height="16"></iconify-icon>
                    Update Foto
                </button>
            </div>
        </form>
    </div>
</div>

<div id="videoModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 backdrop-blur-md transition-all duration-300">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 w-full max-w-md rounded-2xl border border-gray-700/50 shadow-2xl mx-4 transform scale-95 opacity-0 transition-all duration-300 modal-show">
        <div class="flex justify-between items-center p-6 border-b border-gray-700/50">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-red-500/10 rounded-lg">
                    <iconify-icon icon="mdi:youtube" width="24" height="24" class="text-red-400"></iconify-icon>
                </div>
                <h2 class="text-lg sm:text-xl font-bold text-white">Tambah Video YouTube</h2>
            </div>
            <button onclick="closeVideoModal()" class="text-gray-400 hover:text-white p-2 hover:bg-gray-700 rounded-lg transition-colors">
                <iconify-icon icon="mdi:close" width="20" height="20"></iconify-icon>
            </button>
        </div>

        <form id="videoForm" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <!-- Kategori -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:tag" width="14" height="14"></iconify-icon>
                        Kategori <span class="text-red-400">*</span>
                    </label>
                    <select name="category_id" id="videoCategoryId" 
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-red-500 focus:ring-1 focus:ring-red-500 transition text-sm"
                            required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Judul -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:format-title" width="14" height="14"></iconify-icon>
                        Judul Video
                    </label>
                    <input type="text" name="title" id="videoTitle" 
                           placeholder="Masukkan judul video"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-red-500 focus:ring-1 focus:ring-red-500 transition text-sm">
                </div>

                <!-- Link YouTube -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:link" width="14" height="14"></iconify-icon>
                        Link YouTube <span class="text-red-400">*</span>
                    </label>
                    <input type="url" name="video_url" id="videoUrl" 
                           placeholder="https://www.youtube.com/watch?v=..."
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-red-500 focus:ring-1 focus:ring-red-500 transition text-sm"
                           required>
                    <div id="videoPreviewContainer" class="mt-2 hidden">
                        <div class="aspect-video bg-gray-800 rounded-lg overflow-hidden">
                            <iframe id="videoPreview" 
                                    class="w-full h-full"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium flex items-center gap-1">
                        <iconify-icon icon="mdi:eye" width="14" height="14"></iconify-icon>
                        Status
                    </label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 text-white cursor-pointer">
                            <input type="checkbox" name="is_active" id="videoIsActive" value="1" checked
                                   class="w-4 h-4 text-red-600 bg-gray-700 border-gray-600 rounded focus:ring-red-500">
                            <span class="text-sm">Aktif</span>
                        </label>
                    </div>
                </div>

                <!-- Info -->
                <div class="bg-red-500/5 border border-red-500/20 rounded-lg p-3 flex items-start gap-2">
                    <iconify-icon icon="mdi:information" width="16" height="16" class="text-red-400 flex-shrink-0 mt-0.5"></iconify-icon>
                    <p class="text-gray-400 text-xs">
                        Masukkan link video YouTube. Support format: watch?v=, youtu.be/, shorts/, embed/
                    </p>
                </div>
            </div>

            <div class="flex justify-end gap-3 p-4 border-t border-gray-700/50">
                <button type="button" onclick="closeVideoModal()" 
                        class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 text-sm font-medium">
                    Batal
                </button>
                <button type="submit"
                        class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-lg transition-all duration-300 text-sm font-medium flex items-center gap-2 shadow-lg shadow-red-900/20">
                    <iconify-icon icon="mdi:content-save" width="16" height="16"></iconify-icon>
                    Tambah Video
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
                    <h3 class="text-lg font-bold text-white">Hapus Foto</h3>
                    <p class="text-sm text-gray-400">Apakah Anda yakin?</p>
                </div>
            </div>
            <p class="text-gray-300 text-sm mb-6">Foto yang dihapus tidak dapat dikembalikan.</p>
            
            {{-- 🔥 FORM DENGAN METHOD DELETE --}}
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')  {{-- 🔥 PASTIKAN INI ADA --}}
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
    .gallery-item { transition: all 0.3s ease; }
    .gallery-item:hover { transform: translateY(-4px); }
    .filter-btn.active { background-color: #2563eb; color: white; }
    .filter-btn:not(.active):hover { background-color: #374151; }
    .sortable-ghost { opacity: 0.4; border: 2px dashed #3b82f6; }
    #dropZone.dragover { border-color: #3b82f6; background: rgba(59, 130, 246, 0.1); }
    .preview-item { position: relative; }
    .preview-item .remove-btn { 
        position: absolute; 
        top: -6px; 
        right: -6px; 
        width: 22px; 
        height: 22px; 
        border-radius: 50%; 
        background: #ef4444; 
        color: white; 
        border: none; 
        font-size: 12px; 
        cursor: pointer; 
        display: flex; 
        align-items: center; 
        justify-content: center;
        transition: all 0.2s;
    }
    .preview-item .remove-btn:hover { transform: scale(1.1); background: #dc2626; }
</style>

<script>
    // ============================================
    // DATA
    // ============================================
    const galleries = @json($galleries->items());
    const categories = @json($categories);
    let currentFilter = 'all';
    let selectedFiles = [];
    let fileTitles = [];
    let currentPage = 1;
    let currentCategory = 'all';
    let isLoading = false;
    let hasMore = true;
    let totalItems = {{ $galleries->total() }};
    
    function openVideoModal() {
        const modal = document.getElementById('videoModal');
        const modalContent = modal.querySelector('.modal-show');
        
        document.getElementById('videoForm').reset();
        document.getElementById('videoCategoryId').value = '';
        document.getElementById('videoIsActive').checked = true;
        document.getElementById('videoPreviewContainer').classList.add('hidden');
        document.getElementById('videoPreview').src = '';
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }
    
    function closeVideoModal() {
        const modal = document.getElementById('videoModal');
        const modalContent = modal.querySelector('.modal-show');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 300);
    }
    
    // 🔥 PREVIEW VIDEO SAAT TYPING
    document.getElementById('videoUrl')?.addEventListener('input', function() {
        const url = this.value.trim();
        const previewContainer = document.getElementById('videoPreviewContainer');
        const preview = document.getElementById('videoPreview');
        
        if (url) {
            // Extract YouTube ID
            const patterns = [
                /(?:youtube\.com\/watch\?v=)([a-zA-Z0-9_-]{11})/,
                /(?:youtu\.be\/)([a-zA-Z0-9_-]{11})/,
                /(?:youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/,
                /(?:youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/,
            ];
            
            let videoId = null;
            for (const pattern of patterns) {
                const match = url.match(pattern);
                if (match) {
                    videoId = match[1];
                    break;
                }
            }
            
            if (videoId) {
                preview.src = 'https://www.youtube.com/embed/' + videoId;
                previewContainer.classList.remove('hidden');
            } else {
                previewContainer.classList.add('hidden');
            }
        } else {
            previewContainer.classList.add('hidden');
        }
    });
    
    // 🔥 VIDEO FORM SUBMIT
    document.getElementById('videoForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<iconify-icon icon="mdi:loading" width="16" height="16" class="animate-spin"></iconify-icon> Menyimpan...';
        
        const url = '{{ route("admin.gallery.video.store") }}';
        
        fetch(url, {
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
                closeVideoModal();
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
            showNotification('Terjadi kesalahan pada server', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
    
    // ============================================
    // EDIT VIDEO MODAL
    // ============================================
    function openEditVideoModal(id) {
        const gallery = galleries.find(g => g.id === id);
        if (!gallery) return;
        
        // Bisa menggunakan modal yang sama atau buat modal edit video terpisah
        // Untuk simpel, kita bisa gunakan modal edit yang sudah ada tapi disesuaikan
        openEditModal(id);
    }
    
    // 🔥 UPDATE GLOBAL WINDOW FUNCTIONS
    window.openVideoModal = openVideoModal;
    window.closeVideoModal = closeVideoModal;
    window.openEditVideoModal = openEditVideoModal;

    // ============================================
    // NOTIFICATION SYSTEM
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
            if (messageEl) {
                messageEl.textContent = message;
            }
            
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
            setTimeout(() => {
                notification.remove();
            }, 500);
        }
    }

    // ============================================
    // FILTER - OVERRIDE
    // ============================================
    function filterGallery(category) {
        currentFilter = category;
        currentCategory = category;
        currentPage = 1;
        hasMore = true;
        
        // Reset grid
        const grid = document.getElementById('galleryGrid');
        grid.innerHTML = '';
        
        // Tampilkan loading
        document.getElementById('loadMoreLoading').classList.remove('hidden');
        document.getElementById('loadMoreBtn').classList.add('hidden');
        document.getElementById('loadMoreEnd').classList.add('hidden');
        
        // Update active button
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.filter === category) {
                btn.classList.add('active');
            }
        });
        
        // Load data pertama
        loadMore(true);
    }

    // ============================================
    // 🔥 LOAD MORE
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
        
        const url = new URL('{{ route("admin.gallery.load-more") }}');
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
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const grid = document.getElementById('galleryGrid');
                
                if (reset) {
                    grid.innerHTML = '';
                }
                
                // Tambahkan item baru
                grid.insertAdjacentHTML('beforeend', data.html);
                
                // Update total
                document.getElementById('totalCount').textContent = data.total;
                totalItems = data.total;
                
                // Update state
                hasMore = data.hasMore;
                currentPage = data.currentPage + 1;
                
                // Update tombol
                loading.classList.add('hidden');
                
                const remaining = data.total - (data.currentPage * 20);
                
                if (hasMore) {
                    btn.classList.remove('hidden');
                    text.textContent = 'Muat Lebih Banyak (' + remaining + ' tersisa)';
                } else {
                    end.classList.remove('hidden');
                    btn.classList.add('hidden');
                }
                
                // Re-initialize Sortable untuk item baru
                initSortable();
                
                // Re-attach event listeners untuk item baru
                attachItemEvents();
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
    // ATTACH ITEM EVENTS (untuk item baru)
    // ============================================
    function attachItemEvents() {
        // Toggle Active
        document.querySelectorAll('[onclick*="toggleActive"]').forEach(el => {
            // Event sudah terpasang via onclick
        });
        
        // Edit Modal
        document.querySelectorAll('[onclick*="openEditModal"]').forEach(el => {
            // Event sudah terpasang via onclick
        });
        
        // Delete
        document.querySelectorAll('[onclick*="deleteGallery"]').forEach(el => {
            // Event sudah terpasang via onclick
        });
    }

    // ============================================
    // INIT SORTABLE
    // ============================================
    function initSortable() {
        const grid = document.getElementById('galleryGrid');
        if (!grid) return;
        
        // Hancurkan Sortable sebelumnya jika ada
        if (window.sortableInstance) {
            try {
                window.sortableInstance.destroy();
            } catch(e) {}
        }
        
        window.sortableInstance = new Sortable(grid, {
            animation: 150,
            handle: '.cursor-grab',
            ghostClass: 'sortable-ghost',
            onEnd: function() { 
                updateOrder(); 
            }
        });
    }

    // ============================================
    // UPDATE ORDER
    // ============================================
    function updateOrder() {
        const items = document.querySelectorAll('.gallery-item');
        const orders = [];
        
        items.forEach((item, index) => {
            const id = item.dataset.id;
            if (id) {
                orders.push({ 
                    id: parseInt(id), 
                    sort_order: index + 1 
                });
            }
        });
        
        if (orders.length === 0) return;
        
        fetch('{{ route("admin.gallery.update-order") }}', {
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
                    const item = document.querySelector(`.gallery-item[data-id="${order.id}"]`);
                    if (item) {
                        item.dataset.sort = order.sort_order;
                    }
                });
                showNotification('Urutan foto berhasil diperbarui', 'success');
            }
        })
        .catch(error => console.error('Error updating order:', error));
    }

    // ============================================
    // TOGGLE ACTIVE
    // ============================================
    function toggleActive(id) {
        fetch(`/admin/gallery/${id}/toggle-active`, {
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
                const item = document.querySelector(`.gallery-item[data-id="${id}"]`);
                if (item) {
                    const badge = item.querySelector('.absolute.top-2.right-2 span');
                    const iconBtn = item.querySelector('.absolute.inset-0 .bg-green-500\\/30, .bg-red-500\\/30');
                    
                    if (data.is_active) {
                        badge.textContent = 'Aktif';
                        badge.className = 'px-2 py-0.5 rounded-full text-xs font-medium bg-green-500/80 text-white backdrop-blur-sm';
                    } else {
                        badge.textContent = 'Nonaktif';
                        badge.className = 'px-2 py-0.5 rounded-full text-xs font-medium bg-red-500/80 text-white backdrop-blur-sm';
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
    // DELETE
    // ============================================
    function deleteGallery(id) {
        if (!id) {
            showNotification('ID foto tidak valid', 'error');
            return;
        }

        const modal = document.getElementById('deleteModal');
        const modalContent = modal.querySelector('.modal-show');
        const deleteForm = document.getElementById('deleteForm');
        
        // 🔥 GUNAKAN ROUTE NAME DENGAN REPLACE
        const url = `{{ route('admin.gallery.destroy', ['gallery' => ':id']) }}`.replace(':id', id);
        deleteForm.action = url;
        
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
    // DELETE FORM SUBMIT
    // ============================================
    document.getElementById('deleteForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<iconify-icon icon="mdi:loading" width="16" height="16" class="animate-spin"></iconify-icon> Menghapus...';

        // 🔥 AMBIL URL DARI ACTION
        const url = this.action;
        
        // 🔥 GUNAKAN METHOD DELETE BUKAN POST
        fetch(url, {
            method: 'DELETE', // 🔥 PERUBAHAN: DELETE BUKAN POST
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
                    } catch (e) {
                        errorMsg = text.substring(0, 200) || errorMsg;
                    }
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
            showNotification('Gagal menghapus foto: ' + error.message, 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });

    // ============================================
    // EDIT MODAL
    // ============================================
    function openEditModal(id) {
        const gallery = galleries.find(g => g.id === id);
        if (!gallery) return;

        const modal = document.getElementById('editModal');
        const modalContent = modal.querySelector('.modal-show');

        document.getElementById('editGalleryId').value = gallery.id;
        document.getElementById('editTitle').value = gallery.title || '';
        document.getElementById('editCategoryId').value = gallery.category_id;
        document.getElementById('editIsActive').checked = gallery.is_active;
        document.getElementById('editForm').action = `/admin/gallery/${gallery.id}`;

        if (gallery.image) {
            document.getElementById('editCurrentPhotoImg').src = gallery.image_url;
            document.getElementById('editCurrentPhoto').classList.remove('hidden');
        } else {
            document.getElementById('editCurrentPhoto').classList.add('hidden');
        }

        // Reset photo preview
        document.getElementById('editPhotoPreview').innerHTML = '<iconify-icon icon="mdi:camera-plus" width="32" height="32" class="text-gray-500"></iconify-icon>';
        document.getElementById('editImage').value = '';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
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
    // EDIT FORM SUBMIT
    // ============================================
    document.getElementById('editForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<iconify-icon icon="mdi:loading" width="16" height="16" class="animate-spin"></iconify-icon> Menyimpan...';

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
                closeEditModal();
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
            showNotification('Terjadi kesalahan pada server', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });

    // ============================================
    // DRAG & DROP UPLOAD
    // ============================================
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const filePreviewContainer = document.getElementById('filePreviewContainer');
    const titleInputsContainer = document.getElementById('titleInputsContainer');
    const titleInputs = document.getElementById('titleInputs');

    if (dropZone) {
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            if (e.dataTransfer.files.length > 0) {
                handleFiles(e.dataTransfer.files);
            }
        });

        dropZone.addEventListener('click', function() {
            fileInput.click();
        });
    }

    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                handleFiles(this.files);
            }
            this.value = '';
        });
    }

    function handleFiles(files) {
        const validFiles = [];
        const maxSize = 2 * 1024 * 1024;
        const validTypes = ['image/jpeg', 'image/png', 'image/webp'];

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (!validTypes.includes(file.type)) {
                showNotification(`File "${file.name}" bukan gambar (JPG/PNG/WebP)`, 'error');
                continue;
            }
            if (file.size > maxSize) {
                showNotification(`File "${file.name}" melebihi 2MB`, 'error');
                continue;
            }
            validFiles.push(file);
        }

        if (validFiles.length === 0) return;

        selectedFiles = validFiles;
        fileTitles = validFiles.map(() => '');

        renderFilePreviews(validFiles);
        renderTitleInputs(validFiles);

        filePreviewContainer.classList.remove('hidden');
        titleInputsContainer.classList.remove('hidden');

        document.getElementById('submitText').textContent = `Upload ${validFiles.length} Foto`;
    }

    function renderFilePreviews(files) {
        filePreviewContainer.innerHTML = '';
        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'preview-item rounded-lg overflow-hidden border border-gray-600 aspect-square bg-gray-700';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover">
                    <button type="button" class="remove-btn" onclick="removeFile(${index})">×</button>
                `;
                filePreviewContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    function renderTitleInputs(files) {
        titleInputs.innerHTML = '';
        files.forEach((file, index) => {
            const div = document.createElement('div');
            div.className = 'flex items-center gap-3';
            div.innerHTML = `
                <span class="text-gray-400 text-xs w-8">#${index + 1}</span>
                <input type="text" 
                       name="titles[]" 
                       placeholder="Judul untuk ${file.name}" 
                       class="flex-1 bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white text-sm placeholder-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                       oninput="updateTitle(${index}, this.value)">
                <span class="text-gray-500 text-xs truncate max-w-[100px]">${file.name}</span>
            `;
            titleInputs.appendChild(div);
        });
    }

    function updateTitle(index, value) {
        fileTitles[index] = value;
    }

    function removeFile(index) {
        selectedFiles.splice(index, 1);
        fileTitles.splice(index, 1);
        if (selectedFiles.length === 0) {
            filePreviewContainer.classList.add('hidden');
            titleInputsContainer.classList.add('hidden');
            document.getElementById('submitText').textContent = 'Upload Foto';
        } else {
            renderFilePreviews(selectedFiles);
            renderTitleInputs(selectedFiles);
            document.getElementById('submitText').textContent = `Upload ${selectedFiles.length} Foto`;
        }
    }

    // ============================================
    // MODAL FUNCTIONS
    // ============================================
    function openGalleryModal() {
        const modal = document.getElementById('galleryModal');
        const modalContent = modal.querySelector('.modal-show');
        
        document.getElementById('galleryForm').reset();
        document.getElementById('category_id').value = '';
        document.getElementById('is_active').checked = true;
        document.getElementById('galleryId').value = '';
        document.getElementById('modalTitle').textContent = 'Tambah Foto';
        document.getElementById('modalIcon').setAttribute('icon', 'mdi:image-plus');
        document.getElementById('submitText').textContent = 'Upload Foto';
        
        selectedFiles = [];
        fileTitles = [];
        filePreviewContainer.classList.add('hidden');
        titleInputsContainer.classList.add('hidden');
        filePreviewContainer.innerHTML = '';
        titleInputs.innerHTML = '';
        
        if (dropZone) {
            dropZone.classList.remove('dragover');
        }
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeGalleryModal() {
        const modal = document.getElementById('galleryModal');
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
    // MULTIPLE UPLOAD FORM SUBMIT
    // ============================================
    document.getElementById('galleryForm')?.addEventListener('submit', function(e) {
        e.preventDefault();

        if (selectedFiles.length === 0 && document.getElementById('fileInput')?.files?.length) {
            selectedFiles = Array.from(document.getElementById('fileInput').files);
            fileTitles = selectedFiles.map(() => '');
        }

        if (selectedFiles.length === 0) {
            showNotification('Pilih minimal 1 foto untuk diupload', 'error');
            return;
        }

        const categoryId = document.getElementById('category_id').value;
        if (!categoryId) {
            showNotification('Pilih kategori terlebih dahulu', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('category_id', categoryId);
        formData.append('is_active', document.getElementById('is_active').checked ? '1' : '0');

        selectedFiles.forEach((file, index) => {
            formData.append('images[]', file);
            formData.append('titles[]', fileTitles[index] || `Foto ${index + 1}`);
        });

        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        submitBtn.disabled = true;
        submitText.textContent = 'Uploading...';

        async function uploadInBatches(files, titles, batchSize = 10) {
            const total = files.length;
            let uploaded = 0;

            for (let i = 0; i < total; i += batchSize) {
                const batchFiles = files.slice(i, i + batchSize);
                const batchTitles = titles.slice(i, i + batchSize);

                const fd = new FormData();
                fd.append('category_id', categoryId);
                fd.append('is_active', document.getElementById('is_active').checked ? '1' : '0');

                batchFiles.forEach((file) => fd.append('images[]', file));
                batchTitles.forEach((t) => fd.append('titles[]', t || ''));

                submitText.textContent = `Uploading ${Math.min(i + batchSize, total)}/${total}...`;

                try {
                    const resp = await fetch('{{ route("admin.gallery.store") }}', {
                        method: 'POST',
                        body: fd,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const text = await resp.text();
                    let data = {};
                    try { data = JSON.parse(text); } catch (e) { data = { success: false, message: text || 'Response bukan JSON' }; }

                    if (!resp.ok || !data.success) {
                        console.error('Batch upload failed', data);
                        showNotification(data.message || 'Gagal mengunggah batch', 'error');
                        return false;
                    }

                    uploaded += batchFiles.length;
                    showNotification(`Terunggah ${uploaded}/${total} foto`, 'success');
                } catch (err) {
                    console.error('Network error during batch upload', err);
                    showNotification('Terjadi kesalahan jaringan saat upload', 'error');
                    return false;
                }
            }

            return true;
        }

        (async () => {
            console.log('Starting batched upload:', selectedFiles.length, 'files');
            const ok = await uploadInBatches(selectedFiles, fileTitles, 10);
            if (ok) {
                closeGalleryModal();
                showNotification('Semua file berhasil diunggah', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                submitBtn.disabled = false;
                submitText.textContent = `Upload ${selectedFiles.length} Foto`;
            }
        })();
    });

    // ============================================
    // KEYBOARD SHORTCUTS
    // ============================================
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeGalleryModal();
            closeEditModal();
            closeDeleteModal();
        }
    });

    // Close modal when clicking outside
    document.querySelectorAll('.modal').forEach(modal => {
        modal?.addEventListener('click', function(e) {
            if (e.target === this) {
                if (this.id === 'galleryModal') closeGalleryModal();
                if (this.id === 'editModal') closeEditModal();
                if (this.id === 'deleteModal') closeDeleteModal();
            }
        });
    });

    // ============================================
    // INIT - LOAD PERTAMA
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        // Load data pertama
        loadMore(true);
        
        // Inisialisasi event untuk form
        console.log('Admin Gallery initialized');
    });

    // ============================================
    // EXPOSE FUNCTIONS KE GLOBAL
    // ============================================
    window.filterGallery = filterGallery;
    window.loadMore = loadMore;
    window.toggleActive = toggleActive;
    window.deleteGallery = deleteGallery;
    window.closeDeleteModal = closeDeleteModal;
    window.openEditModal = openEditModal;
    window.closeEditModal = closeEditModal;
    window.openGalleryModal = openGalleryModal;
    window.closeGalleryModal = closeGalleryModal;
    window.removeFile = removeFile;
    window.updateTitle = updateTitle;
    window.showNotification = showNotification;
    window.dismissNotification = dismissNotification;
</script>
@endsection