@extends('layouts_front.app')

@section('content_front')

<div class="banner">
    <img src="{{ asset('images/overlay_banner.png') }}" alt="バナー" class="overlay_banner hidden_top_header">
    <img src="{{ asset('images/bg_banner_mobile.png') }}" alt="バナー" class="overlay_banner hidden_top_header_dekstop">

    <div class="text_banner">
        <h3 class="hidden_top_header">
            SO（送出機関｜日本で働くなら信頼のLPK Shirokuma
        </h3>

        <h1>LPK SHIROKUMA</h1>

        <h3 class="hidden_top_header_dekstop">
            SO（送出機関）｜日本で働くなら信頼のLPK Shirokuma
        </h3>

        <p>共に前進し、共に未来を築く</p>

        <div class="button_banner">
            <a href="/jp/tentang-kami">
                <button>詳しく見る</button>
            </a>

            <a href="/daftar">
                <button>今すぐ登録</button>
            </a>
        </div>
    </div>
</div>


<div class="divider"></div>


{{-- =========================================
    ABOUT
========================================= --}}
<div class="about_home">

    <div class="img_about_home">
        <img
            src="{{ asset('images/CEO-image.webp') }}"
            alt="LPK SHIROKUMA CEO">
    </div>

    <div class="content_about_home">

        <h4>会社概要</h4>

        <h2>LPK Shirokumaについて</h2>

        <p>
            LPK Shirokuma Indonesiaは、外国語、特に日本語と就労スキルの教育を行う職業訓練機関です。
            2024年に設立され、日本で働くことを目指すインドネシアの若者に対して、
            日本語能力と仕事に必要なスキルを身につけるための教育を提供しています。
            さらに2026年には、正式に
            <b>送出機関（Sending Organization / SO）</b>
            として認定され、日本で働くインドネシア人材の育成および送り出しにも取り組んでいます。
        </p>

        <a href="/jp/tentang-kami">
            <button>詳しく見る</button>
        </a>

    </div>

</div>


<div class="divider"></div>


{{-- =========================================
    BENEFIT
========================================= --}}
<div class="benefit_home">

    <img
        src="{{ asset('images/tihang-right.svg') }}"
        alt=""
        class="icon_right_benefit">

    <img
        src="{{ asset('images/tihang-left.svg') }}"
        alt=""
        class="icon_left_benefit">

    <div class="header_benefit_home">

        <h2>LPK Shirokumaのメリット</h2>

        <p>
            LPK Shirokumaでは、日本語能力と仕事に必要なスキルを身につけ、
            日本での就労に向けて安心して準備できる環境を提供しています。
        </p>

    </div>


    <div class="layout_benefit_home">

        {{-- Benefit 1 --}}
        <div class="box_benefit_home">

            <img
                src="{{ asset('images/benefit_icon_1.png') }}"
                alt="経験豊富な講師">

            <h4>経験豊富な講師</h4>

            <p>
                日本での就労経験を持つ経験豊富な講師が、
                実践的で質の高い日本語教育を行います。
            </p>

        </div>


        {{-- Benefit 2 --}}
        <div class="box_benefit_home">

            <img
                src="{{ asset('images/benefit_icon_2.png') }}"
                alt="幅広いネットワーク">

            <h4>幅広いネットワーク</h4>

            <p>
                日本への人材送り出しに実績のある送出機関をはじめ、
                幅広いパートナーとのネットワークを構築しています。
            </p>

        </div>


        {{-- Benefit 3 --}}
        <div class="box_benefit_home">

            <img
                src="{{ asset('images/benefit_icon_3.png') }}"
                alt="充実したカリキュラム">

            <h4>充実したカリキュラム</h4>

            <p>
                日本語能力の向上だけでなく、
                日本で働くための規律や仕事への姿勢も身につけられる
                カリキュラムを提供しています。
            </p>

        </div>

    </div>

    <div class="benefit_bg_blue"></div>

</div>


