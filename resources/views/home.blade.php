@extends('layouts_front.app')

@section('content_front')

<div class="banner">
    <img src="images/overlay_banner.png" alt="Banner" class="overlay_banner hidden_top_header">
    <img src="images/bg_banner_mobile.png" alt="Banner" class="overlay_banner hidden_top_header_dekstop">
    <div class="text_banner">
        <h3 class="hidden_top_header">SO (Sending Organization) - Terpercaya di Indonesia</h3>
        <h1>LPK SHIROKUMA</h1>
        <h3 class="hidden_top_header_dekstop">SO (Sending Organization) - Terpercaya di Indonesia</h3>
        <p>MAJU MAPAN BERSAMA</p>
        <div class="button_banner">
            <a href="/register">
                <button>Buat CV</button>
            </a>
            <a href="/daftar">
                <button>Daftar Sekarang</button>
            </a>
        </div>
    </div>
</div>
<div class="divider"></div>
<div class="about_home">
    <div class="img_about_home">
        <img src="images/CEO-image.webp" alt="CEO LPK SHIROKUMA">
    </div>
    <div class="content_about_home">
        <H4>COMPANY PROFILE</H4>
        <h2>Tentang LPK Shirokuma</h2>
        <p>LPK Shirokuma Indonesia adalah lembaga pendidikan keterampilan kerja bahasa asing, khususnya bahasa Jepang, yang berdiri sejak tahun 2024. Lembaga ini didirikan dengan tujuan mempersiapkan generasi muda Indonesia untuk bekerja dengan keterampilan berbahasa Jepang yang baik. Seiring perkembangannya, pada tahun 2026 LPK Shirokuma Indonesia telah resmi menjadi <b>Sending Organization (SO)</b>, sehingga turut berperan dalam mempersiapkan dan menyalurkan tenaga kerja Indonesia untuk bekerja di Jepang.</p>
        <a href="/tentang-kami"><button>Lihat Selengkapnya</button></a>
    </div>
</div>
<div class="divider"></div>
<div class="benefit_home">
    <img src="images/tihang-right.svg" alt="" class="icon_right_benefit">
    <img src="images/tihang-left.svg" alt="" class="icon_left_benefit">
    <div class="header_benefit_home">
        <h2>Benefit LPK Shirokuma</h2>
        <p>LPK Shirokuma menawarkan berbagai manfaat yang dirancang untuk mempersiapkan Anda menghadapi dunia kerja dengan keterampilan bahasa Jepang yang unggul.</p>
    </div>
    <div class="layout_benefit_home">
        <div class="box_benefit_home">
            <img src="images/benefit_icon_1.png" alt="Pengajar Berpengalaman">
            <h4>Pengajar Berpengalaman</h4>
            <p>Kami melaksanakan pendidikan bahasa Jepang dengan optimal oleh pengajar yang berpengalaman (ex pekerja di Jepang)</p>
        </div>
        <div class="box_benefit_home">
            <img src="images/benefit_icon_2.png" alt="Jaringan Luas">
            <h4>Jaringan Luas</h4>
            <p>Memiliki mitra yang luas, termasuk sending organizing berpengalaman yang memberangkatkan pekerja Indonesia ke Jepang</p>
        </div>
        <div class="box_benefit_home">
            <img src="images/benefit_icon_3.png" alt="Kurikulum Terbaik">
            <h4>Kurikulum Terbaik</h4>
            <p>Menerapkan kurikulum bahasa Jepang terbaik, menghasilkan peserta didik yang cepat menguasai bahasa dan disiplin dalam bekerja.</p>
        </div>
    </div>
    <div class="benefit_bg_blue"></div>
</div>

