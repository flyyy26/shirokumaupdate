@extends('layouts_front.app')

@section('content_front')

<style>
/* ============================================
   LIGHTBOX MODAL - UNTUK GAMBAR & VIDEO
   ============================================ */
.lightbox_modal {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.92);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.4s ease;
    backdrop-filter: blur(10px);
}

.lightbox_modal.active {
    opacity: 1;
    visibility: visible;
}

/* ============================================
   LIGHTBOX CONTENT - LEBIH BESAR
   ============================================ */
.lightbox_content {
    position: relative;
    width: 92vw;  /* 🔥 DIPERBESAR */
    max-width: 1200px;  /* 🔥 MAKSIMAL LEBIH BESAR */
    max-height: 90vh;  /* 🔥 DIPERBESAR */
    background: transparent;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    touch-action: none;
    cursor: grab;
}

.lightbox_content:active {
    cursor: grabbing;
}

/* ============================================
   LIGHTBOX MEDIA WRAPPER
   ============================================ */
#lightboxMediaWrapper {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
}

/* ============================================
   🔥 GAMBAR DI LIGHTBOX
   ============================================ */
.lightbox_image {
    width: 100%;
    max-height: 82vh;  /* 🔥 DIPERBESAR */
    object-fit: contain;
    border-radius: 8px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8);
    cursor: grab;
    user-select: none;
}

/* ============================================
   🔥 VIDEO DI LIGHTBOX - LEBIH BESAR
   ============================================ */
.lightbox_video_wrapper {
    width: 100%;
    aspect-ratio: 16 / 9;
    max-height: 82vh;  /* 🔥 DIPERBESAR */
    background: #000;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8);
}

.lightbox_video_iframe {
    width: 100%;
    height: 100%;
    border: none;
}

/* ============================================
   🔥 TITLE DI LIGHTBOX
   ============================================ */
.lightbox_title {
    color: #ffffff;
    font-size: 18px;
    font-weight: 500;
    text-align: center;
    padding: 10px 24px;
    background: rgba(0, 0, 0, 0.6);
    border-radius: 10px;
    backdrop-filter: blur(8px);
    max-width: 80%;
    margin: 0 auto;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

/* ============================================
   LIGHTBOX CONTROLS - DIPERBESAR
   ============================================ */
.lightbox_close {
    position: fixed;
    top: 24px;
    right: 32px;
    background: rgba(0, 0, 0, 0.7);
    border: none;
    color: #ffffff;
    width: 52px;
    height: 52px;
    border-radius: 50%;
    font-size: 28px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.lightbox_close:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: rotate(90deg) scale(1.1);
}

.lightbox_prev,
.lightbox_next {
    position: fixed;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.7);
    border: none;
    color: #ffffff;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    font-size: 30px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.lightbox_prev {
    left: 24px;
}

.lightbox_next {
    right: 24px;
}

.lightbox_prev:hover,
.lightbox_next:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-50%) scale(1.1);
}

/* ============================================
   COUNTER & PROGRESS
   ============================================ */
.lightbox_counter {
    position: fixed;
    bottom: 32px;
    left: 50%;
    transform: translateX(-50%);
    color: rgba(255, 255, 255, 0.8);
    font-size: 16px;
    font-weight: 500;
    background: rgba(0, 0, 0, 0.6);
    padding: 8px 20px;
    border-radius: 24px;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    z-index: 10000;
}

.video_overlay span{
    color:white;
    font-size: .86vw;
}
.video_overlay iconify-icon{
    color:white;
    font-size: .8vw;
}

/* ============================================
   RESPONSIVE - TABLET
   ============================================ */
@media (max-width: 1024px) {
    .lightbox_content {
        width: 95vw;
        max-width: 100%;
        max-height: 88vh;
    }
    
    .lightbox_image {
        max-height: 78vh;
    }
    
    .lightbox_video_wrapper {
        max-height: 78vh;
    }
}

/* ============================================
   RESPONSIVE - MOBILE
   ============================================ */
@media (max-width: 768px) {
    .lightbox_content {
        width: 98vw;
        max-height: 85vh;
    }
    
    .lightbox_image {
        max-height: 70vh;
        border-radius: 6px;
    }
    
    .lightbox_video_wrapper {
        max-height: 70vh;
        border-radius: 8px;
    }
    
    .lightbox_title {
        font-size: 14px;
        padding: 6px 16px;
        max-width: 90%;
    }
    
    .lightbox_close {
        top: 12px;
        right: 12px;
        width: 44px;
        height: 44px;
        font-size: 22px;
    }
    
    .lightbox_prev,
    .lightbox_next {
        width: 44px;
        height: 44px;
        font-size: 20px;
    }
    
    .lightbox_prev {
        left: 10px;
    }
    
    .lightbox_next {
        right: 10px;
    }
    
    .lightbox_counter {
        font-size: 13px;
        padding: 6px 16px;
        bottom: 20px;
    }
    
    .gallery_grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 2vw;
    }
}

