@extends('layouts_front.app')

@section('content_front')

<style>
/* ============================================
   JOB LAYOUT
   ============================================ */
.job_layout {
    width: 100%;
    padding: 4vw 8vw 4vw 8vw;
    background: url(../images/blue-bg.png), linear-gradient(90deg, #01102D 0%, #294966 48.56%, #08203E 100%);
    background-blend-mode: multiply;
    background-size: contain;
    background-position: center;
    min-height: 80vh;
}

/* ============================================
   JOB HEADER
   ============================================ */
.job_header {
    text-align: center;
    margin-bottom: 2.5vw;
}

.job_header h1 {
    font-size: 3.2vw;
    font-family: techna, sans-serif;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 0.5vw;
}

.job_header p {
    font-size: 1vw;
    color: #e2e6eb;
    max-width: 40vw;
    margin: 0 auto;
    line-height: 1.7;
}

/* ============================================
   JOB GRID
   ============================================ */
.loker_grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5vw;
}

/* ============================================
   JOB CARD
   ============================================ */
.loker_grid_box {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 1vw;
    border: 0.1vw solid rgba(255, 255, 255, 0.08);
    padding: 1.5vw;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.loker_grid_box::before {
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

.loker_grid_box:hover::before {
    opacity: 1;
}

.loker_grid_box:hover {
    border-color: #B7904E;
    transform: translateY(-0.3vw);
    box-shadow: 0 0.5vw 1.5vw rgba(183, 144, 78, 0.15);
}

/* ============================================
   BADGES
   ============================================ */
.loker_badges {
    display: flex;
    gap: 0.5vw;
    margin-bottom: 0.6vw;
    flex-wrap: wrap;
}

.loker_badges span {
    display: inline-flex;
    align-items: center;
    gap: 0.2vw;
    padding: 0.15vw 0.8vw;
    border-radius: 2vw;
    font-size: 0.6vw;
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

/* ============================================
   JOB TITLE
   ============================================ */
.loker_grid_box h5 {
    font-size: 1.2vw;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 0.5vw;
    padding-bottom: 0.4vw;
    border-bottom: 0.1vw solid rgba(255, 255, 255, 0.06);
}

/* ============================================
   META INFO
   ============================================ */
.loker_meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.8vw;
    margin-bottom: 0.6vw;
}

.loker_meta .meta_item {
    display: flex;
    align-items: center;
    gap: 0.3vw;
    color: #c0cad8;
    font-size: 0.7vw;
}

.loker_meta .meta_item iconify-icon {
    color: #B7904E;
}

/* ============================================
   REQUIREMENTS LIST
   ============================================ */
.loker_grid_box ul {
    list-style: none;
    padding: 0;
    margin: 0 0 0.8vw 0;
}

.loker_grid_box ul li {
    display: flex;
    align-items: center;
    gap: 0.5vw;
    color: #c0cad8;
    font-size: 0.75vw;
    border:.1vw solid #B69152;
    padding: 0.2vw 1vw;
    line-height: 1.5;
}

.loker_grid_box ul li iconify-icon {
    color: #4ade80;
    flex-shrink: 0;
}

.loker_grid_box ul li.more_req {
    color: #94a3b8;
    font-size: 0.7vw;
    font-style: italic;
    padding-top: 0.1vw;
}

.loker_grid_box ul li.more_req iconify-icon {
    color: #64748b;
}

/* ============================================
   FOOTER
   ============================================ */
.footer_loker_grid_box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 0.6vw;
    border-top: 0.1vw solid rgba(255, 255, 255, 0.06);
    gap: 1vw;
}

.footer_loker_grid_box .deadline {
    display: flex;
    align-items: center;
    gap: 0.3vw;
    color: #94a3b8;
    font-size: 0.65vw;
}

.footer_loker_grid_box .deadline iconify-icon {
    color: #B7904E;
}

.btn_detail {
    display: inline-flex;
    align-items: center;
    gap: 0.3vw;
    background: linear-gradient(90deg, #B7904E 26.92%, #D2B780 48.56%, #B7904E 71.63%);
    color: #fff !important;
    padding: 0.3vw 1.2vw;
    border-radius: 2vw;
    font-size: 0.65vw;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.btn_detail:hover {
    opacity: 0.9;
    transform: scale(1.02);
    box-shadow: 0 0.2vw 0.5vw rgba(183, 144, 78, 0.3);
}

/* ============================================
   EMPTY STATE
   ============================================ */
.loker_empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4vw 2vw;
    background: rgba(255, 255, 255, 0.03);
    border-radius: 1vw;
    border: 0.1vw dashed rgba(255, 255, 255, 0.1);
}

.loker_empty iconify-icon {
    color: #64748b;
    margin-bottom: 0.5vw;
}

.loker_empty h3 {
    font-size: 1.4vw;
    color: #e2e6eb;
    margin-bottom: 0.3vw;
}

.loker_empty p {
    font-size: 0.9vw;
    color: #94a3b8;
    max-width: 30vw;
    margin: 0 auto;
}

/* ============================================
   RESPONSIVE MOBILE
   ============================================ */
@media (max-width: 768px) {
    .job_layout {
        padding: 8vw 4vw 8vw 4vw;
    }

    .job_header h1 {
        font-size: 7vw;
        margin-bottom: 1.5vw;
    }

    .job_header p {
        font-size: 2.4vw;
        max-width: 85vw;
    }

    .loker_grid {
        grid-template-columns: 1fr;
        gap: 3vw;
    }

    .loker_grid_box {
        padding: 4vw;
        border-radius: 2.5vw;
    }

    .loker_grid_box::before {
        height: 0.4vw;
    }

    /* Badges */
    .loker_badges {
        gap: 1.5vw;
        margin-bottom: 3.5vw;
    }

    .loker_badges span {
        font-size: 1.8vw;
        padding: 0.5vw 2.5vw;
        gap: 0.8vw;
        border-radius: 4vw;
    }

    .loker_badges span iconify-icon {
        font-size: 2.5vw;
    }

    /* Title */
    .loker_grid_box h5 {
        font-size: 4vw;
        margin-bottom: 3vw;
        padding-bottom: 3vw;
    }

    /* Meta */
    .loker_meta {
        gap: 2vw;
        margin-bottom: 3.5vw;
    }

    .loker_meta .meta_item {
        font-size: 2.7vw;
        gap: 0.8vw;
    }

    .loker_meta .meta_item iconify-icon {
        font-size: 3vw;
    }

    /* Requirements */
    .loker_grid_box ul {
        margin-bottom: 2vw;
    }

    .loker_grid_box ul li {
        font-size: 2.8vw;
        gap: 1.5vw;
        padding: 0.6vw 2vw;
    }

    .loker_grid_box ul li iconify-icon {
        font-size: 3vw;
    }

    .loker_grid_box ul li.more_req {
        font-size: 2vw;
        padding-top: 0.5vw;
    }

    /* Footer */
    .footer_loker_grid_box {
        padding-top: 1.5vw;
        flex-wrap: wrap;
        gap: 1.5vw;
    }

    .footer_loker_grid_box .deadline {
        font-size: 2.7vw;
        gap: 0.8vw;
    }

    .footer_loker_grid_box .deadline iconify-icon {
        font-size: 3vw;
    }

    .btn_detail {
        font-size: 2vw;
        padding: 1.2vw 3.5vw;
        gap: 0.8vw;
        border-radius: 4vw;
    }

    .btn_detail iconify-icon {
        font-size: 2.5vw;
    }

    /* Empty State */
    .loker_empty {
        padding: 8vw 4vw;
        border-radius: 2.5vw;
    }

    .loker_empty iconify-icon {
        font-size: 10vw;
        margin-bottom: 1.5vw;
    }

    .loker_empty h3 {
        font-size: 3.5vw;
    }

    .loker_empty p {
        font-size: 2.2vw;
        max-width: 80vw;
    }
}

/* ============================================
   TABLET
   ============================================ */
@media (min-width: 769px) and (max-width: 1024px) {
    .job_layout {
        padding: 2vw 5vw 4vw 5vw;
    }

    .loker_grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2vw;
    }

    .loker_grid_box h5 {
        font-size: 1.5vw;
    }

    .loker_grid_box ul li {
        font-size: 1vw;
    }

    .btn_detail {
        font-size: 0.85vw;
        padding: 0.4vw 1.5vw;
    }
}
</style>

{{-- Banner --}}
<div class="banner_page" style="background-image:url({{ asset('images/work_page.jpg') }}) !important; background-position:center !important; background-size:cover;">
    <img src="{{ asset('images/overlay_page.png') }}" alt="">
</div>
<div class="divider"></div>

{{-- Job Layout --}}
<div class="job_layout">

    {{-- Header --}}
    <div class="job_header">
        <h1>Lowongan Pekerjaan</h1>
        <p>Temukan lowongan pekerjaan terbaru dari LPK SHIROKUMA Indonesia.</p>
    </div>

    {{-- Job Grid --}}
    <div class="loker_grid">
        @forelse($jobs as $job)
        <div class="loker_grid_box">
            {{-- Badge --}}
            <div class="loker_badges">
                @if($job->is_featured)
                <span class="badge_featured">
                    <iconify-icon icon="mdi:star" width="12" height="12"></iconify-icon>
                    Unggulan
                </span>
                @endif
                @if($job->is_expired)
                <span class="badge_expired">
                    <iconify-icon icon="mdi:clock-alert" width="12" height="12"></iconify-icon>
                    Kadaluarsa
                </span>
                @else
                <span class="badge_active">
                    <iconify-icon icon="mdi:check-circle" width="12" height="12"></iconify-icon>
                    Aktif
                </span>
                @endif
            </div>

            {{-- Title --}}
            <h5>{{ $job->title }}</h5>

            {{-- Meta Info --}}
            <div class="loker_meta">
                <span class="meta_item">
                    <iconify-icon icon="mdi:map-marker" width="14" height="14"></iconify-icon>
                    {{ $job->location ?? 'Lokasi tidak tersedia' }}
                </span>
                <span class="meta_item">
                    <iconify-icon icon="mdi:briefcase" width="14" height="14"></iconify-icon>
                    {{ $job->position_type ?? 'Full-time' }}
                </span>
            </div>

            {{-- Requirements --}}
            <ul>
                @if($job->requirements)
                    @foreach(array_slice($job->requirements, 0, 3) as $req)
                    <li>
                        <iconify-icon icon="mdi:check-circle" width="14" height="14"></iconify-icon>
                        {{ $req }}
                    </li>
                    @endforeach
                    @if(count($job->requirements) > 3)
                    <li class="more_req">
                        <iconify-icon icon="mdi:dots-horizontal" width="14" height="14"></iconify-icon>
                        +{{ count($job->requirements) - 3 }} persyaratan lainnya
                    </li>
                    @endif
                @endif
                @if($job->education)
                <li>
                    <iconify-icon icon="mdi:school" width="14" height="14"></iconify-icon>
                    Pendidikan: {{ $job->education }}
                </li>
                @endif
                @if($job->min_age && $job->max_age)
                <li>
                    <iconify-icon icon="mdi:calendar-range" width="14" height="14"></iconify-icon>
                    Usia {{ $job->min_age }} - {{ $job->max_age }} Tahun
                </li>
                @endif
                @if($job->gender && $job->gender != 'Semua')
                <li>
                    <iconify-icon icon="mdi:gender-male-female" width="14" height="14"></iconify-icon>
                    {{ $job->gender }}
                </li>
                @endif
            </ul>

            {{-- Footer --}}
            <div class="footer_loker_grid_box">
                <span class="deadline">
                    <iconify-icon icon="mdi:calendar" width="14" height="14"></iconify-icon>
                    {{ $job->deadline_display }}
                </span>
                <a href="{{ route('customer.job-vacancy.show', $job) }}" class="btn_detail">
                    Lihat Selengkapnya
                    <iconify-icon icon="mdi:chevron-right" width="14" height="14"></iconify-icon>
                </a>
            </div>
        </div>
        @empty
        <div class="loker_empty">
            <iconify-icon icon="mdi:briefcase-off" width="48" height="48"></iconify-icon>
            <h3>Belum Ada Lowongan</h3>
            <p>Belum ada lowongan pekerjaan yang tersedia saat ini. Silakan cek kembali nanti.</p>
        </div>
        @endforelse
    </div>

</div>
<div class="divider"></div>
<div class="cta_program">
    <h3>Daftar Sekarang dan Mulai Karirmu!</h3>
    <a href="/daftar">
        <button>Daftar Sekarang</button>
    </a>
</div>
@endsection