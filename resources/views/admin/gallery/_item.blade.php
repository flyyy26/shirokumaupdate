<div class="gallery-item group bg-gradient-to-br from-gray-800/90 to-gray-900/90 rounded-xl border border-gray-700/50 shadow-xl backdrop-blur-sm overflow-hidden hover:border-blue-500/50 transition-all duration-300" 
     data-id="{{ $gallery->id }}"
     data-category="{{ $gallery->category?->slug ?? 'uncategorized' }}"
     data-sort="{{ $gallery->sort_order }}">
    
    <div class="relative aspect-square overflow-hidden bg-gray-800">
        @if($gallery->is_video)
            <!-- 🔥 TAMPILKAN VIDEO -->
            <iframe src="{{ $gallery->youtube_embed_url }}" 
                    class="w-full h-full"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
            </iframe>
        @elseif($gallery->image)
            <img src="{{ $gallery->image_url }}" 
                 alt="{{ $gallery->title ?? 'Foto Galeri' }}"
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
        @else
            <div class="w-full h-full flex items-center justify-center text-4xl text-gray-600">
                <iconify-icon icon="mdi:image-off" width="48" height="48"></iconify-icon>
            </div>
        @endif
        
        <div class="absolute right-2 bottom-2">
            <button onclick="deleteGallery({{ $gallery->id }})" 
                    class="p-1.5 bg-red-600/30 hover:bg-red-600/50 text-red-400 rounded-lg transition-all duration-300">
                <iconify-icon icon="mdi:delete" width="14" height="14"></iconify-icon>
            </button>
        </div>

        <div class="absolute top-2 left-2 flex gap-1">
            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-blue-500/80 text-white backdrop-blur-sm">
                {{ $gallery->category_name }}
            </span>
            @if($gallery->is_video)
            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-500/80 text-white backdrop-blur-sm flex items-center gap-1">
                <iconify-icon icon="mdi:youtube" width="12" height="12"></iconify-icon>
                Video
            </span>
            @endif
        </div>

        <div class="absolute top-2 right-2">
            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $gallery->is_active ? 'bg-green-500/80 text-white' : 'bg-red-500/80 text-white' }} backdrop-blur-sm">
                {{ $gallery->is_active ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>

        <div class="absolute bottom-2 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300 cursor-grab">
            <div class="bg-black/50 backdrop-blur-sm p-1 rounded-lg">
                <iconify-icon icon="mdi:drag-horizontal" width="20" height="20" class="text-white/70"></iconify-icon>
            </div>
        </div>
    </div>
</div>