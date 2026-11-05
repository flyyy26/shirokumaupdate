@php
    $isJapanese = request()->is('jp*');
    $currentPath = trim((string) request()->path(), '/');
    $currentQuery = request()->getQueryString();
    $querySuffix = $currentQuery ? '?' . $currentQuery : '';

    $toJapaneseUrl = $isJapanese
        ? request()->url() . $querySuffix
        : ($currentPath === '' ? '/jp' : '/jp/' . $currentPath) . $querySuffix;

    $toIndonesianUrl = !$isJapanese
        ? request()->url() . $querySuffix
        : ($currentPath === 'jp' ? '/' : '/' . preg_replace('#^jp/?#', '', $currentPath)) . $querySuffix;
@endphp

<div class="container_header">
    <div class="top_header">
        <div class="top_header_list">
            <div class="top_header_box hidden_top_header">
                <a href="https://api.whatsapp.com/send?phone=6285121212200" target="_blank">
                    <iconify-icon icon="ic:baseline-whatsapp"></iconify-icon>
                    +62851-2121-2200
                </a>
            </div>

            <div class="top_header_box">
                <a href="mailto:lpkshirokuma@gmail.com" target="_blank">
                    <iconify-icon icon="ic:email"></iconify-icon>
                    lpkshirokuma@gmail.com
                </a>
            </div>
        </div>

        <div class="top_header_list">
            {{-- Jepang --}}
            <div class="top_header_box {{ $isJapanese ? 'active' : '' }}">
                <a href="{{ $toJapaneseUrl }}">
                    <iconify-icon icon="twemoji:flag-japan"></iconify-icon>
                    日本
                </a>
            </div>

            {{-- Indonesia --}}
            <div class="top_header_box {{ !$isJapanese ? 'active' : '' }}">
                <a href="{{ $toIndonesianUrl }}">
                    <iconify-icon icon="twemoji:flag-indonesia"></iconify-icon>
                    Indonesia
                </a>
            </div>
        </div>
    </div>

    @php
        $isJapanese = request()->is('jp*');

        // Active menu
        $isHomeActive = $isJapanese
            ? request()->routeIs('home-jp')
            : request()->routeIs('home');

        $isAboutActive = $isJapanese
            ? request()->routeIs('about-jp')
            : request()->routeIs('about');

        $isLegalitasActive = $isJapanese
            ? request()->is('jp/legalitas')
            : request()->is('legalitas');

        // Program
        $programPages = [
            'engineering',
            'ginoujisshusei',
            'tg',
            'kaigo',
            'nihongo-gakkou',
        ];

        $programActive = false;

        foreach ($programPages as $page) {
            if ($isJapanese) {
                if (request()->is('jp/' . $page)) {
                    $programActive = true;
                    break;
                }
            } else {
                if (request()->is($page)) {
                    $programActive = true;
                    break;
                }
            }
        }

        $isFaqActive = $isJapanese
            ? request()->is('jp/pertanyaan-umum')
            : request()->is('pertanyaan-umum');

        $isGalleryActive = $isJapanese
            ? request()->is('jp/galeri')
            : request()->is('galeri');
    @endphp


    <div class="bottom_header">

        {{-- LOGO --}}
        <div class="logo_header_box">
            <a href="{{ $isJapanese ? '/jp' : '/' }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </a>
        </div>


        {{-- MENU --}}
        <div class="menu_box">
            <div class="menu_list">


                {{-- =========================================
                    BERANDA
                ========================================== --}}
                <div class="menu_item {{ $isHomeActive ? 'active' : '' }}">
                    <a href="{{ $isJapanese ? '/jp' : '/' }}">
                        {{ $isJapanese ? 'ホーム' : 'Beranda' }}
                    </a>
                </div>


                {{-- =========================================
                    TENTANG KAMI
                ========================================== --}}
                <div class="menu_item {{ $isAboutActive ? 'active' : '' }}">
                    <a href="{{ $isJapanese ? '/jp/tentang-kami' : '/tentang-kami' }}">
                        {{ $isJapanese ? '私たちについて' : 'Tentang Kami' }}
                    </a>
                </div>


                {{-- =========================================
                    LEGALITAS
                ========================================== --}}
                <div class="menu_item {{ $isLegalitasActive ? 'active' : '' }}">
                    <a href="{{ $isJapanese ? '/jp/legalitas' : '/legalitas' }}">
                        {{ $isJapanese ? '法的情報' : 'Legalitas' }}
                    </a>
                </div>


                {{-- =========================================
                    PROGRAM + SUBMENU
                ========================================== --}}
                <div class="menu_item menu_dropdown {{ $programActive ? 'active' : '' }}">

                    <button
                        type="button"
                        class="program_toggle"
                        aria-expanded="false"
                    >
                        <span>
                            {{ $isJapanese ? 'プログラム' : 'Program' }}
                        </span>

                        <iconify-icon
                            icon="solar:alt-arrow-down-linear"
                            class="dropdown_arrow">
                        </iconify-icon>
                    </button>


                    <div class="submenu">

                        {{-- Engineering --}}
                        <a
                            href="{{ $isJapanese ? '/jp/engineering' : '/engineering' }}"
                            class="{{ ($isJapanese ? request()->is('jp/engineering') : request()->is('engineering')) ? 'active' : '' }}"
                        >
                            {{ $isJapanese ? 'エンジニアリング' : 'Engineering' }}
                        </a>


                        {{-- Ginou Jisshusei --}}
                        <a
                            href="{{ $isJapanese ? '/jp/ginoujisshusei' : '/ginoujisshusei' }}"
                            class="{{ ($isJapanese ? request()->is('jp/ginoujisshusei') : request()->is('ginoujisshusei')) ? 'active' : '' }}"
                        >
                            {{ $isJapanese ? '技能実習生' : 'Ginou Jisshusei' }}
                        </a>


                        {{-- Tokutei Ginou --}}
                        <a
                            href="{{ $isJapanese ? '/jp/tg' : '/tg' }}"
                            class="{{ ($isJapanese ? request()->is('jp/tg') : request()->is('tg')) ? 'active' : '' }}"
                        >
                            {{ $isJapanese ? '特定技能' : 'Tokutei Ginou' }}
                        </a>


                        {{-- Kaigo --}}
                        <a
                            href="{{ $isJapanese ? '/jp/kaigo' : '/kaigo' }}"
                            class="{{ ($isJapanese ? request()->is('jp/kaigo') : request()->is('kaigo')) ? 'active' : '' }}"
                        >
                            {{ $isJapanese ? '介護' : 'Kaigo' }}
                        </a>


                        {{-- Nihongo Gakkou --}}
                        <a
                            href="{{ $isJapanese ? '/jp/nihongo-gakkou' : '/nihongo-gakkou' }}"
                            class="{{ ($isJapanese ? request()->is('jp/nihongo-gakkou') : request()->is('nihongo-gakkou')) ? 'active' : '' }}"
                        >
                            {{ $isJapanese ? '日本語学校' : 'Nihongo Gakkou' }}
                        </a>

                    </div>
                </div>


                {{-- =========================================
                    FAQ
                ========================================== --}}
                <div class="menu_item {{ $isFaqActive ? 'active' : '' }}">
                    <a href="{{ $isJapanese ? '/jp/pertanyaan-umum' : '/pertanyaan-umum' }}">
                        {{ $isJapanese ? 'よくある質問' : 'FAQ' }}
                    </a>
                </div>


                {{-- =========================================
                    GALERI
                ========================================== --}}
                <div class="menu_item {{ $isGalleryActive ? 'active' : '' }}">
                    <a href="{{ $isJapanese ? '/jp/galeri' : '/galeri' }}">
                        {{ $isJapanese ? 'ギャラリー' : 'Galeri' }}
                    </a>
                </div>


            </div>
        </div>


        {{-- =========================================
            BUTTON HUBUNGI KAMI
        ========================================== --}}
        <div class="button_box">
            <a href="{{ $isJapanese ? '/jp/kontak' : '/kontak' }}">
                <button>
                    {{ $isJapanese ? 'お問い合わせ' : 'Hubungi Kami' }}
                </button>
            </a>
        </div>


        {{-- =========================================
            HAMBURGER MOBILE
        ========================================== --}}
        <button
            class="hamburger"
            id="hamburger"
            aria-label="{{ $isJapanese ? 'メニューを開く' : 'Buka menu' }}"
        >
            <span></span>
            <span></span>
            <span></span>
        </button>

    </div>
</div>