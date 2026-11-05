@extends('layouts_front.app')

@section('content_front')

<style>
/* ============================================
   JOB DETAIL LAYOUT
   ============================================ */
.job_detail_layout {
    width: 100%;
    padding: 2vw 8vw 4vw 8vw;
    background: url(../images/blue-bg.png), linear-gradient(90deg, #01102D 0%, #294966 48.56%, #08203E 100%);
    background-blend-mode: multiply;
    background-size: contain;
    background-position: center;
    min-height: 80vh;
}

/* ============================================
   BREADCRUMB
   ============================================ */
.job_breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5vw;
    margin-bottom: 2vw;
    font-size: 0.85vw;
    color: #94a3b8;
    flex-wrap: wrap;
}

.job_breadcrumb a {
    color: #D2B780;
    text-decoration: none;
    transition: color 0.3s;
}

.job_breadcrumb a:hover {
    color: #B7904E;
    text-decoration: underline;
}

.job_breadcrumb .separator {
    color: #475569;
}

.job_breadcrumb .current {
    color: #ffffff;
}

/* ============================================
   JOB DETAIL GRID
   ============================================ */
.job_detail_grid {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 2vw;
}

/* ============================================
   MAIN CONTENT
   ============================================ */
.job_detail_main {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border-radius: 1vw;
    border: 0.1vw solid rgba(255, 255, 255, 0.08);
    padding: 2vw;
}

/* ============================================
   JOB HEADER
   ============================================ */
.job_detail_header {
    margin-bottom: 1.5vw;
}

.job_badge {
    display: flex;
    gap: 0.6vw;
    margin-bottom: 0.6vw;
    flex-wrap: wrap;
}

.job_badge span {
    display: inline-flex;
    align-items: center;
    gap: 0.3vw;
    padding: 0.2vw 0.8vw;
    border-radius: 2vw;
    font-size: 0.7vw;
    font-weight: 600;
}

.badge_featured {
    background: rgba(245, 158, 11, 0.2);
    color: #fbbf24;
    border: 0.05vw solid rgba(245, 158, 11, 0.3);
}

.badge_active {
    background: rgba(34, 197, 94, 0.2);
    color: #4ade80;
    border: 0.05vw solid rgba(34, 197, 94, 0.3);
}

.badge_expired {
    background: rgba(239, 68, 68, 0.2);
    color: #f87171;
    border: 0.05vw solid rgba(239, 68, 68, 0.3);
}

.job_detail_header h1 {
    font-size: 2.2vw;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 0.8vw;
}

.job_detail_meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1.2vw;
}

.meta_item {
    display: flex;
    align-items: center;
    gap: 0.4vw;
    color: #c0cad8;
    font-size: 0.85vw;
}

.meta_item iconify-icon {
    color: #B7904E;
}

/* ============================================
   JOB SECTION
   ============================================ */
.job_detail_section {
    margin-bottom: 1.8vw;
}

.job_detail_section h2 {
    display: flex;
    align-items: center;
    gap: 0.5vw;
    font-size: 1.2vw;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 0.8vw;
    padding-bottom: 0.4vw;
    border-bottom: 0.1vw solid rgba(255, 255, 255, 0.08);
}

.job_detail_section h2 iconify-icon {
    color: #B7904E;
}

.job_detail_section p {
    font-size: 0.9vw;
    color: #c0cad8;
    line-height: 1.8;
}

/* ============================================
   JOB REQUIREMENTS
   ============================================ */
.job_requirements {
    list-style: none;
    padding: 0;
    margin: 0;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.5vw 1.5vw;
}

.job_requirements li {
    display: flex;
    align-items: center;
    gap: 0.5vw;
    color: #c0cad8;
    font-size: 0.85vw;
    padding: 0.3vw 0;
}

.job_requirements li iconify-icon {
    color: #4ade80;
    flex-shrink: 0;
}

/* ============================================
   JOB INFO GRID
   ============================================ */
.job_detail_info {
    background: rgba(255, 255, 255, 0.03);
    border-radius: 0.6vw;
    padding: 1.2vw;
}

.info_grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1vw;
}

.info_item {
    display: flex;
    flex-direction: column;
}

