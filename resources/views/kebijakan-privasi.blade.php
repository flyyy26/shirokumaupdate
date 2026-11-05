@extends('layouts_front.app')

@section('content_front')

<style>
    /* ============================================
    PRIVACY LAYOUT
    ============================================ */
    .privacy_layout {
        width: 100%;
        padding: 2vw 8vw 4vw 8vw;
        background: #f8fafc;
        min-height: 80vh;
    }

    /* ============================================
    PRIVACY HEADER
    ============================================ */
    .privacy_header {
        text-align: center;
        margin-bottom: 2.5vw;
        padding-bottom: 1.5vw;
        border-bottom: 0.15vw solid #e2e8f0;
    }

    .privacy_header h1 {
        font-size: 3.2vw;
        font-family: techna, sans-serif;
        font-weight: 700;
        color: #0a2c55;
        margin-bottom: 0.3vw;
    }

    .privacy_header p {
        font-size: 1.1vw;
        color: #475569;
        font-weight: 500;
    }

    .privacy_header .privacy_update {
        display: inline-block;
        margin-top: 0.5vw;
        padding: 0.3vw 1.5vw;
        background: #e2e8f0;
        border-radius: 2vw;
        font-size: 0.75vw;
        color: #64748b;
    }

    /* ============================================
    PRIVACY CONTENT
    ============================================ */
    .privacy_content {
        max-width: 55vw;
        margin: 0 auto;
    }

    /* ============================================
    PRIVACY SECTION
    ============================================ */
    .privacy_section {
        background: #ffffff;
        border-radius: 0.8vw;
        padding: 1.5vw 2vw;
        margin-bottom: 1.2vw;
        border: 0.1vw solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .privacy_section:hover {
        border-color: #0a2c55;
        box-shadow: 0 0.2vw 0.8vw rgba(10, 44, 85, 0.06);
    }

    .privacy_section h2 {
        font-size: 1.4vw;
        font-weight: 700;
        color: #0a2c55;
        margin-bottom: 0.8vw;
        display: flex;
        align-items: center;
        gap: 0.6vw;
    }

    .privacy_section h2::before {
        content: '•';
        color: #0a2c55;
        font-size: 1.6vw;
    }

    .privacy_section h3 {
        font-size: 1vw;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5vw;
    }

    .privacy_section p {
        font-size: 0.9vw;
        color: #475569;
        line-height: 1.8;
        margin-bottom: 0.6vw;
    }

    .privacy_section ol,
    .privacy_section ul {
        padding-left: 1.5vw;
        margin-bottom: 0.3vw;
    }

    .privacy_section ol li,
    .privacy_section ul li {
        font-size: 0.85vw;
        color: #475569;
        line-height: 1.8;
        margin-bottom: 0.3vw;
    }

    .privacy_section ol li::marker {
        color: #0a2c55;
        font-weight: 600;
    }

    .privacy_section ul li::marker {
        color: #0a2c55;
    }

    .privacy_section .privacy_note {
        background: #fef3c7;
        padding: 0.6vw 1vw;
        border-radius: 0.4vw;
        border-left: 0.25vw solid #f59e0b;
        font-size: 0.85vw;
        color: #92400e;
        margin-top: 0.5vw;
    }

    /* ============================================
    PRIVACY GRID - 4 COLUMNS
    ============================================ */
    .privacy_grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1vw;
        margin-top: 0.5vw;
    }

    .privacy_card {
        background: #f8fafc;
        border-radius: 0.6vw;
        padding: 1vw 1.2vw;
        text-align: center;
        border: 0.08vw solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .privacy_card:hover {
        border-color: #0a2c55;
        transform: translateY(-0.15vw);
        box-shadow: 0 0.3vw 0.8vw rgba(10, 44, 85, 0.08);
    }

    .privacy_card .card_icon {
        font-size: 2vw;
        margin-bottom: 0.3vw;
    }

    .privacy_card h3 {
        font-size: 0.85vw;
        font-weight: 700;
        color: #0a2c55;
        margin-bottom: 0.3vw;
    }

    .privacy_card ul {
        padding-left: 0;
        list-style: none;
        margin: 0;
    }

    .privacy_card ul li {
        font-size: 0.75vw;
        color: #64748b;
        line-height: 1.7;
        padding: 0.1vw 0;
        border-bottom: 0.05vw solid #e2e8f0;
    }

    .privacy_card ul li:last-child {
        border-bottom: none;
    }

    /* ============================================
    LEGAL ITEMS
    ============================================ */
    .privacy_legal {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.8vw;
        margin-top: 0.5vw;
    }

    .legal_item {
        display: flex;
        align-items: flex-start;
        gap: 0.8vw;
        padding: 0.8vw 1vw;
        background: #f8fafc;
        border-radius: 0.5vw;
        border-left: 0.25vw solid #0a2c55;
    }

    .legal_item .legal_badge {
        font-size: 1.2vw;
        flex-shrink: 0;
    }

    .legal_item h3 {
        font-size: 0.85vw;
        color: #0a2c55;
        margin-bottom: 0.1vw;
    }

    .legal_item p {
        font-size: 0.78vw;
        color: #64748b;
        line-height: 1.5;
        margin: 0;
    }

    /* ============================================
    RIGHTS ITEMS
    ============================================ */
    .privacy_rights {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.8vw;
        margin-top: 0.5vw;
    }

    .right_item {
        display: flex;
        align-items: flex-start;
        gap: 0.8vw;
        padding: 0.8vw 1vw;
        background: #f8fafc;
        border-radius: 0.5vw;
        border-left: 0.25vw solid #0a2c55;
    }

    .right_item .right_icon {
        font-size: 1.2vw;
        flex-shrink: 0;
    }

    .right_item h3 {
        font-size: 0.85vw;
        color: #0a2c55;
        margin-bottom: 0.1vw;
    }

    .right_item p {
        font-size: 0.78vw;
        color: #64748b;
        line-height: 1.5;
        margin: 0;
    }

    /* ============================================
    CONTACT SECTION
    ============================================ */
    .privacy_contact {
        background: #f1f5f9;
        border-color: #0a2c55;
    }

    .privacy_contact h2::before {
        content: '📞';
    }

    .privacy_contact_info {
        display: flex;
        flex-direction: column;
        gap: 0.5vw;
        margin-top: 0.8vw;
    }

    .privacy_contact_info .contact_item {
        display: flex;
        align-items: flex-start;
        gap: 0.8vw;
        padding: 0.5vw 0.8vw;
        background: #ffffff;
        border-radius: 0.5vw;
    }

    .privacy_contact_info .contact_item iconify-icon {
        font-size: 1.2vw;
        color: #0a2c55;
        flex-shrink: 0;
        margin-top: 0.1vw;
    }

    .privacy_contact_info .contact_item span {
        font-size: 0.85vw;
        color: #1e293b;
        line-height: 1.5;
    }

    /* ============================================
    CONSENT
    ============================================ */
    .privacy_consent {
        max-width: 55vw;
        margin: 2.5vw auto 0 auto;
        padding: 2vw 2.5vw;
        background: #0a2c55;
        border-radius: 0.8vw;
        text-align: center;
        color: #ffffff;
    }

    .privacy_consent p {
        font-size: 0.95vw;
        line-height: 1.7;
        opacity: 0.9;
        margin-bottom: 1.2vw;
    }

    .consent_buttons {
        display: flex;
        justify-content: center;
        gap: 1vw;
    }

    .consent_buttons .agree_btn,
    .consent_buttons .contact_btn {
        padding: 0.7vw 2.5vw;
        border-radius: 0.6vw;
        font-size: 0.9vw;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .consent_buttons .agree_btn {
        background: #ffffff;
        color: #0a2c55;
    }

    .consent_buttons .agree_btn:hover {
        background: #e2e8f0;
        transform: translateY(-0.1vw);
    }

    .consent_buttons .contact_btn {
        background: transparent;
        color: #ffffff;
        border: 0.12vw solid rgba(255, 255, 255, 0.3);
    }

    .consent_buttons .contact_btn:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: #ffffff;
        transform: translateY(-0.1vw);
    }

    /* ============================================
    RESPONSIVE - MAX-WIDTH: 768px
    ============================================ */
    @media (max-width: 768px) {
        .privacy_layout {
            padding: 4vw 5vw 8vw 5vw;
        }

        .privacy_header h1 {
            font-size: 7vw;
        }

        .privacy_header p {
            font-size: 2.8vw;
        }

        .privacy_header .privacy_update {
            font-size: 1.8vw;
            padding: 0.6vw 3vw;
            margin-top: 1.5vw;
        }

        .privacy_content {
            max-width: 100%;
        }

        .privacy_section {
            padding: 3.5vw 4vw;
            border-radius: 1.8vw;
            border-width: 0.15vw;
            margin-bottom: 2.5vw;
        }

        .privacy_section h2 {
            font-size: 3.2vw;
            margin-bottom: 1.5vw;
        }

        .privacy_section h2::before {
            font-size: 3.5vw;
        }

        .privacy_section h3 {
            font-size: 2.4vw;
        }

        .privacy_section p {
            font-size: 2vw;
            line-height: 1.8;
        }

        .privacy_section ol,
        .privacy_section ul {
            padding-left: 4vw;
        }

        .privacy_section ol li,
        .privacy_section ul li {
            font-size: 2vw;
            line-height: 1.8;
            margin-bottom: 0.8vw;
        }

        .privacy_section .privacy_note {
            padding: 1.5vw 2.5vw;
            border-left-width: 0.5vw;
            font-size: 2vw;
        }

        /* Privacy Grid - 2 columns on mobile */
        .privacy_grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5vw;
        }

        .privacy_card {
            padding: 2.5vw 2vw;
            border-radius: 1.2vw;
        }

        .privacy_card .card_icon {
            font-size: 5vw;
        }

        .privacy_card h3 {
            font-size: 2.2vw;
        }

        .privacy_card ul li {
            font-size: 1.8vw;
        }

        /* Legal & Rights - 1 column on mobile */
        .privacy_legal,
        .privacy_rights {
            grid-template-columns: 1fr;
            gap: 1.5vw;
        }

        .legal_item,
        .right_item {
            padding: 2vw 3vw;
            border-radius: 1.2vw;
            border-left-width: 0.5vw;
            gap: 2vw;
        }

        .legal_item .legal_badge,
        .right_item .right_icon {
            font-size: 3.5vw;
        }

        .legal_item h3,
        .right_item h3 {
            font-size: 2.2vw;
        }

        .legal_item p,
        .right_item p {
            font-size: 1.8vw;
        }

        .privacy_contact_info {
            gap: 1.5vw;
            margin-top: 2vw;
        }

        .privacy_contact_info .contact_item {
            padding: 1.5vw 2vw;
            border-radius: 1.2vw;
            gap: 2vw;
        }

        .privacy_contact_info .contact_item iconify-icon {
            font-size: 3.5vw;
        }

        .privacy_contact_info .contact_item span {
            font-size: 2vw;
        }

        .privacy_consent {
            max-width: 100%;
            margin-top: 5vw;
            padding: 4vw 5vw;
            border-radius: 1.8vw;
        }

        .privacy_consent p {
            font-size: 2.2vw;
            line-height: 1.8;
            margin-bottom: 3vw;
        }

        .consent_buttons {
            flex-direction: column;
            gap: 2vw;
            align-items: center;
        }

        .consent_buttons .agree_btn,
        .consent_buttons .contact_btn {
            padding: 1.5vw 5vw;
            font-size: 2.2vw;
            border-radius: 1.5vw;
            width: 100%;
            max-width: 50vw;
            text-align: center;
        }

        .consent_buttons .contact_btn {
            border-width: 0.2vw;
        }
    }

    /* ============================================
    BREADCRUMB STYLING
    ============================================ */
    .breadcrumb {
        padding: 0.8vw 8vw;
        background: #f8fafc;
        font-size: 0.85vw;
        color: #64748b;
    }

    .breadcrumb a {
        color: #0a2c55;
        text-decoration: none;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .breadcrumb {
            padding: 2vw 5vw;
            font-size: 2vw;
        }
    }