<div class="info_home">
    <img src="images/data-peserta-left.svg" alt="" class="info_home_left">
    <img src="images/data-peserta-right.svg" alt="" class="info_home_right">
    <div class="container_info_home">
        <div class="header_benefit_home">
            <h2>Data Peserta Shirokuma</h2>
            <p>Informasi peserta yang mengikuti program pendidikan dan pelatihan bahasa Jepang di LPK Shirokuma Indonesia sebagai persiapan untuk bekerja di Jepang.</p>
        </div>
        <div class="info_home_layout">
            <div class="info_home_box">
                <h4 class="counter-number" data-target="700" data-suffix="+">0</h4>
                <p>Siswa di Jepang</p>
            </div>
            <div class="info_home_box">
                <h4 class="counter-number" data-target="300" data-suffix="+">0</h4>
                <p>Tokutei Ginou</p>
            </div>
            <div class="info_home_box">
                <h4 class="counter-number" data-target="50" data-suffix="+">0</h4>
                <p>Mandiri</p>
            </div>
            <div class="info_home_box">
                <h4 class="counter-number" data-target="170" data-suffix="+">0</h4>
                <p>Magang</p>
            </div>
        </div>
    </div>
    <div class="container_loker">
        <div class="header_loker">
            <div class="header_loker_small">
                <h4>Lowongan Pekerjaan</h4>
                <a href="/lowongan-kerja">Lihat Semua</a>
            </div>
            <h4 class="hidden_top_header">Tahapan Pendaftaran</h4>
        </div>
        <div class="layout_loker">
            <div class="loker_grid">
                @forelse($latestJobs as $job)
                <div class="loker_grid_box">
                    <div class="image_loker_box">
                        @if($job->image_url)
                        <img src="{{ $job->image_url }}" alt="{{ $job->title }}">
                        @else
                        <img src="{{ asset('images/job-default.jpg') }}" alt="{{ $job->title }}">
                        @endif
                    </div>
                    <h5>{{ $job->title }}</h5>
                    <ul>
                        @if($job->requirements)
                            @foreach($job->requirements as $req)
                            <li>{{ $req }}</li>
                            @endforeach
                        @else
                            <li>Tidak ada persyaratan</li>
                        @endif
                    </ul>
                    <div class="footer_loker_grid_box">
                        <span>{{ $job->deadline_display }}</span>
                        <a href="{{ route('customer.job-vacancy.show', $job) }}">
                            Lihat Selengkapnya
                        </a>
                    </div>
                </div>
                @empty
                <div class="loker_grid_box empty">
                    <div class="empty-state">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#B7904E" stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                        </svg>
                        <p>Belum ada lowongan pekerjaan</p>
                        <span>Silakan cek kembali nanti</span>
                    </div>
                </div>
                @endforelse
            </div>
            <div class="tahapan_grid">
                <div class="header_loker_mobile">
                    <h4>Tahapan Pendaftaran</h4>
                </div>
                <div class="tahapan_grid_box">
                    <div class="tahapan_number">1</div>
                    <div class="tahapan_text">
                        Pendaftaran dan pengisian data online melalui website resmi lpkshirokuma.com (Harap untuk melengkapi keseluruhannya).
                    </div>
                </div>
                <div class="tahapan_grid_box">
                    <div class="tahapan_number">2</div>
                    <div class="tahapan_text">
                        Screening (Pemanggilan Kandidat yang sesuai dengan kualifikasi yang dibutuhkan).
                    </div>
                </div>
                <div class="tahapan_grid_box">
                    <div class="tahapan_number">3</div>
                    <div class="tahapan_text">
                        Seleksi Tahap 1
                    </div>
                </div>
                <div class="tahapan_grid_box">
                    <div class="tahapan_number">4</div>
                    <div class="tahapan_text">
                        Seleksi Tahap 2
                    </div>
                </div>
                <div class="tahapan_grid_box">
                    <div class="tahapan_number">5</div>
                    <div class="tahapan_text">
                        Seleksi Tahap 3
                    </div>
                </div>
                <div class="tahapan_grid_box">
                    <div class="tahapan_number">6</div>
                    <div class="tahapan_text">
                        Medical Check Up 1 (MCU 1)
                    </div>
                </div>
                <div class="tahapan_grid_box">
                    <div class="tahapan_number">7</div>
                    <div class="tahapan_text">      
                        Pendidikan di Shirokuma
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="divider"></div>
<div class="program_home">
    <div class="header_program_home">
        <h2>Program Shirokuma</h2>
        <p>Jelajahi berbagai program pelatihan bahasa Jepang kami yang dirancang untuk mempersiapkan Anda menghadapi dunia kerja.</p>
    </div>
    <div class="layout_one_program_home">
        <div class="box_program_home">
            <img src="images/magang-icon.png" alt="Magang">
            <h3>Magang (Ginoujisshusei)</h3>
            <p>Magang Jepang (Pemagangan) merupakan program yang dapat dilaksanakan 1-3 tahun untuk putra putri Indonesia.</p>
            <a href="/ginoujisshusei"><button>Detail Program</button></a>
        </div>
        <div class="box_program_home">
            <img src="images/kerja-icon.png" alt="Kerja">
            <h3>Kerja (Tokutei Ginou)</h3>
            <p>Program Tokutei Ginou (kerja) adalah lanjutan pemagangan yang memungkinkan siswa dapat melanjutkan visa kerja setelah 1-3 tahun.</p>
            <a href="/tg"><button>Detail Program</button></a>
        </div>
        <div class="box_program_home">
            <img src="images/tenaga-ahli-icon.png" alt="Tenaga Ahli">
            <h3>Tenaga Ahli (Engineering)</h3>
            <p>Program Tenaga Ahli (Engineering) adalah program kerja yang memprioritaskan untuk lulusan sarjana teknik D3 maupun S1.</p>
            <a href="/engineering"><button>Detail Program</button></a>
        </div>
    </div>
    <div class="layout_two_program_home">
        <div class="box_program_home">
            <img src="images/sekolah-icon.png" alt="Sekolah">
            <h3>Sekolah (Nihongo Gakkou)</h3>
            <p>Program Nihongo Gakkou pada umumnya adalah sekolah yang mempelajari tata bahasa dan percakapan dalam bahasa Jepang.</p>
            <a href="/nihongo-gakkou"><button>Detail Program</button></a>
        </div>
        <div class="box_program_home">
            <img src="images/perawat-icon.png" alt="Perawat">
            <h3>Perawat (Kaigo)</h3>
            <p>Program Kaigo (perawat) adalah program dari pemerintah Jepang karena semakin meningkatnya orang Jepang yang lanjut usia.</p>
            <a href="/kaigo"><button>Detail Program</button></a>
        </div>
    </div>