.info_label {
    display: flex;
    align-items: center;
    gap: 0.3vw;
    font-size: 0.7vw;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.05vw;
    font-weight: 600;
}

.info_label iconify-icon {
    color: #B7904E;
}

.info_value {
    font-size: 0.95vw;
    color: #ffffff;
    font-weight: 500;
    margin-top: 0.2vw;
    padding-left: 1.4vw;
}

.info_value.text-expired {
    color: #f87171;
}

.expired_badge {
    color: #ef4444;
    font-size: 0.75vw;
    margin-left: 0.5vw;
}

/* ============================================
   JOB ACTIONS
   ============================================ */
.job_detail_actions {
    display: flex;
    gap: 1vw;
    margin-top: 1.5vw;
    flex-wrap: wrap;
}

.btn_apply {
    display: inline-flex;
    align-items: center;
    gap: 0.6vw;
    background: linear-gradient(90deg, #B7904E 26.92%, #D2B780 48.56%, #B7904E 71.63%);
    color: #ffffff;
    padding: 0.8vw 2vw;
    border-radius: 0.6vw;
    font-size: 0.9vw;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn_apply:hover {
    opacity: 0.9;
    transform: scale(1.02);
    box-shadow: 0 0.3vw 0.8vw rgba(183, 144, 78, 0.3);
}

.btn_expired {
    display: inline-flex;
    align-items: center;
    gap: 0.6vw;
    background: #475569;
    color: #94a3b8;
    padding: 0.8vw 2vw;
    border-radius: 0.6vw;
    font-size: 0.9vw;
    font-weight: 600;
    border: none;
    cursor: not-allowed;
}

.btn_back {
    display: inline-flex;
    align-items: center;
    gap: 0.6vw;
    color: #c0cad8;
    padding: 0.8vw 1.5vw;
    border-radius: 0.6vw;
    font-size: 0.85vw;
    font-weight: 500;
    text-decoration: none;
    border: 0.1vw solid rgba(255, 255, 255, 0.15);
    transition: all 0.3s ease;
}

.btn_back:hover {
    background: rgba(255, 255, 255, 0.05);
    border-color: #B7904E;
}

/* ============================================
   SIDEBAR
   ============================================ */
.job_detail_sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.5vw;
}

.sidebar_card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border-radius: 0.8vw;
    border: 0.1vw solid rgba(255, 255, 255, 0.08);
    padding: 1.2vw;
}

.sidebar_card_header {
    display: flex;
    align-items: center;
    gap: 0.8vw;
    margin-bottom: 1vw;
}