@media (max-width: 480px) {
    .lightbox_content {
        width: 100vw;
        max-height: 80vh;
    }
    
    .lightbox_image {
        max-height: 60vh;
        border-radius: 4px;
    }
    
    .lightbox_video_wrapper {
        max-height: 60vh;
        border-radius: 4px;
    }
    
    .lightbox_title {
        font-size: 12px;
        padding: 4px 12px;
        max-width: 95%;
    }
    
    .lightbox_close {
        top: 8px;
        right: 8px;
        width: 36px;
        height: 36px;
        font-size: 18px;
    }
    
    .lightbox_prev,
    .lightbox_next {
        width: 36px;
        height: 36px;
        font-size: 16px;
    }
    
    .lightbox_prev {
        left: 6px;
    }
    
    .lightbox_next {
        right: 6px;
    }
    
    .lightbox_counter {
        font-size: 11px;
        padding: 4px 12px;
        bottom: 14px;
    }
}
</style>

{{-- Banner --}}
<div class="banner_page" style="background-image:url(../images/gallery_page.png) !important; background-position:center !important; background-size:cover;">
    <img src="images/overlay_page.png" alt="">
</div>
<div class="divider"></div>

{{-- Gallery Layout --}}
<div class="gallery_layout">
    <img src="images/visi-misi-left.svg" alt="" class="visi_misi_left hidden_top_header">
    <img src="images/visi-misi-right.svg" alt="" class="visi_misi_right hidden_top_header">

    {{-- Header --}}
    <div class="gallery_header">
        <h1>Galeri Kami</h1>
        <p>Dokumentasi kegiatan pelatihan, magang, dan momen berharga bersama LPK SHIROKUMA.</p>
    </div>

    {{-- Filter Categories --}}
    <div class="gallery_categories">
        <button class="gallery_cat_btn active" data-category="all" onclick="filterGallery('all')">Semua</button>
        @foreach($categories as $cat)
        <button class="gallery_cat_btn" data-category="{{ $cat->slug }}" onclick="filterGallery('{{ $cat->slug }}')">{{ $cat->name }}</button>
        @endforeach
    </div>

    {{-- Gallery Grid - 5 Columns --}}
    <div class="gallery_grid" id="galleryGrid">
        @foreach($galleries as $gallery)
            @if($gallery->is_video)
                <!-- 🔥 TAMPILKAN VIDEO -->
                <div class="gallery_item video_item" 
                     data-category="{{ $gallery->category?->slug ?? 'uncategorized' }}"
                     data-type="video"
                     data-video="{{ $gallery->youtube_embed_url }}"
                     data-title="{{ $gallery->title ?? 'Video Galeri' }}">
                    <div class="gallery_image" onclick="openVideoLightbox(this)">
                        <img src="{{ $gallery->youtube_thumbnail ?? asset('images/video-placeholder.jpg') }}" 
                             alt="{{ $gallery->title ?? 'Video Galeri' }}" 
                             loading="lazy">
                        <div class="gallery_overlay video_overlay">
                            <iconify-icon icon="mdi:play-circle" class="overlay_icon play_icon"></iconify-icon>
                            <span class="video_label">Video</span>
                        </div>
                    </div>
                </div>
            @else
                <!-- 🔥 TAMPILKAN GAMBAR -->
                <div class="gallery_item" 
                     data-category="{{ $gallery->category?->slug ?? 'uncategorized' }}"
                     data-type="image"
                     data-image="{{ $gallery->image_url }}"
                     data-title="{{ $gallery->title ?? 'Foto Galeri' }}">
                    <div class="gallery_image" onclick="openLightbox(this)">
                        <img src="{{ $gallery->image_url }}" 
                             alt="{{ $gallery->title ?? 'Foto Galeri' }}" 
                             loading="lazy">
                        <div class="gallery_overlay">
                            <iconify-icon icon="mdi:expand" class="overlay_icon"></iconify-icon>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    {{-- No Result --}}
    <div class="gallery_no_result" id="galleryNoResult" style="display: none;">
        <iconify-icon icon="mdi:image-off" class="no_result_icon"></iconify-icon>
        <h3>Tidak ada foto</h3>
        <p>Maaf, tidak ada foto dalam kategori ini. Silakan pilih kategori lain.</p>
    </div>

    {{-- Load More --}}
    <div class="gallery_load_more" id="galleryLoadMore">
        <button class="load_more_btn" onclick="loadMoreGallery()" data-category="all">
            <iconify-icon icon="mdi:reload"></iconify-icon>
            Muat Lebih Banyak
        </button>
    </div>

</div>

{{-- ============================================ --}}
{{-- LIGHTBOX MODAL UNTUK GAMBAR & VIDEO --}}
{{-- ============================================ --}}
<div class="lightbox_modal" id="lightboxModal" onclick="closeLightbox()">
    <button class="lightbox_close" onclick="event.stopPropagation(); closeLightbox()">
        <iconify-icon icon="mdi:close"></iconify-icon>
    </button>
    <button class="lightbox_prev" onclick="event.stopPropagation(); navigateLightbox(-1)">
        <iconify-icon icon="mdi:chevron-left"></iconify-icon>
    </button>
    <button class="lightbox_next" onclick="event.stopPropagation(); navigateLightbox(1)">
        <iconify-icon icon="mdi:chevron-right"></iconify-icon>
    </button>
    <div class="lightbox_content" id="lightboxContent" onclick="event.stopPropagation()">
        <div id="lightboxMediaWrapper"></div>
    </div>
    <div class="lightbox_counter" id="lightboxCounter">1 / 1</div>
</div>
<div class="divider"></div>

@endsection