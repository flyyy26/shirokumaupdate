@extends('layouts_front.app')

@section('content_front')

<style>
/* ============================================
   DOWNLOAD LAYOUT
   ============================================ */
.download_layout {
    width: 100%;
    padding: 4vw 8vw 4vw 8vw;
    background: url(../images/blue-bg.png), linear-gradient(90deg, #01102D 0%, #294966 48.56%, #08203E 100%);
    background-blend-mode: multiply;
    background-size: contain;
    background-position: center;
    min-height: 80vh;
}

/* ============================================
   DOWNLOAD HEADER
   ============================================ */
.download_header {
    text-align: center;
    margin-bottom: 2.5vw;
}

.download_header h1 {
    font-size: 3.2vw;
    font-family: techna, sans-serif;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 0.5vw;
}

.download_header p {
    font-size: 1vw;
    color: #e2e6eb;
    max-width: 40vw;
    margin: 0 auto;
    line-height: 1.7;
}

/* ============================================
   DOWNLOAD GRID
   ============================================ */
.download_grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5vw;
    margin-bottom: 2.5vw;
}

/* ============================================
   DOWNLOAD CARD
   ============================================ */
.download_card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 1vw;
    border: 0.1vw solid rgba(255, 255, 255, 0.08);
    padding: 1.5vw;
    transition: all 0.3s ease;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.download_card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 0.2vw;
    background: linear-gradient(90deg, #B7904E 26.92%, #D2B780 48.56%, #B7904E 71.63%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.download_card:hover::before {
    opacity: 1;
}

.download_card:hover {
    border-color: #B7904E;
    transform: translateY(-0.3vw);
    box-shadow: 0 0.5vw 1.5vw rgba(183, 144, 78, 0.15);
}