</div>
<div class="divider_blue"></div>
<div class="section_9">
    <div class="header_program_home">
        <h2>Legalitas LPK Shirokuma</h2>
    </div>
    <div class="swiper klienSwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="klien_box">
                    <img src="images/legality-1.png" alt="Kopassus">
                </div>
            </div>
            <div class="swiper-slide">
                <div class="klien_box">
                    <img src="images/legality-2.png" alt="STIN">
                </div>
            </div>
            <div class="swiper-slide">
                <div class="klien_box">
                    <img src="images/legality-7.png" alt="Kemnaker">
                </div>
            </div>
            <div class="swiper-slide">
                <div class="klien_box">
                    <img src="images/legality-3.png" alt="Siemens">
                </div>
            </div>
            
            
            <div class="swiper-slide">
                <div class="klien_box">
                    <img src="images/legality-5.png" alt="PLN">
                </div>
            </div>
            <div class="swiper-slide">
                <div class="klien_box">
                    <img src="images/legality-6.png" alt="Pertamina">
                </div>
            </div>
            <div class="swiper-slide">
                <div class="klien_box">
                    <img src="images/legality-4.png" alt="Pussenkav">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
(function () {
    function animateCounter(element) {
        const target = Number(element.dataset.target || 0);
        const suffix = element.dataset.suffix || '';
        const duration = 1500;
        const start = performance.now();

        function update(now) {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            const value = Math.round(target * eased);
            element.textContent = value + suffix;

            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                element.textContent = target + suffix;
            }
        }

        requestAnimationFrame(update);
    }

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.4 });

    document.querySelectorAll('.counter-number').forEach(function (element) {
        element.textContent = '0';
        observer.observe(element);
    });
})();
</script>
@endsection