.company_logo {
    width: 4vw;
    height: 4vw;
    background: rgba(183, 144, 78, 0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.company_logo iconify-icon {
    color: #D2B780;
}

.sidebar_card_header h3 {
    font-size: 0.95vw;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
}

.sidebar_card_header p {
    font-size: 0.75vw;
    color: #94a3b8;
    margin: 0;
}

.sidebar_card_body {
    display: flex;
    flex-direction: column;
    gap: 0.6vw;
}

.sidebar_info {
    display: flex;
    align-items: center;
    gap: 0.6vw;
    color: #c0cad8;
    font-size: 0.8vw;
}

.sidebar_info iconify-icon {
    color: #B7904E;
    flex-shrink: 0;
}

.sidebar_card_title {
    display: flex;
    align-items: center;
    gap: 0.4vw;
    font-size: 0.9vw;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 0.8vw 0;
    padding-bottom: 0.4vw;
    border-bottom: 0.1vw solid rgba(255, 255, 255, 0.08);
}

.sidebar_card_title iconify-icon {
    color: #B7904E;
}

/* ============================================
   RELATED JOBS
   ============================================ */
.related_jobs {
    display: flex;
    flex-direction: column;
    gap: 0.6vw;
}

.related_job {
    display: flex;
    align-items: center;
    gap: 0.6vw;
    padding: 0.6vw 0.8vw;
    border-radius: 0.4vw;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 0.05vw solid transparent;
}

.related_job:hover {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(183, 144, 78, 0.3);
}

.related_job_icon {
    width: 2.2vw;
    height: 2.2vw;
    background: rgba(183, 144, 78, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.related_job_icon iconify-icon {
    color: #B7904E;
}

.related_job_info {
    flex: 1;
    min-width: 0;
}

.related_job h5 {
    font-size: 0.8vw;
    font-weight: 600;
    color: #ffffff;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.related_job span {
    display: flex;
    align-items: center;
    gap: 0.2vw;
    font-size: 0.65vw;
    color: #94a3b8;
}

.related_job .related_arrow {
    color: #475569;
    transition: color 0.3s;
    flex-shrink: 0;
}

.related_job:hover .related_arrow {
    color: #B7904E;
}

/* ============================================
   SHARE BUTTONS
   ============================================ */
.share_buttons {
    display: flex;
    gap: 0.6vw;
}

.share_btn {
    width: 2.6vw;
    height: 2.6vw;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #ffffff;
    text-decoration: none;
}

.share_btn:hover {
    transform: scale(1.1);
}

.share_btn.whatsapp {
    background: #25D366;
}
.share_btn.facebook {
    background: #1877F2;
}
.share_btn.twitter {
    background: #000000;
}
.share_btn.linkedin {
    background: #0A66C2;
}

/* ============================================
   🔥 RESPONSIVE MOBILE - PERBAIKI
   ============================================ */
@media (max-width: 768px) {
    .job_detail_layout {
        padding: 3vw 4vw 8vw 4vw;
    }

    .job_breadcrumb {
        font-size: 2.2vw;
        gap: 1vw;
        margin-bottom: 3vw;
    }

    .job_detail_grid {
        grid-template-columns: 1fr;
        gap: 4vw;
    }

    .job_detail_main {
        padding: 4vw;
        border-radius: 2.5vw;
    }

    /* Badge */
    .job_badge {
        gap: 1.5vw;
        margin-bottom: 1.5vw;
    }

    .job_badge span {
        font-size: 2vw;
        padding: 0.8vw 2.5vw;
        gap: 1vw;
        border-radius: 4vw;
    }

    /* Title */
    .job_detail_header h1 {
        font-size: 5.5vw;
        margin-bottom: 2vw;
        line-height: 1.3;
    }

    /* Meta */
    .job_detail_meta {
        gap: 2vw;
    }

    .meta_item {
        font-size: 2.2vw;
        gap: 1vw;
    }

    .meta_item iconify-icon {
        font-size: 3vw;
    }

    /* Section */
    .job_detail_section {
        margin-bottom: 3vw;
    }

    .job_detail_section h2 {
        font-size: 3.5vw;
        gap: 1.5vw;
        margin-bottom: 1.5vw;
        padding-bottom: 1vw;
    }

    .job_detail_section h2 iconify-icon {
        font-size: 4vw;
    }

    .job_detail_section p {
        font-size: 2.4vw;
        line-height: 1.8;
    }

    /* Requirements */
    .job_requirements {
        grid-template-columns: 1fr;
        gap: 1.5vw;
    }

    .job_requirements li {
        font-size: 2.2vw;
        gap: 1.5vw;
        padding: 0.5vw 0;
    }

    .job_requirements li iconify-icon {
        font-size: 3.5vw;
    }

    /* Info Grid */
    .job_detail_info {
        padding: 3vw;
        border-radius: 2vw;
    }

    .info_grid {
        grid-template-columns: 1fr 1fr;
        gap: 2vw;
    }

    .info_label {
        font-size: 2vw;
        gap: 1vw;
    }

    .info_label iconify-icon {
        font-size: 3vw;
    }

    .info_value {
        font-size: 2.4vw;
        padding-left: 3.5vw;
        margin-top: 0.5vw;
    }

    .expired_badge {
        font-size: 2vw;
    }

    /* Actions */
    .job_detail_actions {
        gap: 2vw;
        margin-top: 3vw;
        flex-direction: column;
    }

    .btn_apply,
    .btn_expired,
    .btn_back {
        padding: 2.5vw 4vw;
        font-size: 2.4vw;
        justify-content: center;
        border-radius: 1.5vw;
        gap: 1.5vw;
        width: 100%;
    }

    .btn_apply iconify-icon,
    .btn_expired iconify-icon,
    .btn_back iconify-icon {
        font-size: 4vw;
    }

    /* Sidebar */
    .job_detail_sidebar {
        gap: 3vw;
    }

    .sidebar_card {
        padding: 3.5vw;
        border-radius: 2.5vw;
    }

    .sidebar_card_header {
        gap: 2vw;
        margin-bottom: 2vw;
    }

    .company_logo {
        width: 12vw;
        height: 12vw;
    }

    .company_logo iconify-icon {
        font-size: 6vw;
    }

    .sidebar_card_header h3 {
        font-size: 3vw;
    }

    .sidebar_card_header p {
        font-size: 2.2vw;
    }

    .sidebar_info {
        font-size: 2.2vw;
        gap: 1.5vw;
        padding: 0.5vw 0;
    }

    .sidebar_info iconify-icon {
        font-size: 3.5vw;
    }

    .sidebar_card_title {
        font-size: 2.8vw;
        gap: 1vw;
        margin-bottom: 1.5vw;
        padding-bottom: 1vw;
    }

    .sidebar_card_title iconify-icon {
        font-size: 3.5vw;
    }

    /* Related Jobs */
    .related_jobs {
        gap: 1.5vw;
    }

    .related_job {
        padding: 1.5vw 2vw;
        border-radius: 1.5vw;
        gap: 1.5vw;
    }

    .related_job_icon {
        width: 6vw;
        height: 6vw;
    }

    .related_job_icon iconify-icon {
        font-size: 4vw;
    }

    .related_job h5 {
        font-size: 2.4vw;
    }

    .related_job span {
        font-size: 2vw;
        gap: 0.5vw;
    }

    .related_job span iconify-icon {
        font-size: 2.5vw;
    }

    .related_job .related_arrow {
        font-size: 3vw;
    }

    /* Share Buttons */
    .share_buttons {
        gap: 1.5vw;
    }

    .share_btn {
        width: 8vw;
        height: 8vw;
    }

    .share_btn iconify-icon {
        font-size: 4.5vw;
    }
}

/* ============================================
   🔥 TABLET (769px - 1024px)
   ============================================ */
@media (min-width: 769px) and (max-width: 1024px) {
    .job_detail_grid {
        grid-template-columns: 1fr 280px;
        gap: 2.5vw;
    }

    .job_detail_header h1 {
        font-size: 2.8vw;
    }

    .job_requirements {
        grid-template-columns: 1fr 1fr;
    }

    .job_requirements li {
        font-size: 1.2vw;
    }

    .info_grid {
        grid-template-columns: 1fr 1fr;
    }

    .sidebar_card {
        padding: 2vw;
    }

    .company_logo {
        width: 6vw;
        height: 6vw;
    }

    .related_job h5 {
        font-size: 1.2vw;
    }
}
</style>

{{-- Banner --}}
<div class="banner_page" style="background-image:url({{ $job->image_url ?? asset('images/job_banner.jpg') }}) !important; background-position:center !important; background-size:cover;">
    <img src="{{ asset('images/overlay_page.png') }}" alt="">
</div>
<div class="divider"></div>

{{-- Job Detail Layout --}}
<div class="job_detail_layout">
    <div class="job_detail_grid">

        {{-- Main Content --}}
        <div class="job_detail_main">

            {{-- Header --}}
            <div class="job_detail_header">
                <div class="job_badge">
                    @if($job->is_featured)
                    <span class="badge_featured">
                        <iconify-icon icon="mdi:star" width="14" height="14"></iconify-icon>
                        Unggulan
                    </span>
                    @endif
                    @if($job->is_expired)
                    <span class="badge_expired">
                        <iconify-icon icon="mdi:clock-alert" width="14" height="14"></iconify-icon>
                        Kadaluarsa
                    </span>
                    @else
                    <span class="badge_active">
                        <iconify-icon icon="mdi:check-circle" width="14" height="14"></iconify-icon>
                        Aktif
                    </span>
                    @endif
                </div>
                <h1>{{ $job->title }}</h1>
                <div class="job_detail_meta">
                    <span class="meta_item">
                        <iconify-icon icon="mdi:map-marker" width="16" height="16"></iconify-icon>
                        {{ $job->location ?? 'Lokasi tidak tersedia' }}
                    </span>
                    <span class="meta_item">
                        <iconify-icon icon="mdi:briefcase" width="16" height="16"></iconify-icon>
                        {{ $job->position_type ?? 'Full-time' }}
                    </span>
                    <span class="meta_item">
                        <iconify-icon icon="mdi:calendar-clock" width="16" height="16"></iconify-icon>
                        Deadline: {{ $job->deadline_display }}
                    </span>
                </div>
            </div>

            {{-- Description --}}
            @if($job->description)
            <div class="job_detail_section">
                <h2>
                    <iconify-icon icon="mdi:format-text" width="20" height="20"></iconify-icon>
                    Deskripsi Pekerjaan
                </h2>
                <p>{{ $job->description }}</p>
            </div>
            @endif

            {{-- Requirements --}}
            <div class="job_detail_section">
                <h2>
                    <iconify-icon icon="mdi:format-list-checks" width="20" height="20"></iconify-icon>
                    Persyaratan
                </h2>
                <ul class="job_requirements">
                    @if($job->requirements)
                        @foreach($job->requirements as $req)
                        <li>
                            <iconify-icon icon="mdi:check-circle" width="18" height="18"></iconify-icon>
                            {{ $req }}
                        </li>
                        @endforeach
                    @endif
                    @if($job->education)
                    <li>
                        <iconify-icon icon="mdi:school" width="18" height="18"></iconify-icon>
                        Pendidikan: {{ $job->education }}
                    </li>
                    @endif
                    @if($job->min_age && $job->max_age)
                    <li>
                        <iconify-icon icon="mdi:calendar-range" width="18" height="18"></iconify-icon>
                        Usia: {{ $job->min_age }} - {{ $job->max_age }} Tahun
                    </li>
                    @endif
                    @if($job->gender && $job->gender != 'Semua')
                    <li>
                        <iconify-icon icon="mdi:gender-male-female" width="18" height="18"></iconify-icon>
                        Gender: {{ $job->gender }}
                    </li>
                    @endif
                </ul>
            </div>

            {{-- Salary & Details --}}
            <div class="job_detail_section job_detail_info">
                <div class="info_grid">
                    @if($job->salary)
                    <div class="info_item">
                        <span class="info_label">
                            <iconify-icon icon="mdi:cash" width="14" height="14"></iconify-icon>
                            Gaji
                        </span>
                        <span class="info_value">{{ $job->salary }}</span>
                    </div>
                    @endif
                    @if($job->position_type)
                    <div class="info_item">
                        <span class="info_label">
                            <iconify-icon icon="mdi:briefcase" width="14" height="14"></iconify-icon>
                            Tipe Pekerjaan
                        </span>
                        <span class="info_value">{{ $job->position_type }}</span>
                    </div>
                    @endif
                    @if($job->location)
                    <div class="info_item">
                        <span class="info_label">
                            <iconify-icon icon="mdi:map-marker" width="14" height="14"></iconify-icon>
                            Lokasi
                        </span>
                        <span class="info_value">{{ $job->location }}</span>
                    </div>
                    @endif
                    <div class="info_item">
                        <span class="info_label">
                            <iconify-icon icon="mdi:calendar-clock" width="14" height="14"></iconify-icon>
                            Deadline
                        </span>
                        <span class="info_value {{ $job->is_expired ? 'text-expired' : '' }}">
                            {{ $job->deadline_display }}
                            @if($job->is_expired)
                            <span class="expired_badge">(Kadaluarsa)</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="job_detail_actions">
                @if($job->is_expired)
                <button class="btn_expired" disabled>
                    <iconify-icon icon="mdi:clock-alert" width="20" height="20"></iconify-icon>
                    Pendaftaran Ditutup
                </button>
                @else
                <a href="https://wa.me/6281224074427?text=Halo%20LPK%20SHIROKUMA%2C%20saya%20tertarik%20untuk%20mendaftar%20lowongan%20{{ urlencode($job->title) }}" 
                   target="_blank" 
                   class="btn_apply">
                    <iconify-icon icon="mdi:whatsapp" width="20" height="20"></iconify-icon>
                    Daftar Sekarang via WhatsApp
                </a>
                @endif
                <a href="{{ route('customer.job-vacancy') }}" class="btn_back">
                    <iconify-icon icon="mdi:arrow-left" width="20" height="20"></iconify-icon>
                    Kembali ke Daftar
                </a>
            </div>

        </div>

        {{-- Sidebar --}}
        <div class="job_detail_sidebar">

            {{-- Company Info --}}
            <div class="sidebar_card">
                <div class="sidebar_card_header">
                    <div class="company_logo">
                        <iconify-icon icon="mdi:building" width="32" height="32"></iconify-icon>
                    </div>
                    <div>
                        <h3>LPK SHIROKUMA Indonesia</h3>
                        <p>Lembaga Pelatihan Kerja</p>
                    </div>
                </div>
                <div class="sidebar_card_body">
                    <div class="sidebar_info">
                        <iconify-icon icon="mdi:map-marker" width="16" height="16"></iconify-icon>
                        <span>Tasikmalaya, Jawa Barat</span>
                    </div>
                    <div class="sidebar_info">
                        <iconify-icon icon="mdi:email" width="16" height="16"></iconify-icon>
                        <span>lpkshirokuma@gmail.com</span>
                    </div>
                    <div class="sidebar_info">
                        <iconify-icon icon="mdi:phone" width="16" height="16"></iconify-icon>
                        <span>+62851-2121-2200</span>
                    </div>
                </div>
            </div>

            {{-- Related Jobs --}}
            @if($relatedJobs->isNotEmpty())
            <div class="sidebar_card">
                <h4 class="sidebar_card_title">
                    <iconify-icon icon="mdi:briefcase" width="18" height="18"></iconify-icon>
                    Lowongan Lainnya
                </h4>
                <div class="related_jobs">
                    @foreach($relatedJobs as $related)
                    <a href="{{ route('customer.job-vacancy.show', $related) }}" class="related_job">
                        <div class="related_job_icon">
                            <iconify-icon icon="mdi:briefcase" width="20" height="20"></iconify-icon>
                        </div>
                        <div class="related_job_info">
                            <h5>{{ $related->title }}</h5>
                            <span>
                                <iconify-icon icon="mdi:calendar" width="12" height="12"></iconify-icon>
                                {{ $related->deadline_display }}
                            </span>
                        </div>
                        <iconify-icon icon="mdi:chevron-right" width="16" height="16" class="related_arrow"></iconify-icon>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Share --}}
            <div class="sidebar_card">
                <h4 class="sidebar_card_title">
                    <iconify-icon icon="mdi:share" width="18" height="18"></iconify-icon>
                    Bagikan
                </h4>
                <div class="share_buttons">
                    <button onclick="shareJob('whatsapp')" class="share_btn whatsapp">
                        <iconify-icon icon="mdi:whatsapp" width="20" height="20"></iconify-icon>
                    </button>
                    <button onclick="shareJob('facebook')" class="share_btn facebook">
                        <iconify-icon icon="mdi:facebook" width="20" height="20"></iconify-icon>
                    </button>
                    <button onclick="shareJob('twitter')" class="share_btn twitter">
                        <iconify-icon icon="mdi:twitter" width="20" height="20"></iconify-icon>
                    </button>
                    <button onclick="shareJob('linkedin')" class="share_btn linkedin">
                        <iconify-icon icon="mdi:linkedin" width="20" height="20"></iconify-icon>
                    </button>
                </div>
            </div>

        </div>

    </div>
</div>
<div class="divider"></div>

<script>
// ============================================
// SHARE FUNCTION
// ============================================
function shareJob(platform) {
    var url = window.location.href;
    var title = '{{ $job->title }}';
    var text = 'Lowongan ' + title + ' di LPK SHIROKUMA Indonesia';
    var shareUrl = '';

    switch(platform) {
        case 'whatsapp':
            shareUrl = 'https://wa.me/?text=' + encodeURIComponent(text + '\n' + url);
            break;
        case 'facebook':
            shareUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url);
            break;
        case 'twitter':
            shareUrl = 'https://twitter.com/intent/tweet?text=' + encodeURIComponent(text) + '&url=' + encodeURIComponent(url);
            break;
        case 'linkedin':
            shareUrl = 'https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(url);
            break;
        default:
            return;
    }

    window.open(shareUrl, '_blank', 'width=600,height=500');
}
</script>
@endsection