.download_card_icon {
    width: 5vw;
    height: 5vw;
    margin: 0 auto 0.8vw auto;
    background: rgba(183, 144, 78, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.download_card_icon iconify-icon {
    color: #D2B780;
}

.download_card_content h3 {
    font-size: 1.1vw;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 0.4vw;
}

.download_card_content p {
    font-size: 0.8vw;
    color: #c0cad8;
    line-height: 1.6;
    margin-bottom: 0.8vw;
}

.download_card_meta {
    display: flex;
    justify-content: center;
    gap: 1.2vw;
    margin-bottom: 1vw;
}

.download_card_meta .meta_item {
    display: flex;
    align-items: center;
    gap: 0.3vw;
    color: #94a3b8;
    font-size: 0.7vw;
}

.download_card_meta .meta_item iconify-icon {
    color: #B7904E;
}

.btn_download {
    display: inline-flex;
    align-items: center;
    gap: 0.4vw;
    background: linear-gradient(90deg, #B7904E 26.92%, #D2B780 48.56%, #B7904E 71.63%);
    color: #ffffff;
    padding: 0.5vw 1.8vw;
    border-radius: 2vw;
    font-size: 0.8vw;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn_download:hover {
    opacity: 0.9;
    transform: scale(1.02);
    box-shadow: 0 0.2vw 0.5vw rgba(183, 144, 78, 0.3);
}

/* ============================================
   INFO BOX
   ============================================ */
.download_info {
    margin-bottom: 2.5vw;
}

.info_box {
    display: flex;
    align-items: flex-start;
    gap: 1vw;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border-radius: 0.8vw;
    border: 0.1vw solid rgba(255, 255, 255, 0.08);
    padding: 1.2vw 1.8vw;
}

.info_box iconify-icon {
    color: #D2B780;
    flex-shrink: 0;
    margin-top: 0.1vw;
}

.info_box h4 {
    font-size: 0.95vw;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 0.2vw 0;
}

.info_box p {
    font-size: 0.8vw;
    color: #c0cad8;
    line-height: 1.6;
    margin: 0;
}

/* ============================================
   QUESTIONS
   ============================================ */
.download_questions {
    max-width: 45vw;
    margin: 0 auto;
}

.questions_box {
    text-align: center;
    padding: 2vw 2.5vw;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border-radius: 1vw;
    border: 0.1vw solid rgba(255, 255, 255, 0.08);
}

.questions_box .questions_icon {
    color: #D2B780;
    margin-bottom: 0.5vw;
}

.questions_box h3 {
    font-size: 1.2vw;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 0.3vw;
}

.questions_box p {
    font-size: 0.85vw;
    color: #c0cad8;
    margin-bottom: 1.2vw;
}

.questions_buttons {
    display: flex;
    justify-content: center;
    gap: 1vw;
}

.btn_primary {
    display: inline-flex;
    align-items: center;
    gap: 0.4vw;
    background: linear-gradient(90deg, #B7904E 26.92%, #D2B780 48.56%, #B7904E 71.63%);
    color: #ffffff;
    padding: 0.5vw 1.8vw;
    border-radius: 0.6vw;
    font-size: 0.8vw;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn_primary:hover {
    opacity: 0.9;
    transform: scale(1.02);
    box-shadow: 0 0.2vw 0.5vw rgba(183, 144, 78, 0.3);
}

.btn_secondary {
    display: inline-flex;
    align-items: center;
    gap: 0.4vw;
    background: #25D366;
    color: #ffffff;
    padding: 0.5vw 1.8vw;
    border-radius: 0.6vw;
    font-size: 0.8vw;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn_secondary:hover {
    background: #1da851;
    transform: scale(1.02);
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .download_layout {
        padding: 8vw 6vw 8vw 6vw;
    }

    .download_header h1 {
        font-size: 7vw;
        margin-bottom: 1.5vw;
    }

    .download_header p {
        font-size: 2.4vw;
        max-width: 85vw;
    }

    .download_grid {
        grid-template-columns: 1fr;
        gap: 3vw;
        margin-top:8vw;
    }

    .download_card {
        padding: 4vw;
        border-radius: 2.5vw;
    }

    .download_card::before {
        height: 0.4vw;
    }

    .download_card_icon {
        width: 12vw;
        height: 12vw;
        margin-bottom: 1.5vw;
    }

    .download_card_icon iconify-icon {
        font-size: 6vw;
    }

    .download_card_content h3 {
        font-size: 4vw;
        margin-bottom: 1.8vw;
    }

    .download_card_content p {
        font-size: 3.2vw;
        margin-bottom: 2.5vw;
    }

    .download_card_meta {
        gap: 4.5vw;
        margin-bottom: 4.5vw;
    }

    .download_card_meta .meta_item {
        font-size: 3vw;
        gap: 0.8vw;
    }

    .btn_download {
        font-size: 3.2vw;
        padding: 1.3vw 4vw;
        gap: 0.8vw;
        border-radius: 4vw;
    }

    .info_box {
        padding: 3vw;
        border-radius: 2vw;
        gap: 2vw;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .info_box h4 {
        font-size: 2.5vw;
    }

    .info_box p {
        font-size: 2vw;
    }

    .download_questions {
        max-width: 100%;
    }

    .questions_box {
        padding: 4vw;
        border-radius: 2.5vw;
    }

    .questions_box .questions_icon {
        font-size: 8vw;
        margin-bottom: 1vw;
    }

    .questions_box h3 {
        font-size: 3vw;
    }

    .questions_box p {
        font-size: 2.2vw;
        margin-bottom: 2vw;
    }

    .questions_buttons {
        flex-direction: column;
        gap: 1.5vw;
    }

    .btn_primary,
    .btn_secondary {
        font-size: 2.2vw;
        padding: 1.2vw 4vw;
        justify-content: center;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .download_grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 2vw;
    }

    .download_card_content h3 {
        font-size: 1.5vw;
    }

    .download_card_content p {
        font-size: 1vw;
    }

    .btn_download {
        font-size: 1vw;
        padding: 0.6vw 2vw;
    }
}
</style>

{{-- Banner --}}
<div class="banner_page" style="background-image:url({{ asset('images/download-page.jpg') }}) !important; background-position:center !important; background-size:cover;">
    <img src="{{ asset('images/overlay_page.png') }}" alt="">
</div>
<div class="divider"></div>

{{-- Download Layout --}}
<div class="download_layout">

    {{-- Header --}}
    <div class="download_header">
        <h1>Download Formulir</h1>
        <p>Unduh formulir yang diperlukan untuk pendaftaran dan persiapan program LPK SHIROKUMA Indonesia.</p>
    </div>

    {{-- Download Grid --}}
    <div class="download_grid">
        
        {{-- Formulir Pendaftaran --}}
        <div class="download_card">
            <div class="download_card_icon">
                <iconify-icon icon="mdi:file-document" width="48" height="48"></iconify-icon>
            </div>
            <div class="download_card_content">
                <h3>Formulir Pendaftaran</h3>
                <p>Formulir pendaftaran untuk calon peserta program LPK SHIROKUMA Indonesia.</p>
                <div class="download_card_meta">
                    <span class="meta_item">
                        <iconify-icon icon="mdi:file-outline" width="14" height="14"></iconify-icon>
                        DOCX
                    </span>
                    <span class="meta_item">
                        <iconify-icon icon="mdi:calendar" width="14" height="14"></iconify-icon>
                        Terbaru 2026
                    </span>
                </div>
                <a href="{{ route('download.formulir.file', 'formulir-pendaftaran.docx') }}" class="btn_download">
                    <iconify-icon icon="mdi:download" width="18" height="18"></iconify-icon>
                    Download
                </a>
            </div>
        </div>

        {{-- Perlengkapan Calon Siswa --}}
        <div class="download_card">
            <div class="download_card_icon">
                <iconify-icon icon="mdi:folder-account" width="48" height="48"></iconify-icon>
            </div>
            <div class="download_card_content">
                <h3>Perlengkapan Calon Siswa</h3>
                <p>Daftar perlengkapan yang harus disiapkan oleh calon siswa peserta program.</p>
                <div class="download_card_meta">
                    <span class="meta_item">
                        <iconify-icon icon="mdi:file-outline" width="14" height="14"></iconify-icon>
                        DOCX
                    </span>
                    <span class="meta_item">
                        <iconify-icon icon="mdi:calendar" width="14" height="14"></iconify-icon>
                        Terbaru 2026
                    </span>
                </div>
                <a href="{{ route('download.formulir.file', 'perlengkapan-calon-siswa.docx') }}" class="btn_download">
                    <iconify-icon icon="mdi:download" width="18" height="18"></iconify-icon>
                    Download
                </a>
            </div>
        </div>

        {{-- Memorandum of Understanding (MOU) --}}
        <div class="download_card">
            <div class="download_card_icon">
                <iconify-icon icon="mdi:handshake" width="48" height="48"></iconify-icon>
            </div>
            <div class="download_card_content">
                <h3>Memorandum of Understanding (MOU)</h3>
                <p>Dokumen perjanjian kerjasama antara peserta dan LPK SHIROKUMA Indonesia.</p>
                <div class="download_card_meta">
                    <span class="meta_item">
                        <iconify-icon icon="mdi:file-outline" width="14" height="14"></iconify-icon>
                        DOCX
                    </span>
                    <span class="meta_item">
                        <iconify-icon icon="mdi:calendar" width="14" height="14"></iconify-icon>
                        Terbaru 2026
                    </span>
                </div>
                <a href="{{ route('download.formulir.file', 'MEMORANDUM-OF-UNDERSTANDING-MOU.docx') }}" class="btn_download">
                    <iconify-icon icon="mdi:download" width="18" height="18"></iconify-icon>
                    Download
                </a>
            </div>
        </div>

    </div>

    {{-- Info Tambahan --}}
    <div class="download_info">
        <div class="info_box">
            <iconify-icon icon="mdi:information" width="24" height="24"></iconify-icon>
            <div>
                <h4>Informasi Penting</h4>
                <p>Pastikan Anda mengunduh dan mengisi formulir dengan data yang benar dan lengkap. Formulir yang sudah diisi dapat dikirimkan melalui email atau diserahkan langsung ke kantor LPK SHIROKUMA Indonesia.</p>
            </div>
        </div>
    </div>

    {{-- Still Have Questions --}}
    <div class="download_questions">
        <div class="questions_box">
            <iconify-icon icon="mdi:chat-question" width="48" height="48" class="questions_icon"></iconify-icon>
            <h3>Ada Pertanyaan?</h3>
            <p>Jika Anda memiliki pertanyaan tentang formulir atau proses pendaftaran, silakan hubungi kami.</p>
            <div class="questions_buttons">
                <a href="{{ route('contact') }}" class="btn_primary">
                    <iconify-icon icon="mdi:email" width="18" height="18"></iconify-icon>
                    Hubungi Kami
                </a>
                <a href="https://wa.me/6281224074427" class="btn_secondary" target="_blank">
                    <iconify-icon icon="mdi:whatsapp" width="18" height="18"></iconify-icon>
                    Chat WhatsApp
                </a>
            </div>
        </div>
    </div>

</div>
<div class="divider"></div>

@endsection