{{-- =========================================
    PARTICIPANT DATA
========================================= --}}
<div class="info_home">

    <img
        src="{{ asset('images/data-peserta-left.svg') }}"
        alt=""
        class="info_home_left">

    <img
        src="{{ asset('images/data-peserta-right.svg') }}"
        alt=""
        class="info_home_right">


    <div class="container_info_home">

        <div class="header_benefit_home">

            <h2>Shirokuma 受講生データ</h2>

            <p>
                LPK Shirokuma Indonesiaで日本語教育・職業訓練を受け、
                日本で働くことを目指している受講生の情報をご紹介します。
            </p>

        </div>


        <div class="info_home_layout">

            <div class="info_home_box">

                <h4
                    class="counter-number"
                    data-target="700"
                    data-suffix="+">
                    0
                </h4>

                <p>日本で働く卒業生</p>

            </div>


            <div class="info_home_box">

                <h4
                    class="counter-number"
                    data-target="300"
                    data-suffix="+">
                    0
                </h4>

                <p>特定技能</p>

            </div>


            <div class="info_home_box">

                <h4
                    class="counter-number"
                    data-target="50"
                    data-suffix="+">
                    0
                </h4>

                <p>自己応募・独立就職</p>

            </div>


            <div class="info_home_box">

                <h4
                    class="counter-number"
                    data-target="170"
                    data-suffix="+">
                    0
                </h4>

                <p>技能実習</p>

            </div>

        </div>

    </div>


    {{-- =========================================
        JOB VACANCY
    ========================================== --}}
    <div class="container_loker">

        <div class="header_loker">

            <div class="header_loker_small">

                <h4>求人情報</h4>

                <a href="/jp/lowongan-kerja">
                    すべて見る
                </a>

            </div>

            <h4 class="hidden_top_header">
                登録・選考の流れ
            </h4>

        </div>


        <div class="layout_loker">

            <div class="loker_grid">

                @forelse($latestJobs as $job)

                    <div class="loker_grid_box">

                        <div class="image_loker_box">

                            @if($job->image_url)

                                <img
                                    src="{{ $job->image_url }}"
                                    alt="{{ $job->title }}">

                            @else

                                <img
                                    src="{{ asset('images/job-default.jpg') }}"
                                    alt="{{ $job->title }}">

                            @endif

                        </div>


                        <h5>{{ $job->title }}</h5>


                        <ul>

                            @if($job->requirements)

                                @foreach($job->requirements as $req)

                                    <li>{{ $req }}</li>

                                @endforeach

                            @else

                                <li>応募条件はありません</li>

                            @endif

                        </ul>


                        <div class="footer_loker_grid_box">

                            <span>
                                {{ $job->deadline_display }}
                            </span>

                            <a href="{{ route('customer.job-vacancy.show', $job) }}">
                                詳細を見る
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="loker_grid_box empty">

                        <div class="empty-state">

                            <svg
                                width="48"
                                height="48"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#B7904E"
                                stroke-width="2">

                                <rect
                                    x="2"
                                    y="7"
                                    width="20"
                                    height="14"
                                    rx="2"
                                    ry="2"/>

                                <path
                                    d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>

                            </svg>

                            <p>現在、求人情報はありません</p>

                            <span>しばらくしてから再度ご確認ください</span>

                        </div>

                    </div>

                @endforelse

            </div>


            {{-- =========================================
                REGISTRATION STEPS
            ========================================== --}}
            <div class="tahapan_grid">

                <div class="header_loker_mobile">

                    <h4>登録・選考の流れ</h4>

                </div>


                <div class="tahapan_grid_box">

                    <div class="tahapan_number">1</div>

                    <div class="tahapan_text">
                        公式ウェブサイトからオンライン登録・必要情報の入力を行います。
                        すべての項目を正確にご入力ください。
                    </div>

                </div>


                <div class="tahapan_grid_box">

                    <div class="tahapan_number">2</div>

                    <div class="tahapan_text">
                        スクリーニングを行い、求人の条件や資格に合った候補者を選考します。
                    </div>

                </div>


                <div class="tahapan_grid_box">

                    <div class="tahapan_number">3</div>

                    <div class="tahapan_text">
                        第一次選考
                    </div>

                </div>


                <div class="tahapan_grid_box">

                    <div class="tahapan_number">4</div>

                    <div class="tahapan_text">
                        第二次選考
                    </div>

                </div>


                <div class="tahapan_grid_box">

                    <div class="tahapan_number">5</div>

                    <div class="tahapan_text">
                        第三次選考
                    </div>

                </div>


                <div class="tahapan_grid_box">

                    <div class="tahapan_number">6</div>

                    <div class="tahapan_text">
                        健康診断（MCU 1）
                    </div>

                </div>


                <div class="tahapan_grid_box">

                    <div class="tahapan_number">7</div>

                    <div class="tahapan_text">
                        Shirokumaでの日本語・就労教育
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<div class="divider"></div>


