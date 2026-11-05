<div class="footer">
    <div class="footer_first">

        {{-- =========================================
            FOOTER IDENTITY
        ========================================== --}}
        <div class="footer_identity">

            <img
                src="{{ asset('images/logo_footer.png') }}"
                alt="LPK Shirokuma Indonesia"
            >

            <p>
                {{ $isJapanese
                    ? 'LPK Shirokuma Indonesiaは、日本語能力と仕事のスキルを身につけ、日本でのキャリアを目指す若者をサポートしています。'
                    : 'LPK Shirokuma Indonesia hadir untuk mempersiapkan generasi muda Indonesia dengan keterampilan bahasa Jepang dan kompetensi kerja sebagai bekal untuk berkarier di Jepang.'
                }}
            </p>

            {{-- SOCIAL MEDIA --}}
            <div class="social_media_footer">

                {{-- WhatsApp --}}
                <a
                    href="https://api.whatsapp.com/send?phone=6281224074427"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <div class="social_media_box">
                        <iconify-icon icon="ic:round-whatsapp"></iconify-icon>
                    </div>
                </a>

                {{-- Instagram --}}
                <a
                    href="https://www.instagram.com/lpk_so_shirokuma/"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <div class="social_media_box">
                        <iconify-icon icon="basil:instagram-outline"></iconify-icon>
                    </div>
                </a>

                {{-- TikTok --}}
                <a
                    href="https://www.tiktok.com/@lpk_shirokuma"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <div class="social_media_box">
                        <iconify-icon icon="ic:baseline-tiktok"></iconify-icon>
                    </div>
                </a>

                {{-- Facebook --}}
                <a
                    href="https://www.facebook.com/p/LPK-Shirokuma-Indonesia-61583256083793/"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <div class="social_media_box">
                        <iconify-icon icon="mdi:facebook"></iconify-icon>
                    </div>
                </a>

            </div>
        </div>


        {{-- =========================================
            FOOTER MENU
        ========================================== --}}
        <div class="menu_footer">

            {{-- Navigation --}}
            <div class="menu_footer_box">

                <h3>
                    {{ $isJapanese ? 'ナビゲーション' : 'Navigation' }}
                </h3>

                <ul>

                    {{-- Kontak --}}
                    <li>
                        <a href="{{ $isJapanese ? '/jp/kontak' : '/kontak-kami' }}">
                            {{ $isJapanese ? 'お問い合わせ' : 'Kontak Kami' }}
                        </a>
                    </li>

                    {{-- Legalitas --}}
                    <li>
                        <a href="{{ $isJapanese ? '/jp/legalitas' : '/legalitas' }}">
                            {{ $isJapanese ? '法的情報' : 'Legalitas' }}
                        </a>
                    </li>

                    {{-- Galeri --}}
                    <li>
                        <a href="{{ $isJapanese ? '/jp/galeri' : '/gallery' }}">
                            {{ $isJapanese ? 'ギャラリー' : 'Galeri' }}
                        </a>
                    </li>

                    {{-- Lowongan Kerja --}}
                    <li>
                        <a href="{{ $isJapanese ? '/jp/lowongan-kerja' : '/lowongan-kerja' }}">
                            {{ $isJapanese ? '求人情報' : 'Lowongan Kerja' }}
                        </a>
                    </li>

                </ul>
            </div>


            {{-- Quick Links --}}
            <div class="menu_footer_box">

                <h3>
                    {{ $isJapanese ? 'クイックリンク' : 'Quick Links' }}
                </h3>

                <ul>

                    {{-- FAQ --}}
                    <li>
                        <a href="{{ $isJapanese ? '/jp/pertanyaan-umum' : '/faq' }}">
                            {{ $isJapanese ? 'よくある質問' : 'FAQ' }}
                        </a>
                    </li>

                    {{-- Program --}}
                    <li>
                        <a href="{{ $isJapanese ? '/jp/kaigo' : '/kaigo' }}">
                            {{ $isJapanese ? 'プログラム' : 'Program' }}
                        </a>
                    </li>

                    {{-- Tentang Kami --}}
                    <li>
                        <a href="{{ $isJapanese ? '/jp/tentang-kami' : '/tentang-kami' }}">
                            {{ $isJapanese ? '私たちについて' : 'Tentang Kami' }}
                        </a>
                    </li>

                </ul>
            </div>

        </div>
    </div>


    {{-- =========================================
        FOOTER SECOND
    ========================================== --}}
    <div class="footer_second">

        <ul>

            {{-- Syarat & Ketentuan --}}
            <li>
                <a href="{{ $isJapanese ? '/jp/syarat-ketentuan' : '/syarat-ketentuan' }}">
                    {{ $isJapanese ? '利用規約' : 'Syarat & Ketentuan' }}
                </a>
            </li>

            {{-- Kebijakan Privasi --}}
            <li>
                <a href="{{ $isJapanese ? '/jp/kebijakan-privasi' : '/kebijakan-privasi' }}">
                    {{ $isJapanese ? 'プライバシーポリシー' : 'Kebijakan Privasi' }}
                </a>
            </li>

        </ul>

        <span>
            © 2026 LPK Shirokuma Indonesia |
            {{ $isJapanese ? '日本語' : 'ID' }}
        </span>

    </div>


    {{-- =========================================
        FOOTER THIRD
    ========================================== --}}
    <div class="footer_third">

        {{-- Disclaimer --}}
        <p>

            <span>
                {{ $isJapanese ? '免責事項:' : 'Disclaimer:' }}
            </span>

            {{ $isJapanese
                ? '当サイトでは第三者のウェブサイトに掲載されているコンテンツについて責任を負いません。情報をご確認のうえ、必要に応じて専門家にご相談ください。'
                : 'Kami tidak bertanggung jawab atas konten situs pihak ketiga. Verifikasi informasi dan konsultasikan dengan profesional sebelum mengambil keputusan.'
            }}

        </p>


        {{-- =========================================
            COMPANY DATA
        ========================================== --}}
        <div class="company_data">

            {{-- ADDRESS --}}
            <div class="company_data_box">

                <iconify-icon icon="carbon:location-filled"></iconify-icon>

                <div class="company_data_content">

                    <h5>
                        LPK Shirokuma Indonesia
                    </h5>

                    <p>
                        {{ $isJapanese
                            ? 'インドネシア西ジャワ州タシクマラヤ市マンクブミ地区 Perum Winayajaya Blok A.26, RT.002/RW.003'
                            : 'Perum Winayajaya Blok A.26, RT.002/RW.003 Kecamatan Mangkubumi Kota Tasikmalaya'
                        }}
                    </p>

                </div>

            </div>


            {{-- EMAIL --}}
            <div class="company_data_box">

                <iconify-icon icon="mdi:envelope"></iconify-icon>

                <div class="company_data_content">

                    <h5>
                        {{ $isJapanese ? 'メール' : 'Email' }}
                    </h5>

                    <p>
                        lpkshirokuma.com
                    </p>

                </div>

            </div>


            {{-- PHONE --}}
            <div class="company_data_box">

                <iconify-icon icon="ic:baseline-phone"></iconify-icon>

                <div class="company_data_content">

                    <h5>
                        {{ $isJapanese ? '電話番号' : 'Telepon' }}
                    </h5>

                    <p>
                        +62851-2121-2200
                    </p>

                </div>

            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".klienSwiper", {
    slidesPerView: 3,
    spaceBetween: 10,
    cssMode: true,
    autoplay: {
        delay: 2500,
        disableOnInteraction: true,
        pauseOnMouseEnter:true,
    },
    loop: true,
    breakpoints: {
        640: {
        slidesPerView: 2,
        spaceBetween: 20,
        },
        768: {
        slidesPerView: 4,
        spaceBetween: 40,
        },
        1024: {
        slidesPerView: 7,
        spaceBetween: 20,
        },
    },
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const hamburger = document.getElementById('hamburger');
        const menuBox = document.querySelector('.menu_box');

        const programToggle = document.querySelector('.program_toggle');
        const programDropdown = document.querySelector('.menu_dropdown');

        const menuLinks = document.querySelectorAll(
            '.menu_item:not(.menu_dropdown) a, .submenu a'
        );


        /* =========================================
        HAMBURGER
        ========================================= */

        hamburger.addEventListener('click', function () {

            hamburger.classList.toggle('active');
            menuBox.classList.toggle('active');

            const isOpen = hamburger.classList.contains('active');

            hamburger.setAttribute(
                'aria-label',
                isOpen ? 'Tutup menu' : 'Buka menu'
            );

        });


        /* =========================================
        PROGRAM DROPDOWN
        DESKTOP + MOBILE
        ========================================= */

        programToggle.addEventListener('click', function (e) {

            e.preventDefault();
            e.stopPropagation();

            programDropdown.classList.toggle('open');

        });


        /* =========================================
        KLIK SUBMENU
        ========================================= */

        menuLinks.forEach(function (link) {

            link.addEventListener('click', function () {

                hamburger.classList.remove('active');
                menuBox.classList.remove('active');

                programDropdown.classList.remove('open');

                hamburger.setAttribute(
                    'aria-label',
                    'Buka menu'
                );

            });

        });


        /* =========================================
        KLIK DI LUAR NAVBAR
        ========================================= */

        document.addEventListener('click', function (event) {

            if (!event.target.closest('.bottom_header')) {

                programDropdown.classList.remove('open');

            }

        });


        /* =========================================
        KLIK ITEM MENU LAIN
        ========================================= */

        document.querySelectorAll(
            '.menu_item:not(.menu_dropdown) a'
        ).forEach(function (link) {

            link.addEventListener('click', function () {

                programDropdown.classList.remove('open');

            });

        });


        /* =========================================
        RESIZE
        ========================================= */

        window.addEventListener('resize', function () {

            if (window.innerWidth > 768) {

                hamburger.classList.remove('active');
                menuBox.classList.remove('active');

                hamburger.setAttribute(
                    'aria-label',
                    'Buka menu'
                );

            }

        });

    });