</style>

{{-- Privacy Layout --}}
<div class="privacy_layout">

    {{-- Header --}}
    <div class="privacy_header">
        <h1>Kebijakan Privasi</h1>
        <p>LPK SHIROKUMA Indonesia</p>
        <span class="privacy_update">Terakhir diperbarui: 11 Agustus 2026</span>
    </div>

    {{-- Privacy Content --}}
    <div class="privacy_content">

        {{-- 1. Pendahuluan --}}
        <section class="privacy_section">
            <h2>1. Pendahuluan</h2>
            <p>LPK SHIROKUMA Indonesia berkomitmen untuk melindungi privasi dan data pribadi Anda. Kebijakan privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi informasi pribadi yang Anda berikan kepada kami.</p>
            <p>Dengan menggunakan layanan kami, Anda menyetujui praktik pengumpulan dan penggunaan data yang dijelaskan dalam kebijakan ini.</p>
        </section>

        {{-- 2. Informasi yang Kami Kumpulkan --}}
        <section class="privacy_section">
            <h2>2. Informasi yang Kami Kumpulkan</h2>
            <p>Kami mengumpulkan informasi berikut dari pengguna:</p>
            <div class="privacy_grid">
                <div class="privacy_card">
                    <div class="card_icon">👤</div>
                    <h3>Informasi Identitas</h3>
                    <ul>
                        <li>Nama lengkap</li>
                        <li>Tempat dan tanggal lahir</li>
                        <li>Jenis kelamin</li>
                        <li>Kewarganegaraan</li>
                        <li>Nomor KTP / Paspor</li>
                    </ul>
                </div>
                <div class="privacy_card">
                    <div class="card_icon">📞</div>
                    <h3>Informasi Kontak</h3>
                    <ul>
                        <li>Alamat rumah</li>
                        <li>Nomor telepon / WhatsApp</li>
                        <li>Alamat email</li>
                        <li>Kontak darurat</li>
                    </ul>
                </div>
                <div class="privacy_card">
                    <div class="card_icon">📚</div>
                    <h3>Informasi Pendidikan</h3>
                    <ul>
                        <li>Riwayat pendidikan</li>
                        <li>Nilai / prestasi akademik</li>
                        <li>Sertifikat pelatihan</li>
                        <li>Kemampuan bahasa</li>
                    </ul>
                </div>
                <div class="privacy_card">
                    <div class="card_icon">💼</div>
                    <h3>Informasi Pekerjaan</h3>
                    <ul>
                        <li>Riwayat pekerjaan</li>
                        <li>Pengalaman magang</li>
                        <li>Keterampilan kerja</li>
                        <li>Referensi kerja</li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- 3. Cara Kami Menggunakan Informasi --}}
        <section class="privacy_section">
            <h2>3. Cara Kami Menggunakan Informasi</h2>
            <p>Informasi yang kami kumpulkan digunakan untuk:</p>
            <ol>
                <li><strong>Pendaftaran dan Administrasi:</strong> Memproses pendaftaran Anda sebagai peserta pelatihan atau magang.</li>
                <li><strong>Komunikasi:</strong> Menghubungi Anda mengenai program pelatihan, jadwal, dan informasi penting lainnya.</li>
                <li><strong>Peningkatan Layanan:</strong> Mengevaluasi dan meningkatkan kualitas pelatihan dan layanan kami.</li>
                <li><strong>Kepatuhan Hukum:</strong> Memenuhi kewajiban hukum dan peraturan yang berlaku.</li>
                <li><strong>Penempatan Magang:</strong> Menghubungkan Anda dengan perusahaan mitra untuk program magang.</li>
                <li><strong>Pelaporan:</strong> Membuat laporan internal dan statistik untuk pengembangan program.</li>
            </ol>
        </section>

        {{-- 4. Dasar Hukum Pemrosesan Data --}}
        <section class="privacy_section">
            <h2>4. Dasar Hukum Pemrosesan Data</h2>
            <p>Kami memproses data pribadi Anda berdasarkan dasar hukum berikut:</p>
            <div class="privacy_legal">
                <div class="legal_item">
                    <span class="legal_badge">✅</span>
                    <div>
                        <h3>Persetujuan</h3>
                        <p>Anda telah memberikan persetujuan untuk pemrosesan data pribadi Anda untuk tujuan tertentu.</p>
                    </div>
                </div>
                <div class="legal_item">
                    <span class="legal_badge">📋</span>
                    <div>
                        <h3>Kontrak</h3>
                        <p>Pemrosesan diperlukan untuk melaksanakan kontrak dengan Anda atau untuk mengambil langkah-langkah atas permintaan Anda sebelum memasuki kontrak.</p>
                    </div>
                </div>
                <div class="legal_item">
                    <span class="legal_badge">⚖️</span>
                    <div>
                        <h3>Kewajiban Hukum</h3>
                        <p>Pemrosesan diperlukan untuk mematuhi kewajiban hukum yang berlaku.</p>
                    </div>
                </div>
                <div class="legal_item">
                    <span class="legal_badge">🎯</span>
                    <div>
                        <h3>Kepentingan Sah</h3>
                        <p>Pemrosesan diperlukan untuk kepentingan sah yang kami kejar, seperti meningkatkan layanan dan keamanan.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- 5. Penyimpanan dan Keamanan Data --}}
        <section class="privacy_section">
            <h2>5. Penyimpanan dan Keamanan Data</h2>
            <ol>
                <li>Data pribadi Anda disimpan dalam sistem yang aman dan hanya dapat diakses oleh personel yang berwenang.</li>
                <li>Kami menerapkan langkah-langkah keamanan teknis dan organisasi yang sesuai untuk melindungi data dari akses tidak sah, perubahan, atau penghancuran.</li>
                <li>Data pribadi akan disimpan selama diperlukan untuk memenuhi tujuan pengumpulan data atau selama diwajibkan oleh peraturan perundang-undangan.</li>
                <li>Setelah tidak diperlukan lagi, data pribadi akan dihapus atau dianonimkan secara aman.</li>
            </ol>
        </section>

        {{-- 6. Berbagi Data dengan Pihak Ketiga --}}
        <section class="privacy_section">
            <h2>6. Berbagi Data dengan Pihak Ketiga</h2>
            <p>Kami tidak akan menjual atau menyewakan data pribadi Anda kepada pihak ketiga. Namun, kami dapat membagikan data Anda dengan:</p>
            <ul>
                <li><strong>Perusahaan Mitra:</strong> Untuk keperluan penempatan magang dan rekrutmen kerja.</li>
                <li><strong>Penyedia Layanan:</strong> Pihak ketiga yang membantu kami dalam operasional, seperti platform pembelajaran online atau sistem pembayaran.</li>
                <li><strong>Instansi Pemerintah:</strong> Jika diwajibkan oleh hukum atau untuk kepentingan publik.</li>
                <li><strong>Konsultan:</strong> Untuk keperluan audit dan konsultasi yang berkaitan dengan operasional kami.</li>
            </ul>
            <p class="privacy_note">Semua pihak ketiga yang menerima data Anda wajib mematuhi standar keamanan dan kerahasiaan yang setara dengan kami.</p>
        </section>

        {{-- 7. Hak Anda sebagai Subjek Data --}}
        <section class="privacy_section">
            <h2>7. Hak Anda sebagai Subjek Data</h2>
            <p>Sebagai pemilik data pribadi, Anda memiliki hak-hak berikut:</p>
            <div class="privacy_rights">
                <div class="right_item">
                    <span class="right_icon">🔍</span>
                    <div>
                        <h3>Hak Akses</h3>
                        <p>Anda berhak untuk meminta salinan data pribadi yang kami simpan tentang Anda.</p>
                    </div>
                </div>
                <div class="right_item">
                    <span class="right_icon">✏️</span>
                    <div>
                        <h3>Hak Perbaikan</h3>
                        <p>Anda berhak untuk meminta koreksi jika ada kesalahan pada data pribadi Anda.</p>
                    </div>
                </div>
                <div class="right_item">
                    <span class="right_icon">🗑️</span>
                    <div>
                        <h3>Hak Penghapusan</h3>
                        <p>Anda berhak untuk meminta penghapusan data pribadi Anda dalam kondisi tertentu.</p>
                    </div>
                </div>
                <div class="right_item">
                    <span class="right_icon">⛔</span>
                    <div>
                        <h3>Hak Pembatasan</h3>
                        <p>Anda berhak untuk meminta pembatasan pemrosesan data pribadi Anda.</p>
                    </div>
                </div>
                <div class="right_item">
                    <span class="right_icon">📤</span>
                    <div>
                        <h3>Hak Portabilitas</h3>
                        <p>Anda berhak untuk menerima data pribadi Anda dalam format yang terstruktur dan umum digunakan.</p>
                    </div>
                </div>
                <div class="right_item">
                    <span class="right_icon">🙅</span>
                    <div>
                        <h3>Hak Menolak</h3>
                        <p>Anda berhak untuk menolak pemrosesan data pribadi Anda untuk tujuan pemasaran langsung.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- 8. Cookie dan Teknologi Pelacakan --}}
        <section class="privacy_section">
            <h2>8. Cookie dan Teknologi Pelacakan</h2>
            <p>Website kami menggunakan cookie dan teknologi serupa untuk meningkatkan pengalaman pengguna:</p>
            <ul>
                <li><strong>Cookie Esensial:</strong> Diperlukan untuk fungsi dasar website, seperti navigasi dan akses ke area yang aman.</li>
                <li><strong>Cookie Analitik:</strong> Membantu kami memahami bagaimana pengguna berinteraksi dengan website kami untuk meningkatkan konten dan layanan.</li>
                <li><strong>Cookie Preferensi:</strong> Mengingat preferensi Anda, seperti bahasa yang dipilih.</li>
                <li><strong>Cookie Pemasaran:</strong> Digunakan untuk menampilkan konten yang relevan dengan minat Anda.</li>
            </ul>
            <p class="privacy_note">Anda dapat mengontrol pengaturan cookie melalui browser Anda. Namun, menonaktifkan cookie tertentu dapat mempengaruhi fungsionalitas website.</p>
        </section>

        {{-- 9. Perlindungan Data Anak --}}
        <section class="privacy_section">
            <h2>9. Perlindungan Data Anak</h2>
            <p>LPK SHIROKUMA Indonesia tidak secara sengaja mengumpulkan data pribadi dari anak-anak di bawah usia 18 tahun tanpa persetujuan orang tua atau wali yang sah. Jika kami mengetahui bahwa kami telah mengumpulkan data dari anak di bawah 18 tahun tanpa persetujuan yang sesuai, kami akan menghapus informasi tersebut sesegera mungkin.</p>
            <p>Untuk program pelatihan yang diperuntukkan bagi peserta di bawah 18 tahun, kami akan meminta persetujuan tertulis dari orang tua atau wali.</p>
        </section>

        {{-- 10. Perubahan Kebijakan Privasi --}}
        <section class="privacy_section">
            <h2>10. Perubahan Kebijakan Privasi</h2>
            <ol>
                <li>Kami dapat memperbarui kebijakan privasi ini dari waktu ke waktu untuk mencerminkan perubahan dalam praktik kami atau untuk alasan operasional, hukum, atau peraturan lainnya.</li>
                <li>Perubahan akan diumumkan melalui website resmi kami dan akan berlaku segera setelah dipublikasikan.</li>
                <li>Kami mendorong Anda untuk secara berkala meninjau halaman ini untuk mendapatkan informasi terbaru tentang praktik privasi kami.</li>
                <li>Penggunaan berkelanjutan Anda atas layanan kami setelah perubahan dianggap sebagai penerimaan terhadap kebijakan privasi yang diperbarui.</li>
            </ol>
        </section>

        {{-- 11. Kontak Kami --}}
        <section class="privacy_section privacy_contact">
            <h2>11. Kontak Kami</h2>
            <p>Jika Anda memiliki pertanyaan, kekhawatiran, atau ingin menggunakan hak-hak Anda terkait data pribadi, silakan hubungi kami:</p>
            <div class="privacy_contact_info">
                <div class="contact_item">
                    <iconify-icon icon="mdi:map-marker"></iconify-icon>
                    <span>Perum Winayajaya Blok A.26, RT.002/RW.003 Kelurahan Sambongjaya, Kecamatan Mangkubumi, Kota Tasikmalaya, Jawa Barat</span>
                </div>
                <div class="contact_item">
                    <iconify-icon icon="mdi:phone"></iconify-icon>
                    <span>+62812-2407-4427</span>
                </div>
                <div class="contact_item">
                    <iconify-icon icon="mdi:email"></iconify-icon>
                    <span>lpkshirokuma@gmail.com</span>
                </div>
                <div class="contact_item">
                    <iconify-icon icon="mdi:clock-outline"></iconify-icon>
                    <span>Senin - Jumat, 08.00 - 17.00 WIB</span>
                </div>
            </div>
        </section>

    </div>

    {{-- Consent --}}
    <div class="privacy_consent">
        <p>Dengan mengakses dan menggunakan layanan LPK SHIROKUMA Indonesia, Anda menyatakan telah membaca, memahami, dan menyetujui seluruh kebijakan privasi yang berlaku.</p>
        <div class="consent_buttons">
            <a href="{{ url('/') }}" class="agree_btn">✅ Saya Setuju</a>
            <a href="{{ url('/kontak') }}" class="contact_btn">📞 Hubungi Kami</a>
        </div>
    </div>

</div>

@endsection