{{-- =========================================
    PROGRAM
========================================= --}}
<div class="program_home">

    <div class="header_program_home">

        <h2>Shirokumaのプログラム</h2>

        <p>
            日本語教育と就労支援を通じて、
            日本で働くために必要な知識とスキルを身につけるための
            多彩なプログラムをご紹介します。
        </p>

    </div>


    <div class="layout_one_program_home">

        {{-- Ginou Jisshusei --}}
        <div class="box_program_home">

            <img
                src="{{ asset('images/magang-icon.png') }}"
                alt="技能実習">

            <h3>技能実習生</h3>

            <p>
                技能実習制度を通じて、
                日本で1～3年間の実習を行いながら、
                技術や知識を身につけるプログラムです。
            </p>

            <a href="/jp/ginoujisshusei">
                <button>プログラム詳細</button>
            </a>

        </div>


        {{-- Tokutei Ginou --}}
        <div class="box_program_home">

            <img
                src="{{ asset('images/kerja-icon.png') }}"
                alt="特定技能">

            <h3>特定技能</h3>

            <p>
                特定技能制度を利用して日本で働くためのプログラムです。
                技能実習を修了した方が、
                さらに日本での就労を続けることも可能です。
            </p>

            <a href="/jp/tg">
                <button>プログラム詳細</button>
            </a>

        </div>


        {{-- Engineering --}}
        <div class="box_program_home">

            <img
                src="{{ asset('images/tenaga-ahli-icon.png') }}"
                alt="技術・人文知識・国際業務">

            <h3>技術・エンジニア</h3>

            <p>
                大学・専門学校などで工学系分野を学んだ
                D3・S1卒業者を中心とした
                専門人材向けの就労プログラムです。
            </p>

            <a href="/jp/engineering">
                <button>プログラム詳細</button>
            </a>

        </div>

    </div>


    <div class="layout_two_program_home">

        {{-- Nihongo Gakkou --}}
        <div class="box_program_home">

            <img
                src="{{ asset('images/sekolah-icon.png') }}"
                alt="日本語学校">

            <h3>日本語学校</h3>

            <p>
                日本語学校で日本語の文法や会話を学び、
                日本での進学や将来のキャリアに必要な
                日本語能力を身につけるプログラムです。
            </p>

            <a href="/jp/nihongo-gakkou">
                <button>プログラム詳細</button>
            </a>

        </div>


        {{-- Kaigo --}}
        <div class="box_program_home">

            <img
                src="{{ asset('images/perawat-icon.png') }}"
                alt="介護">

            <h3>介護</h3>

            <p>
                高齢化が進む日本において、
                高齢者の生活をサポートする介護分野で
                働くためのプログラムです。
            </p>

            <a href="/jp/kaigo">
                <button>プログラム詳細</button>
            </a>

        </div>

    </div>

</div>


<div class="divider_blue"></div>


{{-- =========================================
    LEGALITY
========================================= --}}
<div class="section_9">

    <div class="header_program_home">

        <h2>LPK Shirokumaの法的情報</h2>

    </div>


    <div class="swiper klienSwiper">

        <div class="swiper-wrapper">

            <div class="swiper-slide">

                <div class="klien_box">

                    <img
                        src="{{ asset('images/legality-1.png') }}"
                        alt="法的情報">

                </div>

            </div>


            <div class="swiper-slide">

                <div class="klien_box">

                    <img
                        src="{{ asset('images/legality-2.png') }}"
                        alt="法的情報">

                </div>

            </div>


            <div class="swiper-slide">

                <div class="klien_box">

                    <img
                        src="{{ asset('images/legality-7.png') }}"
                        alt="Kemnaker">

                </div>

            </div>


            <div class="swiper-slide">

                <div class="klien_box">

                    <img
                        src="{{ asset('images/legality-3.png') }}"
                        alt="法的情報">

                </div>

            </div>


            <div class="swiper-slide">

                <div class="klien_box">

                    <img
                        src="{{ asset('images/legality-5.png') }}"
                        alt="法的情報">

                </div>

            </div>


            <div class="swiper-slide">

                <div class="klien_box">

                    <img
                        src="{{ asset('images/legality-6.png') }}"
                        alt="法的情報">

                </div>

            </div>


            <div class="swiper-slide">

                <div class="klien_box">

                    <img
                        src="{{ asset('images/legality-4.png') }}"
                        alt="法的情報">

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

            const progress = Math.min(
                (now - start) / duration,
                1
            );

            const eased =
                1 - Math.pow(1 - progress, 3);

            const value =
                Math.round(target * eased);

            element.textContent =
                value + suffix;


            if (progress < 1) {

                requestAnimationFrame(update);

            } else {

                element.textContent =
                    target + suffix;

            }

        }


        requestAnimationFrame(update);

    }


    const observer =
        new IntersectionObserver(function (entries) {

            entries.forEach(function (entry) {

                if (entry.isIntersecting) {

                    animateCounter(entry.target);

                    observer.unobserve(entry.target);

                }

            });

        }, {
            threshold: 0.4
        });


    document
        .querySelectorAll('.counter-number')
        .forEach(function (element) {

            element.textContent = '0';

            observer.observe(element);

        });

})();
</script>

@endsection