</script>

<script>
    // ============================================
    // TOGGLE FAQ ANSWER
    // ============================================
    function toggleFAQ(element) {
        const item = element.closest('.faq_item');
        const answer = item.querySelector('.faq_answer');
        const icon = element.querySelector('.faq_icon');

        // Toggle active class
        item.classList.toggle('active');

        // Toggle icon rotation
        if (item.classList.contains('active')) {
            icon.style.transform = 'rotate(180deg)';
            answer.style.maxHeight = answer.scrollHeight + 'px';
        } else {
            icon.style.transform = 'rotate(0deg)';
            answer.style.maxHeight = '0';
        }
    }

    // ============================================
    // FILTER BY CATEGORY
    // ============================================
    function filterCategory(category) {
        // Update active button
        document.querySelectorAll('.cat_btn').forEach(function(btn) {
            btn.classList.remove('active');
            if (btn.dataset.category === category) {
                btn.classList.add('active');
            }
        });

        // Show/hide sections
        document.querySelectorAll('.faq_category_section').forEach(function(section) {
            if (category === 'all' || section.dataset.category === category) {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        });

        // Reset search
        document.getElementById('faqSearch').value = '';
        showAllItems();
        checkNoResult();
    }

    // ============================================
    // SEARCH FAQ
    // ============================================
    function filterFAQs() {
        const search = document.getElementById('faqSearch').value.toLowerCase().trim();

        // Reset semua item terlebih dahulu
        document.querySelectorAll('.faq_category_section').forEach(function(section) {
            const items = section.querySelectorAll('.faq_item');
            let hasVisible = false;

            items.forEach(function(item) {
                const question = item.querySelector('.faq_question span').textContent.toLowerCase();
                const answer = item.querySelector('.faq_answer p').textContent.toLowerCase();

                if (search === '' || question.includes(search) || answer.includes(search)) {
                    item.style.display = 'block';
                    hasVisible = true;
                } else {
                    item.style.display = 'none';
                }
            });

            // Tampilkan/sembunyikan section berdasarkan item yang terlihat
            if (search === '') {
                section.style.display = 'block';
            } else {
                section.style.display = hasVisible ? 'block' : 'none';
            }
        });

        // Reset category buttons
        if (search === '') {
            document.querySelectorAll('.cat_btn').forEach(function(btn) {
                btn.classList.remove('active');
                if (btn.dataset.category === 'all') {
                    btn.classList.add('active');
                }
            });
        }

        checkNoResult();
    }

    // ============================================
    // SHOW ALL ITEMS
    // ============================================
    function showAllItems() {
        document.querySelectorAll('.faq_item').forEach(function(item) {
            item.style.display = 'block';
        });
        document.querySelectorAll('.faq_category_section').forEach(function(section) {
            section.style.display = 'block';
        });
    }

    // ============================================
    // CHECK NO RESULT
    // ============================================
    function checkNoResult() {
        const noResult = document.getElementById('faqNoResult');
        const visibleItems = document.querySelectorAll('.faq_item[style*="display: block"]');

        if (visibleItems.length === 0) {
            noResult.style.display = 'flex';
        } else {
            noResult.style.display = 'none';
        }
    }

    // ============================================
    // AUTO-OPEN FAQ WITH HASH
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        // Jika ada hash di URL, buka FAQ tersebut
        if (window.location.hash) {
            const target = document.querySelector(window.location.hash);
            if (target && target.classList.contains('faq_item')) {
                setTimeout(function() {
                    const question = target.querySelector('.faq_question');
                    if (question) {
                        toggleFAQ(question);
                        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }, 500);
            }
        }
    });
