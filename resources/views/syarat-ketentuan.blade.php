@extends('layouts_front.app')

@section('content_front')

<style>
    /* ============================================
    TERMS LAYOUT
    ============================================ */
    .terms_layout {
        width: 100%;
        padding: 2vw 8vw 4vw 8vw;
        background: #f8fafc;
        min-height: 80vh;
    }

    /* ============================================
    TERMS HEADER
    ============================================ */
    .terms_header {
        text-align: center;
        margin-bottom: 2.5vw;
        padding-bottom: 1.5vw;
        border-bottom: 0.15vw solid #e2e8f0;
    }

    .terms_header h1 {
        font-size: 3.2vw;
        font-family: techna, sans-serif;
        font-weight: 700;
        color: #0a2c55;
        margin-bottom: 0.3vw;
    }

    .terms_header p {
        font-size: 1.1vw;
        color: #475569;
        font-weight: 500;
    }

    .terms_header .terms_update {
        display: inline-block;
        margin-top: 0.5vw;
        padding: 0.3vw 1.5vw;
        background: #e2e8f0;
        border-radius: 2vw;
        font-size: 0.75vw;
        color: #64748b;
    }

    /* ============================================
    TERMS CONTENT
    ============================================ */
    .terms_content {
        max-width: 55vw;
        margin: 0 auto;
    }

    /* ============================================
    TERMS SECTION
    ============================================ */
    .terms_section {
        background: #ffffff;
        border-radius: 0.8vw;
        padding: 1.5vw 2vw;
        margin-bottom: 1.2vw;
        border: 0.1vw solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .terms_section:hover {
        border-color: #0a2c55;
        box-shadow: 0 0.2vw 0.8vw rgba(10, 44, 85, 0.06);
    }

    .terms_section h2 {
        font-size: 1.4vw;
        font-weight: 700;
        color: #0a2c55;
        margin-bottom: 0.8vw;
        display: flex;
        align-items: center;
        gap: 0.6vw;
    }

    .terms_section h2::before {
        content: '•';
        color: #0a2c55;
        font-size: 1.6vw;
    }

    .terms_section h3 {
        font-size: 1vw;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5vw;
    }

    .terms_section p {
        font-size: 0.9vw;
        color: #475569;
        line-height: 1.8;
        margin-bottom: 0.6vw;
    }

    .terms_section ol,
    .terms_section ul {
        padding-left: 1.5vw;
        margin-bottom: 0.3vw;
    }

    .terms_section ol li,
    .terms_section ul li {
        font-size: 0.85vw;
        color: #475569;
        line-height: 1.8;
        margin-bottom: 0.3vw;
    }

    .terms_section ol li::marker {
        color: #0a2c55;
        font-weight: 600;
    }

    .terms_section ul li::marker {
        color: #0a2c55;
    }

    /* ============================================
    DEFINITION LIST
    ============================================ */
    .terms_definition {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.8vw;
    }

    .def_item {
        display: flex;
        flex-direction: column;
        padding: 0.8vw 1vw;
        background: #f8fafc;
        border-radius: 0.5vw;
        border-left: 0.25vw solid #0a2c55;
    }

    .def_item .def_term {
        font-weight: 700;
        color: #0a2c55;
        font-size: 0.9vw;
    }

    .def_item .def_desc {
        font-size: 0.8vw;
        color: #64748b;
        margin-top: 0.2vw;
        line-height: 1.5;
    }

    /* ============================================
    TWO COLUMN
    ============================================ */
    .terms_two_col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5vw;
        margin-top: 0.5vw;
    }

    .terms_col {
        background: #f8fafc;
        padding: 1vw 1.5vw;
        border-radius: 0.5vw;
    }

    .terms_col h3 {
        font-size: 0.95vw;
        font-weight: 700;
        color: #0a2c55;
        margin-bottom: 0.5vw;
        display: flex;
        align-items: center;
        gap: 0.5vw;
    }

    .terms_col h3::before {
        font-size: 1.2vw;
    }

    .terms_col:first-child h3::before {
        content: '✅';
    }

    .terms_col:last-child h3::before {
        content: '📋';
    }

    .terms_col ul {
        padding-left: 1.2vw;
        margin: 0;
    }

    .terms_col ul li {
        font-size: 0.8vw;
        color: #475569;
        line-height: 1.8;
        margin-bottom: 0.2vw;
    }

    /* ============================================
    CONTACT SECTION
    ============================================ */
    .terms_contact {
        background: #f1f5f9;
        border-color: #0a2c55;
    }

    .terms_contact h2::before {
        content: '📞';
    }

    .terms_contact_info {
        display: flex;
        flex-direction: column;
        gap: 0.5vw;
        margin-top: 0.8vw;
    }

    .contact_item {
        display: flex;
        align-items: flex-start;
        gap: 0.8vw;
        padding: 0.5vw 0.8vw;
        background: #ffffff;
        border-radius: 0.5vw;
    }

    .contact_item iconify-icon {
        font-size: 1.2vw;
        color: #0a2c55;
        flex-shrink: 0;
        margin-top: 0.1vw;
    }

    .contact_item span {
        font-size: 0.85vw;
        color: #1e293b;
        line-height: 1.5;
    }

    /* ============================================
    AGREEMENT
    ============================================ */
    .terms_agreement {
        max-width: 55vw;
        margin: 2.5vw auto 0 auto;
        padding: 2vw 2.5vw;
        background: #0a2c55;
        border-radius: 0.8vw;
        text-align: center;
        color: #ffffff;
    }

    .terms_agreement p {
        font-size: 0.95vw;
        line-height: 1.7;
        opacity: 0.9;
        margin-bottom: 1.2vw;
    }

    .agreement_buttons {
        display: flex;
        justify-content: center;
        gap: 1vw;
    }

    .agreement_buttons .agree_btn,
    .agreement_buttons .contact_btn {
        padding: 0.7vw 2.5vw;
        border-radius: 0.6vw;
        font-size: 0.9vw;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .agreement_buttons .agree_btn {
        background: #ffffff;
        color: #0a2c55;
    }

    .agreement_buttons .agree_btn:hover {
        background: #e2e8f0;
        transform: translateY(-0.1vw);
    }

    .agreement_buttons .contact_btn {
        background: transparent;
        color: #ffffff;
        border: 0.12vw solid rgba(255, 255, 255, 0.3);
    }

    .agreement_buttons .contact_btn:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: #ffffff;
        transform: translateY(-0.1vw);
    }

    /* ============================================
    RESPONSIVE - MAX-WIDTH: 768px
    ============================================ */
    @media (max-width: 768px) {
        .terms_layout {
            padding: 4vw 5vw 8vw 5vw;
        }

        .terms_header h1 {
            font-size: 7vw;
        }

        .terms_header p {
            font-size: 2.8vw;
        }

        .terms_header .terms_update {
            font-size: 1.8vw;
            padding: 0.6vw 3vw;
            margin-top: 1.5vw;
        }

        .terms_content {
            max-width: 100%;
        }

        .terms_section {
            padding: 3.5vw 4vw;
            border-radius: 1.8vw;
            border-width: 0.15vw;
            margin-bottom: 2.5vw;
        }

        .terms_section h2 {
            font-size: 3.2vw;
            margin-bottom: 1.5vw;
        }

        .terms_section h2::before {
            font-size: 3.5vw;
        }

        .terms_section h3 {
            font-size: 2.4vw;
        }

        .terms_section p {
            font-size: 2vw;
            line-height: 1.8;
        }

        .terms_section ol,
        .terms_section ul {
            padding-left: 4vw;
        }

        .terms_section ol li,
        .terms_section ul li {
            font-size: 2vw;
            line-height: 1.8;
            margin-bottom: 0.8vw;
        }

        .terms_definition {
            grid-template-columns: 1fr;
            gap: 1.5vw;
        }

        .def_item {
            padding: 2vw 3vw;
            border-radius: 1.2vw;
            border-left-width: 0.5vw;
        }

        .def_item .def_term {
            font-size: 2.2vw;
        }

        .def_item .def_desc {
            font-size: 1.8vw;
            margin-top: 0.5vw;
        }

        .terms_two_col {
            grid-template-columns: 1fr;
            gap: 2vw;
        }

        .terms_col {
            padding: 2.5vw 3.5vw;
            border-radius: 1.2vw;
        }

        .terms_col h3 {
            font-size: 2.2vw;
        }

        .terms_col ul {
            padding-left: 3vw;
        }

        .terms_col ul li {
            font-size: 2vw;
            line-height: 1.8;
        }

        .terms_contact_info {
            gap: 1.5vw;
            margin-top: 2vw;
        }

        .contact_item {
            padding: 1.5vw 2vw;
            border-radius: 1.2vw;
            gap: 2vw;
        }

        .contact_item iconify-icon {
            font-size: 3.5vw;
        }

        .contact_item span {
            font-size: 2vw;
        }

        .terms_agreement {
            max-width: 100%;
            margin-top: 5vw;
            padding: 4vw 5vw;
            border-radius: 1.8vw;
        }

        .terms_agreement p {
            font-size: 2.2vw;
            line-height: 1.8;
            margin-bottom: 3vw;
        }

        .agreement_buttons {
            flex-direction: column;
            gap: 2vw;
            align-items: center;
        }

        .agreement_buttons .agree_btn,
        .agreement_buttons .contact_btn {
            padding: 1.5vw 5vw;
            font-size: 2.2vw;
            border-radius: 1.5vw;
            width: 100%;
            max-width: 50vw;
            text-align: center;
        }

        .agreement_buttons .contact_btn {
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

{{-- Terms Layout --}}
<div class="terms_layout">

    {{-- Header --}}
    <div class="terms_header">
        <h1>Syarat & Ketentuan</h1>
        <p>LPK SHIROKUMA Indonesia</p>
        <span class="terms_update">Terakhir diperbarui: 11 Agustus 2026</span>
    </div>

    {{-- Terms Content --}}
    <div class="terms_content">

        {{-- 1. Pendahuluan --}}
        <section class="terms_section">
            <h2>1. Pendahuluan</h2>
            <p>Selamat datang di website resmi LPK SHIROKUMA Indonesia. Dengan mengakses dan menggunakan layanan kami, Anda menyetujui untuk terikat dengan syarat dan ketentuan yang berlaku. Harap baca dengan seksama sebelum menggunakan layanan kami.</p>
            <p>LPK SHIROKUMA Indonesia adalah lembaga pelatihan kerja yang bergerak di bidang:</p>
            <ul>
                <li>Pelatihan Bahasa Jepang</li>
                <li>Persiapan Magang ke Jepang</li>
                <li>Pelatihan Keterampilan Kerja</li>
                <li>Konsultasi Karir</li>
            </ul>
        </section>

        {{-- 2. Definisi --}}
        <section class="terms_section">
            <h2>2. Definisi</h2>
            <div class="terms_definition">
                <div class="def_item">
                    <span class="def_term">Pengguna</span>
                    <span class="def_desc">Setiap individu atau entitas yang mengakses dan menggunakan layanan LPK SHIROKUMA Indonesia.</span>
                </div>
                <div class="def_item">
                    <span class="def_term">Layanan</span>
                    <span class="def_desc">Seluruh program pelatihan, konsultasi, dan informasi yang disediakan oleh LPK SHIROKUMA Indonesia.</span>
                </div>
                <div class="def_item">
                    <span class="def_term">Konten</span>
                    <span class="def_desc">Seluruh informasi, materi, gambar, video, dan data yang tersedia di website LPK SHIROKUMA Indonesia.</span>
                </div>
                <div class="def_item">
                    <span class="def_term">Peserta</span>
                    <span class="def_desc">Individu yang terdaftar dan mengikuti program pelatihan di LPK SHIROKUMA Indonesia.</span>
                </div>
            </div>
        </section>

        {{-- 3. Pendaftaran --}}
        <section class="terms_section">
            <h2>3. Pendaftaran dan Keikutsertaan</h2>
            <ol>
                <li>Pendaftaran peserta dilakukan secara online melalui website resmi atau datang langsung ke kantor LPK SHIROKUMA Indonesia.</li>
                <li>Calon peserta wajib mengisi formulir pendaftaran dengan data yang benar dan lengkap.</li>
                <li>LPK SHIROKUMA Indonesia berhak menolak pendaftaran jika data yang diberikan tidak lengkap atau tidak benar.</li>
                <li>Peserta wajib mengikuti seluruh proses seleksi yang ditentukan, termasuk tes tertulis dan wawancara.</li>
                <li>Hasil seleksi bersifat mutlak dan tidak dapat diganggu gugat.</li>
            </ol>
        </section>

        {{-- 4. Biaya dan Pembayaran --}}
        <section class="terms_section">
            <h2>4. Biaya dan Pembayaran</h2>
            <ol>
                <li>Biaya pelatihan ditentukan berdasarkan program yang dipilih dan diumumkan secara resmi.</li>
                <li>Pembayaran dapat dilakukan melalui transfer bank, e-wallet, atau metode pembayaran lain yang disediakan.</li>
                <li>Peserta wajib melunasi biaya pelatihan sesuai dengan jadwal yang ditentukan.</li>
                <li>Keterlambatan pembayaran dapat mengakibatkan penundaan atau pembatalan keikutsertaan.</li>
                <li>Biaya yang telah dibayarkan tidak dapat dikembalikan kecuali ada kesepakatan khusus dari LPK SHIROKUMA Indonesia.</li>
            </ol>
        </section>

        {{-- 5. Hak dan Kewajiban Peserta --}}
        <section class="terms_section">
            <h2>5. Hak dan Kewajiban Peserta</h2>
            <div class="terms_two_col">
                <div class="terms_col">
                    <h3>Hak Peserta</h3>
                    <ul>
                        <li>Mendapatkan materi pelatihan yang berkualitas</li>
                        <li>Mendapatkan bimbingan dari instruktur yang kompeten</li>
                        <li>Mengakses fasilitas pelatihan yang disediakan</li>
                        <li>Mendapatkan sertifikat setelah menyelesaikan program</li>
                        <li>Mendapatkan informasi terkait lowongan magang</li>
                    </ul>
                </div>
                <div class="terms_col">
                    <h3>Kewajiban Peserta</h3>
                    <ul>
                        <li>Mengikuti seluruh sesi pelatihan dengan disiplin</li>
                        <li>Menjaga nama baik LPK SHIROKUMA Indonesia</li>
                        <li>Menghormati instruktur dan sesama peserta</li>
                        <li>Mematuhi peraturan dan tata tertib yang berlaku</li>
                        <li>Melunasi biaya pelatihan tepat waktu</li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- 6. Hak Kekayaan Intelektual --}}
        <section class="terms_section">
            <h2>6. Hak Kekayaan Intelektual</h2>
            <ol>
                <li>Seluruh konten yang terdapat di website LPK SHIROKUMA Indonesia dilindungi oleh hak cipta dan hak kekayaan intelektual lainnya.</li>
                <li>Pengguna tidak diperkenankan menyalin, mendistribusikan, atau menggunakan konten tanpa izin tertulis dari LPK SHIROKUMA Indonesia.</li>
                <li>Materi pelatihan yang diberikan kepada peserta adalah hak milik LPK SHIROKUMA Indonesia dan tidak boleh disebarluaskan.</li>
                <li>Pelanggaran terhadap hak kekayaan intelektual akan dikenakan sanksi sesuai dengan ketentuan hukum yang berlaku.</li>
            </ol>
        </section>

        {{-- 7. Kerahasiaan Data --}}
        <section class="terms_section">
            <h2>7. Kerahasiaan Data</h2>
            <ol>
                <li>LPK SHIROKUMA Indonesia berkomitmen untuk melindungi data pribadi pengguna sesuai dengan peraturan perundang-undangan yang berlaku.</li>
                <li>Data pribadi peserta hanya akan digunakan untuk kepentingan pelatihan dan komunikasi resmi.</li>
                <li>LPK SHIROKUMA Indonesia tidak akan menjual atau menyebarkan data pribadi pengguna kepada pihak ketiga tanpa izin.</li>
                <li>Pengguna berhak untuk mengakses, memperbaiki, atau menghapus data pribadi mereka dengan menghubungi kami.</li>
            </ol>
        </section>

        {{-- 8. Pembatalan dan Pengunduran Diri --}}
        <section class="terms_section">
            <h2>8. Pembatalan dan Pengunduran Diri</h2>
            <ol>
                <li>Peserta dapat mengundurkan diri dari program pelatihan dengan memberikan pemberitahuan tertulis kepada LPK SHIROKUMA Indonesia.</li>
                <li>Pengunduran diri yang dilakukan setelah pelatihan dimulai tidak akan mendapatkan pengembalian biaya.</li>
                <li>LPK SHIROKUMA Indonesia berhak membatalkan keikutsertaan peserta jika melanggar peraturan yang berlaku.</li>
                <li>Pembatalan oleh LPK SHIROKUMA Indonesia karena alasan tertentu akan diikuti dengan pengembalian biaya secara proporsional.</li>
            </ol>
        </section>

        {{-- 9. Perubahan Syarat dan Ketentuan --}}
        <section class="terms_section">
            <h2>9. Perubahan Syarat dan Ketentuan</h2>
            <ol>
                <li>LPK SHIROKUMA Indonesia berhak untuk mengubah syarat dan ketentuan ini sewaktu-waktu tanpa pemberitahuan sebelumnya.</li>
                <li>Perubahan akan diumumkan melalui website resmi atau media komunikasi lainnya.</li>
                <li>Dengan terus menggunakan layanan kami, pengguna dianggap menyetujui perubahan yang berlaku.</li>
            </ol>
        </section>

        {{-- 10. Hukum yang Berlaku --}}
        <section class="terms_section">
            <h2>10. Hukum yang Berlaku</h2>
            <ol>
                <li>Syarat dan ketentuan ini diatur oleh hukum Negara Republik Indonesia.</li>
                <li>Segala sengketa yang timbul akan diselesaikan melalui musyawarah mufakat.</li>
                <li>Jika musyawarah tidak mencapai kesepakatan, sengketa akan diselesaikan di Pengadilan Negeri setempat.</li>
            </ol>
        </section>

        {{-- 11. Kontak Kami --}}
        <section class="terms_section terms_contact">
            <h2>11. Kontak Kami</h2>
            <p>Jika Anda memiliki pertanyaan tentang syarat dan ketentuan ini, silakan hubungi kami:</p>
            <div class="terms_contact_info">
                <div class="contact_item">
                    <iconify-icon icon="mdi:map-marker"></iconify-icon>
                    <span>Perum Winayajaya Blok A.26, RT.002/RW.003 Kelurahan Sambongjaya, Kecamatan Mangkubumi, Kota Tasikmalaya, Jawa Barat</span>
                </div>
                <div class="contact_item">
                    <iconify-icon icon="mdi:phone"></iconify-icon>
                    <span>+62851-2121-2200</span>
                </div>
                <div class="contact_item">
                    <iconify-icon icon="mdi:email"></iconify-icon>
                    <span>lpkshirokuma@gmail.com</span>
                </div>
            </div>
        </section>

    </div>

    {{-- Agreement --}}
    <div class="terms_agreement">
        <p>Dengan mengakses dan menggunakan layanan LPK SHIROKUMA Indonesia, Anda menyatakan telah membaca, memahami, dan menyetujui seluruh syarat dan ketentuan yang berlaku.</p>
        <div class="agreement_buttons">
            <a href="{{ url('/') }}" class="agree_btn">Saya Setuju</a>
            <a href="{{ url('/kontak') }}" class="contact_btn">Hubungi Kami</a>
        </div>
    </div>

</div>

@endsection