</script>

<script>
    // ============================================
    // DATA GALERI
    // ============================================
    const galleryData = [];
    let currentGalleryIndex = 0;
    let currentFilter = 'all';
    let currentVisibleItems = [];
    let itemsPerLoad = 10;
    const isJapanesePage = window.location.pathname.startsWith('/jp');

    function getLoadMoreLabel(remaining) {
        if (isJapanesePage) {
            return '<iconify-icon icon="mdi:reload"></iconify-icon> さらに読み込む (残り ' + remaining + ' 件)';
        }
        return '<iconify-icon icon="mdi:reload"></iconify-icon> Muat Lebih Banyak (' + remaining + ' tersisa)';
    }

    // Kumpulkan data galeri dari DOM
    document.querySelectorAll('.gallery_item').forEach(function(item, index) {
        const img = item.querySelector('.gallery_image img');
        const type = item.dataset.type || 'image';
        
        galleryData.push({
            index: index,
            element: item,
            type: type,
            image: type === 'video' ? (item.dataset.video || '') : (img ? img.src : ''),
            video: type === 'video' ? (item.dataset.video || '') : '',
            title: item.dataset.title || '',
            category: item.dataset.category || 'all',
            isVisible: false
        });
    });

    // ============================================
    // GET ITEMS BY CATEGORY
    // ============================================
    function getItemsByCategory(category) {
        if (category === 'all') {
            return galleryData;
        }
        return galleryData.filter(function(item) {
            return item.category === category;
        });
    }

    // ============================================
    // FILTER GALERI
    // ============================================
    function filterGallery(category) {
        currentFilter = category;
        currentGalleryIndex = 0;
        
        // Update active button
        document.querySelectorAll('.gallery_cat_btn').forEach(function(btn) {
            btn.classList.remove('active');
            if (btn.dataset.category === category) {
                btn.classList.add('active');
            }
        });

        // Reset semua item
        const items = document.querySelectorAll('.gallery_item');
        items.forEach(function(item) {
            item.style.display = 'none';
            item.style.opacity = '0';
            item.style.transform = 'scale(0.95)';
        });

        // Dapatkan item berdasarkan kategori
        const filteredItems = getItemsByCategory(category);
        const itemsToShow = filteredItems.slice(0, itemsPerLoad);
        let visibleCount = 0;

        // Tampilkan item yang sesuai
        itemsToShow.forEach(function(data) {
            const item = data.element;
            item.style.display = 'block';
            visibleCount++;
            setTimeout(function() {
                item.style.opacity = '1';
                item.style.transform = 'scale(1)';
            }, 50 + (visibleCount * 50));
        });

        // 🔥 UPDATE LOAD MORE
        updateLoadMoreButton(category);

        // 🔥 SHOW/HIDE NO RESULT
        const noResult = document.getElementById('galleryNoResult');
        if (filteredItems.length === 0) {
            noResult.style.display = 'flex';
        } else {
            noResult.style.display = 'none';
        }

        // Update lightbox data
        updateLightboxData();
    }

    // ============================================
    // UPDATE LOAD MORE BUTTON
    // ============================================
    function updateLoadMoreButton(category) {
        const loadMore = document.querySelector('.gallery_load_more');
        const btn = loadMore?.querySelector('.load_more_btn');
        
        if (!loadMore || !btn) return;

        const filteredItems = getItemsByCategory(category);
        const currentVisible = getVisibleItemsCount(category);
        const remaining = filteredItems.length - currentVisible;

        if (remaining > 0) {
            loadMore.style.display = 'block';
            btn.innerHTML = getLoadMoreLabel(remaining);
            btn.disabled = false;
            btn.dataset.category = category;
        } else {
            loadMore.style.display = 'none';
        }
    }

    // ============================================
    // GET VISIBLE ITEMS COUNT
    // ============================================
    function getVisibleItemsCount(category) {
        const items = document.querySelectorAll('.gallery_item');
        let count = 0;
        items.forEach(function(item) {
            if (item.style.display !== 'none' && item.style.display !== '') {
                if (category === 'all' || item.dataset.category === category) {
                    count++;
                }
            }
        });
        return count;
    }

    // ============================================
    // LOAD MORE - PERBAIKI SESUAI KATEGORI
    // ============================================
    function loadMoreGallery() {
        const loadMore = document.querySelector('.gallery_load_more');
        const btn = loadMore?.querySelector('.load_more_btn');
        
        if (!btn) return;
        
        const category = btn.dataset.category || currentFilter;
        const filteredItems = getItemsByCategory(category);
        
        // Dapatkan item yang sudah visible
        const visibleItems = [];
        document.querySelectorAll('.gallery_item').forEach(function(item) {
            if (item.style.display !== 'none' && item.style.display !== '') {
                if (category === 'all' || item.dataset.category === category) {
                    visibleItems.push(item);
                }
            }
        });

        const currentVisible = visibleItems.length;
        const nextItems = filteredItems.slice(currentVisible, currentVisible + itemsPerLoad);
        
        if (nextItems.length === 0) {
            loadMore.style.display = 'none';
            return;
        }

        let count = 0;
        nextItems.forEach(function(data) {
            const item = data.element;
            item.style.display = 'block';
            count++;
            // Animasi muncul
            item.style.opacity = '0';
            item.style.transform = 'scale(0.95)';
            setTimeout(function() {
                item.style.opacity = '1';
                item.style.transform = 'scale(1)';
            }, 50 + (count * 50));
        });

        // Update tombol
        const remaining = filteredItems.length - (currentVisible + count);
        if (remaining > 0) {
            btn.innerHTML = getLoadMoreLabel(remaining);
            btn.disabled = false;
        } else {
            loadMore.style.display = 'none';
        }
    }

    // ============================================
    // OPEN LIGHTBOX (UNTUK GAMBAR)
    // ============================================
    function openLightbox(element) {
        const item = element.closest('.gallery_item');
        const index = Array.from(document.querySelectorAll('.gallery_item')).indexOf(item);
        
        if (index !== -1) {
            showLightbox(index);
        }
    }

    // ============================================
    // OPEN VIDEO LIGHTBOX
    // ============================================
    function openVideoLightbox(element) {
        const item = element.closest('.gallery_item');
        const index = Array.from(document.querySelectorAll('.gallery_item')).indexOf(item);
        
        if (index !== -1) {
            showLightbox(index);
        }
    }

    // ============================================
    // SHOW LIGHTBOX
    // ============================================
    function showLightbox(index) {
        const visibleItems = getVisibleItems();
        if (visibleItems.length === 0) return;

        currentGalleryIndex = visibleItems.findIndex(function(item) {
            return item.index === index;
        });

        if (currentGalleryIndex === -1) {
            currentGalleryIndex = 0;
        }

        updateLightboxMedia();
        
        const modal = document.getElementById('lightboxModal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    // ============================================
    // GET VISIBLE ITEMS
    // ============================================
    function getVisibleItems() {
        return galleryData.filter(function(item) {
            const el = item.element;
            return el.style.display !== 'none' && el.style.display !== '';
        });
    }

    // ============================================
    // UPDATE LIGHTBOX DATA
    // ============================================
    function updateLightboxData() {
        const visibleItems = getVisibleItems();
        if (visibleItems.length > 0 && currentGalleryIndex >= visibleItems.length) {
            currentGalleryIndex = 0;
        }
    }

    // ============================================
    // 🔥 UPDATE LIGHTBOX MEDIA (GAMBAR ATAU VIDEO)
    // ============================================
    function updateLightboxMedia() {
        const visibleItems = getVisibleItems();
        if (visibleItems.length === 0) return;

        const data = visibleItems[currentGalleryIndex];
        if (!data) return;

        const wrapper = document.getElementById('lightboxMediaWrapper');
        const counter = document.getElementById('lightboxCounter');

        if (!wrapper) return;

        // Hentikan video sebelumnya jika ada
        const oldIframe = wrapper.querySelector('iframe');
        if (oldIframe) {
            oldIframe.src = '';
        }

        // 🔥 TAMPILKAN BERDASARKAN TIPE
        if (data.type === 'video') {
            // Tampilkan video
            wrapper.innerHTML = `
                <div class="lightbox_video_wrapper">
                    <iframe src="${data.video}?autoplay=1&rel=0&modestbranding=1" 
                            class="lightbox_video_iframe"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                    </iframe>
                </div>
                ${data.title ? `<div class="lightbox_title">${data.title}</div>` : ''}
            `;
        } else {
            // Tampilkan gambar
            wrapper.innerHTML = `
                <img id="lightboxImage" src="${data.image}" alt="${data.title || 'Gallery Image ' + (currentGalleryIndex + 1)}" class="lightbox_image">
                ${data.title ? `<div class="lightbox_title">${data.title}</div>` : ''}
            `;
        }

        if (counter) {
            counter.textContent = (currentGalleryIndex + 1) + ' / ' + visibleItems.length;
        }

        // Update progress bar
        updateProgressBar(visibleItems.length);
    }

    // ============================================
    // UPDATE PROGRESS BAR
    // ============================================
    function updateProgressBar(total) {
        const progress = document.getElementById('lightboxProgress');
        if (progress) {
            const percent = ((currentGalleryIndex + 1) / total) * 100;
            progress.style.width = percent + '%';
        }
    }

    // ============================================
    // NAVIGATE LIGHTBOX
    // ============================================
    function navigateLightbox(direction) {
        const visibleItems = getVisibleItems();
        if (visibleItems.length === 0) return;

        currentGalleryIndex += direction;
        
        if (currentGalleryIndex < 0) {
            currentGalleryIndex = visibleItems.length - 1;
        } else if (currentGalleryIndex >= visibleItems.length) {
            currentGalleryIndex = 0;
        }

        updateLightboxMedia();
    }

    // ============================================
    // CLOSE LIGHTBOX
    // ============================================
    function closeLightbox() {
        const modal = document.getElementById('lightboxModal');
        modal.classList.remove('active');
        document.body.style.overflow = '';
        
        // Hentikan video
        const wrapper = document.getElementById('lightboxMediaWrapper');
        if (wrapper) {
            const iframe = wrapper.querySelector('iframe');
            if (iframe) {
                iframe.src = '';
            }
        }
    }

    // ============================================
    // 🔥 SWIPE & DRAG UNTUK LIGHTBOX
    // ============================================
    let touchStartX = 0;
    let touchStartY = 0;
    let touchEndX = 0;
    let touchEndY = 0;
    let isDragging = false;
    let isTransitioning = false;

    function initSwipeLightbox() {
        const content = document.getElementById('lightboxContent');
        const wrapper = document.getElementById('lightboxMediaWrapper');
        
        if (!content) return;

        // Touch events untuk mobile
        content.addEventListener('touchstart', function(e) {
            if (isTransitioning) return;
            const touch = e.touches[0];
            touchStartX = touch.clientX;
            touchStartY = touch.clientY;
            touchEndX = touch.clientX;
            touchEndY = touch.clientY;
            isDragging = true;
            
            // Cek apakah yang di-drag adalah gambar (bukan video)
            const img = this.querySelector('.lightbox_image');
            if (img) {
                this.style.transition = 'none';
            }
        }, { passive: true });

        content.addEventListener('touchmove', function(e) {
            if (!isDragging || isTransitioning) return;
            const touch = e.touches[0];
            touchEndX = touch.clientX;
            touchEndY = touch.clientY;
            
            const deltaX = touchEndX - touchStartX;
            const deltaY = touchEndY - touchStartY;
            
            // Hanya untuk gambar (bukan video)
            const img = this.querySelector('.lightbox_image');
            if (img && Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 20) {
                e.preventDefault();
                img.style.transform = `translateX(${deltaX}px) scale(0.95)`;
                img.style.opacity = 1 - Math.abs(deltaX) / 500;
            }
        }, { passive: false });

        content.addEventListener('touchend', function(e) {
            if (!isDragging || isTransitioning) {
                isDragging = false;
                return;
            }
            
            isDragging = false;
            const deltaX = touchEndX - touchStartX;
            const img = this.querySelector('.lightbox_image');
            
            if (img) {
                img.style.transition = 'all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)';
                
                if (Math.abs(deltaX) > 80) {
                    if (deltaX < 0) {
                        img.style.transform = 'translateX(-100px) scale(0.9)';
                        img.style.opacity = '0';
                        setTimeout(function() {
                            navigateLightbox(1);
                            resetImageStyle(img);
                        }, 200);
                    } else {
                        img.style.transform = 'translateX(100px) scale(0.9)';
                        img.style.opacity = '0';
                        setTimeout(function() {
                            navigateLightbox(-1);
                            resetImageStyle(img);
                        }, 200);
                    }
                } else {
                    img.style.transform = 'translateX(0) scale(1)';
                    img.style.opacity = '1';
                }
            }
            
            touchStartX = 0;
            touchStartY = 0;
            touchEndX = 0;
            touchEndY = 0;
        }, { passive: true });

        // Mouse events untuk desktop (hanya untuk gambar)
        let mouseStartX = 0;
        let isMouseDown = false;

        content.addEventListener('mousedown', function(e) {
            const img = this.querySelector('.lightbox_image');
            if (!img || isTransitioning) return;
            isMouseDown = true;
            mouseStartX = e.clientX;
            this.style.transition = 'none';
            this.style.cursor = 'grabbing';
        });

        document.addEventListener('mousemove', function(e) {
            if (!isMouseDown || isTransitioning) return;
            const deltaX = e.clientX - mouseStartX;
            const img = document.querySelector('.lightbox_image');
            
            if (img && Math.abs(deltaX) > 20) {
                img.style.transform = `translateX(${deltaX}px) scale(0.95)`;
                img.style.opacity = 1 - Math.abs(deltaX) / 500;
            }
        });

        document.addEventListener('mouseup', function(e) {
            if (!isMouseDown) return;
            isMouseDown = false;
            
            const img = document.querySelector('.lightbox_image');
            if (!img) return;
            
            const deltaX = e.clientX - mouseStartX;
            
            img.style.transition = 'all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)';
            
            if (Math.abs(deltaX) > 80) {
                if (deltaX < 0) {
                    img.style.transform = 'translateX(-100px) scale(0.9)';
                    img.style.opacity = '0';
                    setTimeout(function() {
                        navigateLightbox(1);
                        resetImageStyle(img);
                    }, 200);
                } else {
                    img.style.transform = 'translateX(100px) scale(0.9)';
                    img.style.opacity = '0';
                    setTimeout(function() {
                        navigateLightbox(-1);
                        resetImageStyle(img);
                    }, 200);
                }
            } else {
                img.style.transform = 'translateX(0) scale(1)';
                img.style.opacity = '1';
            }
            
            content.style.cursor = 'grab';
            mouseStartX = 0;
        });

        function resetImageStyle(img) {
            if (img) {
                img.style.transition = 'none';
                img.style.transform = 'translateX(0) scale(1)';
                img.style.opacity = '1';
                setTimeout(function() {
                    img.style.transition = 'all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)';
                }, 50);
            }
        }
    }

    // ============================================
    // NAVIGATE LIGHTBOX DENGAN TRANSISI
    // ============================================
    window.navigateLightbox = function(direction) {
        const visibleItems = getVisibleItems();
        if (visibleItems.length === 0) return;

        let newIndex = currentGalleryIndex + direction;
        
        if (newIndex < 0) newIndex = visibleItems.length - 1;
        if (newIndex >= visibleItems.length) newIndex = 0;
        
        if (newIndex === currentGalleryIndex) return;

        currentGalleryIndex = newIndex;
        isTransitioning = true;

        const wrapper = document.getElementById('lightboxMediaWrapper');
        if (wrapper) {
            wrapper.style.transition = 'all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1)';
            const directionSign = direction > 0 ? -1 : 1;
            wrapper.style.transform = `translateX(${directionSign * 60}px)`;
            wrapper.style.opacity = '0.5';
        }

        setTimeout(function() {
            updateLightboxMedia();
            const newWrapper = document.getElementById('lightboxMediaWrapper');
            
            if (newWrapper) {
                const directionSign = direction > 0 ? 1 : -1;
                newWrapper.style.transition = 'none';
                newWrapper.style.transform = `translateX(${directionSign * 60}px)`;
                newWrapper.style.opacity = '0.5';
                
                void newWrapper.offsetWidth;
                
                newWrapper.style.transition = 'all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)';
                newWrapper.style.transform = 'translateX(0)';
                newWrapper.style.opacity = '1';
            }
            
            setTimeout(function() {
                isTransitioning = false;
            }, 350);
        }, 250);
    };

    // ============================================
    // KEYBOARD NAVIGATION
    // ============================================
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('lightboxModal');
        if (modal.classList.contains('active')) {
            if (e.key === 'Escape') {
                closeLightbox();
            } else if (e.key === 'ArrowLeft') {
                navigateLightbox(-1);
            } else if (e.key === 'ArrowRight') {
                navigateLightbox(1);
            }
        }
    });

    // ============================================
    // INIT
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const items = document.querySelectorAll('.gallery_item');
        const loadMore = document.querySelector('.gallery_load_more');
        
        // Sembunyikan semua item dulu
        items.forEach(function(item) {
            item.style.display = 'none';
        });

        // Tampilkan 10 item pertama dari kategori 'all'
        const initialItems = galleryData.slice(0, itemsPerLoad);
        let count = 0;
        initialItems.forEach(function(data) {
            const item = data.element;
            item.style.display = 'block';
            count++;
            setTimeout(function() {
                item.style.opacity = '1';
                item.style.transform = 'scale(1)';
            }, 50 + (count * 50));
        });

        // Update load more untuk kategori 'all'
        const filteredItems = getItemsByCategory('all');
        if (filteredItems.length > itemsPerLoad) {
            if (loadMore) {
                loadMore.style.display = 'block';
                const btn = loadMore.querySelector('.load_more_btn');
                if (btn) {
                    btn.innerHTML = getLoadMoreLabel(filteredItems.length - itemsPerLoad);
                    btn.disabled = false;
                    btn.dataset.category = 'all';
                }
            }
        } else {
            if (loadMore) {
                loadMore.style.display = 'none';
            }
        }

        // Cek apakah total item = 0
        if (items.length === 0) {
            const noResult = document.getElementById('galleryNoResult');
            if (noResult) {
                noResult.style.display = 'flex';
            }
            if (loadMore) {
                loadMore.style.display = 'none';
            }
        }

        // Inisialisasi swipe
        setTimeout(function() {
            initSwipeLightbox();
        }, 300);
    });
</script>