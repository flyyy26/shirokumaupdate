@extends('layouts_front.app')

@section('content_front')

<style>
/* ============================================
   PENDAFTARAN LAYOUT
   ============================================ */
.pendaftaran_layout {
    width: 100%;
    padding: 4vw 24vw 4vw 24vw;
    background: url(../images/blue-bg.png), linear-gradient(90deg, #01102D 0%, #294966 48.56%, #08203E 100%);
    background-blend-mode: multiply;
    background-size: contain;
    background-position: center;
    min-height: 80vh;
    position: relative;
    overflow-x: hidden;
}

/* ============================================
   HEADER
   ============================================ */
.pendaftaran_header {
    text-align: center;
    margin-bottom: 2.5vw;
}

.pendaftaran_header h1 {
    font-size: 3.2vw;
    font-family: techna, sans-serif;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 0.5vw;
}

.pendaftaran_header p {
    font-size: 1vw;
    color: #e2e6eb;
    max-width: 40vw;
    margin: 0 auto;
    line-height: 1.7;
}

/* ============================================
   ALERT
   ============================================ */
.alert_success {
    display: flex;
    align-items: flex-start;
    gap: 0.8vw;
    background: rgba(34, 197, 94, 0.12);
    border: 1px solid rgba(34, 197, 94, 0.25);
    color: #4ade80;
    padding: 1vw 1.5vw;
    border-radius: 0.6vw;
    margin-bottom: 1.5vw;
}

.alert_success iconify-icon {
    flex-shrink: 0;
    margin-top: 0.1vw;
}

.alert_link {
    color: #4ade80;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.3vw;
    font-size: 0.85vw;
    margin-top: 0.2vw;
}

.alert_link:hover {
    text-decoration: underline;
    opacity: 0.8;
}

.alert_error {
    display: flex;
    flex-direction: column;
    background: rgba(239, 68, 68, 0.12);
    border: 1px solid rgba(239, 68, 68, 0.25);
    color: #f87171;
    padding: 1vw 1.5vw;
    border-radius: 0.6vw;
    margin-bottom: 1.5vw;
}

.alert_error iconify-icon {
    flex-shrink: 0;
}

/* ============================================
   CARD
   ============================================ */
.pendaftaran_card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 1vw;
    border: 0.1vw solid rgba(255, 255, 255, 0.08);
    padding: 2vw;
    margin-bottom: 2.5vw;
    transition: all 0.3s ease;
}

.pendaftaran_card:hover {
    border-color: rgba(183, 144, 78, 0.3);
    box-shadow: 0 0.5vw 1.5vw rgba(183, 144, 78, 0.05);
}

/* ============================================
   FORM SECTION
   ============================================ */
.form_section {
    margin-bottom: 2vw;
    padding-bottom: 2vw;
    border-bottom: 0.1vw solid rgba(255, 255, 255, 0.05);
}

.form_section:last-of-type {
    border-bottom: none;
    margin-bottom: 0;
}

.form_section_payment {
    background: rgba(59, 130, 246, 0.05);
    border-radius: 0.8vw;
    padding: 1.5vw;
    border: 0.1vw solid rgba(59, 130, 246, 0.1);
}

.section_title {
    display: flex;
    align-items: center;
    gap: 0.5vw;
    font-size: 1.1vw;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 1.2vw;
}

.section_title iconify-icon {
    color: #D2B780;
}

/* ============================================
   FORM GROUP
   ============================================ */
.form_grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.2vw;
}

.form_group_full {
    grid-column: 1 / -1;
}

.form_group {
    display: flex;
    flex-direction: column;
    gap: 0.4vw;
}

.form_label {
    font-size: 0.85vw;
    font-weight: 500;
    color: #e2e6eb;
}

.text_required {
    color: #f87171;
}

.form_input {
    width: 100%;
    background: rgba(255, 255, 255, 0.05);
    border: 0.1vw solid rgba(255, 255, 255, 0.12);
    border-radius: 0.6vw;
    padding: 0.7vw 1vw;
    color: #ffffff;
    font-size: 0.9vw;
    transition: all 0.3s ease;
}

.form_input::placeholder {
    color: #94a3b8;
}

.form_input:focus {
    outline: none;
    border-color: #B7904E;
    box-shadow: 0 0 0 0.2vw rgba(183, 144, 78, 0.15);
}

.form_input:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.form_textarea {
    min-height: 6vw;
    resize: vertical;
}

.form_input_file {
    width: 100%;
    background: rgba(255, 255, 255, 0.05);
    border: 0.1vw solid rgba(255, 255, 255, 0.12);
    border-radius: 0.6vw;
    padding: 0.5vw;
    color: #ffffff;
    font-size: 0.85vw;
    cursor: pointer;
}

.form_input_file::file-selector-button {
    background: rgba(183, 144, 78, 0.2);
    color: #D2B780;
    border: none;
    padding: 0.4vw 1vw;
    border-radius: 0.4vw;
    margin-right: 0.8vw;
    cursor: pointer;
    transition: all 0.3s ease;
}

.form_input_file::file-selector-button:hover {
    background: rgba(183, 144, 78, 0.3);
}

/* ============================================
   RADIO GROUP
   ============================================ */
.radio_group {
    display: flex;
    flex-wrap: wrap;
    gap: 0.6vw;
}

.radio_option {
    display: flex;
    align-items: center;
    gap: 0.4vw;
    padding: 0.4vw 1vw;
    background: rgba(255, 255, 255, 0.05);
    border: 0.1vw solid rgba(255, 255, 255, 0.12);
    border-radius: 0.5vw;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #c0cad8;
    font-size: 0.85vw;
}

.radio_option:hover {
    background: rgba(255, 255, 255, 0.08);
    border-color: #B7904E;
}

.radio_option input[type="radio"] {
    display: none;
}

.radio_option input[type="radio"]:checked + span {
    color: #ffffff;
}

.radio_option:has(input:checked) {
    background: rgba(183, 144, 78, 0.15);
    border-color: #B7904E;
}

/* ============================================
   PAYMENT
   ============================================ */
.payment_text {
    color: #c0cad8;
    font-size: 0.9vw;
    margin-bottom: 0.5vw;
}

.payment_amount {
    font-size: 2.5vw;
    font-weight: 700;
    color: #D2B780;
    margin-bottom: 1vw;
}

.payment_bank {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 0.6vw;
    padding: 1vw 1.2vw;
    margin-bottom: 1vw;
}

.payment_bank h4 {
    font-size: 0.9vw;
    font-weight: 600;
    color: #ffffff;
    margin-bottom: 0.3vw;
}

.box_copy {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: rgba(255, 255, 255, 0.08);
    padding: 0.6vw 1vw;
    border-radius: 0.5vw;
    font-family: monospace;
    font-size: 1.1vw;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 0.1vw solid rgba(255, 255, 255, 0.08);
    color: #ffffff;
}

.box_copy:hover {
    background: rgba(255, 255, 255, 0.12);
    border-color: #B7904E;
}

.box_copy span {
    background: #B7904E;
    color: #ffffff;
    padding: 0.2vw 0.6vw;
    border-radius: 0.3vw;
    font-size: 0.7vw;
    font-family: system-ui;
    transition: all 0.3s ease;
}

.box_copy.copied {
    background: rgba(34, 197, 94, 0.15);
    border-color: #4ade80;
}

.box_copy.copied span {
    background: #4ade80;
    color: #01102D;
}

.bank_name {
    font-size: 0.75vw;
    color: #94a3b8;
    margin-top: 0.3vw;
}

.file_hint {
    font-size: 0.7vw;
    color: #94a3b8;
    margin-top: 0.2vw;
}

.file_preview {
    display: flex;
    align-items: center;
    gap: 0.5vw;
    background: rgba(34, 197, 94, 0.08);
    border: 0.1vw solid rgba(34, 197, 94, 0.15);
    border-radius: 0.4vw;
    padding: 0.5vw 0.8vw;
    margin-top: 0.5vw;
}

.file_preview iconify-icon {
    color: #4ade80;
}

.file_name {
    color: #4ade80;
    font-size: 0.8vw;
}

.file_preview.hidden {
    display: none;
}

/* ============================================
   FORM INFO
   ============================================ */
.form_info {
    display: flex;
    align-items: flex-start;
    gap: 0.5vw;
    background: rgba(183, 144, 78, 0.05);
    border: 0.1vw solid rgba(183, 144, 78, 0.1);
    border-radius: 0.5vw;
    padding: 0.8vw 1vw;
    margin-top: 1.5vw;
}

.form_info iconify-icon {
    color: #D2B780;
    flex-shrink: 0;
    margin-top: 0.1vw;
}

.form_info p {
    font-size: 0.8vw;
    color: #c0cad8;
    margin: 0;
}

/* ============================================
   FORM SUBMIT
   ============================================ */
.form_submit {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1vw;
    margin-top: 1.5vw;
    padding-top: 1.5vw;
    border-top: 0.1vw solid rgba(255, 255, 255, 0.05);
    flex-wrap: wrap;
}

.form_submit_text {
    font-size: 0.7vw;
    color: #94a3b8;
    display: flex;
    align-items: center;
    gap: 0.3vw;
    margin: 0;
}

.btn_submit {
    display: inline-flex;
    align-items: center;
    gap: 0.5vw;
    background: linear-gradient(90deg, #B7904E 26.92%, #D2B780 48.56%, #B7904E 71.63%);
    color: #ffffff;
    padding: 0.7vw 2vw;
    border-radius: 0.6vw;
    font-size: 0.9vw;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn_submit:hover {
    opacity: 0.9;
    transform: scale(1.02);
    box-shadow: 0 0.3vw 0.8vw rgba(183, 144, 78, 0.3);
}

.btn_submit:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

/* ============================================
   QUESTIONS
   ============================================ */
.pendaftaran_questions {
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
    .pendaftaran_layout {
        padding: 12vw 6vw 10vw 6vw;
    }
    .pendaftaran_header {
        text-align: center;
        margin-bottom: 6.5vw;
    }

    .pendaftaran_header h1 {
        font-size: 7vw;
        margin-bottom: 1.5vw;
    }

    .pendaftaran_header p {
        font-size: 3vw;
        max-width: 85vw;
    }

    .pendaftaran_card {
        padding: 4vw;
        border-radius: 2.5vw;
    }

    .form_grid {
        grid-template-columns: 1fr;
        gap: 4.5vw;
    }

    .form_section {
        margin-bottom: 4vw;
        padding-bottom: 4vw;
    }
    .form_section_payment {
        background: rgba(59, 130, 246, 0.05);
        border-radius: 2.8vw;
        padding: 3.5vw;
        border: 0.1vw solid rgba(59, 130, 246, 0.1);
    }

    .section_title {
        font-size: 4vw;
        gap: 1.5vw;
        margin-bottom: 3vw;
    }

    .form_label {
        font-size: 3.5vw;
    }

    .form_input {
        font-size: 3.5vw;
        padding: 2.5vw 3.5vw;
        border-radius: 1.5vw;
        border-width: 0.15vw;
        margin-top: 2vw;
    }

    .form_textarea {
        min-height: 12vw;
    }

    .form_input_file {
        font-size: 3.5vw;
        padding: 3vw;
        border-radius: 1.5vw;
        margin-top: 3vw;
    }

    .form_input_file::file-selector-button {
        padding: 1vw 2vw;
        font-size: 3.5vw;
        border-radius: 2vw;
    }

    .radio_group {
        gap: 3vw;
        margin-top: 2vw;
    }

    .radio_option {
        padding: 2vw 3.5vw;
        font-size: 3.5vw;
        border-radius: 1.5vw;
        border-width: 0.15vw;
    }
    .payment_text {
        color: #c0cad8;
        font-size: 3vw;
        margin-bottom: 3.5vw;
    }

    .payment_amount {
        font-size: 7vw;
        margin-bottom: 2vw;
    }

    .payment_bank {
        padding: 4.5vw;
        border-radius: 3.5vw;
        margin-bottom: 6vw;
    }

    .payment_bank h4 {
        font-size: 3.5vw;
        margin-bottom: 2vw;
    }

    .box_copy {
        font-size: 3.5vw;
        padding: 2.5vw 3.5vw;
        border-radius: 2.5vw;
    }

    .box_copy span {
        font-size: 2.5vw;
        padding: 0.5vw 2.5vw;
    }

    .bank_name {
        font-size: 3vw;
        margin-top: 3vw;
    }

    .file_hint {
        font-size: 2.8vw;
        margin-top: 3vw;
    }

    .file_preview {
        padding: 1.5vw 2vw;
        border-radius: 1.5vw;
    }

    .file_name {
        font-size: 2vw;
    }

    .form_info {
        padding: 2vw;
        border-radius: 1.5vw;
        gap: 1.5vw;
    }

    .form_info p {
        font-size: 3vw;
    }

    .form_submit {
        flex-direction: column;
        gap: 2vw;
        padding-top: 3vw;
        margin-top: 3vw;
    }

    .form_submit_text {
        font-size: 2.8vw;
    }

    .btn_submit {
        font-size: 3.5vw;
        padding: 2.5vw 5vw;
        border-radius: 2.5vw;
        width: 100%;
        justify-content: center;
    }

    .pendaftaran_questions {
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

    .alert_success,
    .alert_error {
        padding: 2.5vw 3vw;
        border-radius: 2.5vw;
        font-size: 3.5vw;
        gap: 1.5vw;
    }

    .alert_link {
        font-size: 2vw;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .pendaftaran_layout {
        padding: 2vw 5vw 4vw 5vw;
    }

    .form_grid {
        gap: 1.5vw;
    }

    .section_title {
        font-size: 1.5vw;
    }

    .form_label {
        font-size: 1.1vw;
    }

    .form_input {
        font-size: 1.1vw;
        padding: 0.8vw 1.2vw;
    }
}
</style>

{{-- Pendaftaran Layout --}}
<div class="pendaftaran_layout">
    <img src="{{ asset('images/visi-misi-left.svg') }}" alt="" class="visi_misi_left hidden_top_header">
    <img src="{{ asset('images/visi-misi-right.svg') }}" alt="" class="visi_misi_right hidden_top_header">

    {{-- Header --}}
    <div class="pendaftaran_header">
        <h1>Formulir Pendaftaran</h1>
        <p>Isi data dengan lengkap dan benar untuk mendaftar program LPK SHIROKUMA Indonesia.</p>
    </div>

    {{-- Flash Notification --}}
    @if(session('success'))
    <div class="alert_success">
        <iconify-icon icon="mdi:check-circle" width="20" height="20"></iconify-icon>
        <div>
            <span>{{ session('success') }}</span>
            <br/>
            <a href="{{ route('download.formulir') }}" target="_blank" class="alert_link">
                <iconify-icon icon="mdi:download" width="14" height="14"></iconify-icon>
                Klik disini untuk mendownload Formulir
            </a>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="alert_error">
        <iconify-icon icon="mdi:alert-circle" width="20" height="20"></iconify-icon>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="alert_error">
        <div style="display:flex; align-items:center; gap:0.5vw; margin-bottom:0.5vw;">
            <iconify-icon icon="mdi:alert" width="20" height="20"></iconify-icon>
            <span class="font-semibold">Terdapat {{ $errors->count() }} kesalahan:</span>
        </div>
        <ul style="padding-left:2vw; list-style:disc; font-size:0.85vw;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Main Form --}}
    <div class="pendaftaran_card">
        <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data" id="registrationForm">
            @csrf

            <div class="form_section">
                <h3 class="section_title">
                    <iconify-icon icon="mdi:account" width="20" height="20"></iconify-icon>
                    Data Pribadi
                </h3>
                
                <div class="form_grid">
                    <!-- Nama Lengkap -->
                    <div class="form_group_full">
                        <label class="form_label">Nama Lengkap <span class="text_required">*</span></label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                               class="form_input" placeholder="Masukkan nama lengkap">
                    </div>

                    <!-- Program -->
                    <div class="form_group">
                        <label class="form_label">Program <span class="text_required">*</span></label>
                        <select name="program" required class="form_input">
                            <option value="">Pilih Program</option>
                            <option value="Magang (Ginoujisshusei)" {{ old('program') == 'Magang (Ginoujisshusei)' ? 'selected' : '' }}>Magang (Ginoujisshusei)</option>
                            <option value="Kerja (Tokutei Ginou)" {{ old('program') == 'Kerja (Tokutei Ginou)' ? 'selected' : '' }}>Kerja (Tokutei Ginou)</option>
                            <option value="Tenaga Ahli (Engineering)" {{ old('program') == 'Tenaga Ahli (Engineering)' ? 'selected' : '' }}>Tenaga Ahli (Engineering)</option>
                            <option value="Sekolah (Nihongo Gakkou)" {{ old('program') == 'Sekolah (Nihongo Gakkou)' ? 'selected' : '' }}>Sekolah (Nihongo Gakkou)</option>
                            <option value="Perawat (Kaigo)" {{ old('program') == 'Perawat (Kaigo)' ? 'selected' : '' }}>Perawat (Kaigo)</option>
                        </select>
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="form_group">
                        <label class="form_label">Tempat Lahir <span class="text_required">*</span></label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                               class="form_input" placeholder="Contoh: Jakarta">
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="form_group">
                        <label class="form_label">Tanggal Lahir <span class="text_required">*</span></label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                               class="form_input">
                    </div>

                    <!-- No HP -->
                    <div class="form_group">
                        <label class="form_label">No HP <span class="text_required">*</span></label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                               class="form_input" placeholder="081234567890">
                    </div>

                    <!-- Jurusan -->
                    <div class="form_group">
                        <label class="form_label">Jurusan <span class="text_required">*</span></label>
                        <input type="text" name="jurusan" value="{{ old('jurusan') }}" required
                               class="form_input" placeholder="Contoh: Teknik Komputer">
                    </div>
                </div>
            </div>

            {{-- Pendidikan --}}
            <div class="form_section">
                <h3 class="section_title">
                    <iconify-icon icon="mdi:school" width="20" height="20"></iconify-icon>
                    Pendidikan
                </h3>
                
                <div class="form_grid">
                    <div class="form_group">
                        <label class="form_label">Pendidikan Terakhir <span class="text_required">*</span></label>
                        <div class="radio_group">
                            <label class="radio_option">
                                <input type="radio" name="pendidikan_terakhir" value="SMK/SMA" {{ old('pendidikan_terakhir') == 'SMK/SMA' ? 'checked' : '' }} required>
                                <span>SMK/SMA</span>
                            </label>
                            <label class="radio_option">
                                <input type="radio" name="pendidikan_terakhir" value="D3" {{ old('pendidikan_terakhir') == 'D3' ? 'checked' : '' }}>
                                <span>D3</span>
                            </label>
                            <label class="radio_option">
                                <input type="radio" name="pendidikan_terakhir" value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'checked' : '' }}>
                                <span>S1</span>
                            </label>
                        </div>
                    </div>

                    <div class="form_group">
                        <label class="form_label">Pengalaman Bahasa Jepang <span class="text_required">*</span></label>
                        <div class="radio_group">
                            <label class="radio_option">
                                <input type="radio" name="pernah_belajar_jepang" value="1" {{ old('pernah_belajar_jepang') == '1' ? 'checked' : '' }} required>
                                <span>Sudah Pernah</span>
                            </label>
                            <label class="radio_option">
                                <input type="radio" name="pernah_belajar_jepang" value="0" {{ old('pernah_belajar_jepang') == '0' ? 'checked' : '' }}>
                                <span>Tidak Pernah</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Alamat --}}
            <div class="form_section">
                <h3 class="section_title">
                    <iconify-icon icon="mdi:map-marker" width="20" height="20"></iconify-icon>
                    Alamat
                </h3>
                
                <div class="form_group_full">
                    <label class="form_label">Alamat Lengkap <span class="text_required">*</span></label>
                    <textarea name="alamat" rows="3" required
                              class="form_input form_textarea" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                </div>
            </div>

            {{-- Data Fisik --}}
            <div class="form_section">
                <h3 class="section_title">
                    <iconify-icon icon="mdi:human" width="20" height="20"></iconify-icon>
                    Data Fisik
                </h3>
                
                <div class="form_grid">
                    <div class="form_group">
                        <label class="form_label">Tinggi Badan (cm)</label>
                        <input type="number" name="tinggi_badan" value="{{ old('tinggi_badan') }}"
                               class="form_input" placeholder="Contoh: 170" required>
                    </div>
                    
                    <div class="form_group">
                        <label class="form_label">Berat Badan (kg)</label>
                        <input type="number" name="berat_badan" value="{{ old('berat_badan') }}"
                               class="form_input" placeholder="Contoh: 65" required>
                    </div>
                </div>
            </div>

            {{-- Pembayaran --}}
            <div class="form_section form_section_payment">
                <h3 class="section_title">
                    <iconify-icon icon="mdi:cash" width="20" height="20"></iconify-icon>
                    Informasi Pembayaran
                </h3>
                
                <p class="payment_text">
                    Untuk mengirim pendaftaran dan mendownload formulir, silakan lakukan deposit sebesar:
                </p>
                
                <div class="payment_amount">Rp 50.000</div>
                
                <div class="payment_bank">
                    <h4>Bank BCA</h4>
                    <div class="box_copy" onclick="copyNumber('0542483111')" id="copyBox">
                        0542483111
                        <span id="copyText">Copy</span>
                    </div>
                    <p class="bank_name">a.n ALIFA K S</p>
                </div>
                
                <div class="form_group_full">
                    <label class="form_label">Upload Bukti Pembayaran <span class="text_required">*</span></label>
                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" required accept="image/*,.pdf"
                           class="form_input_file">
                    <p class="file_hint">Format: JPG, PNG, PDF. Maksimal 2MB</p>
                    <div id="file-preview" class="file_preview hidden">
                        <iconify-icon icon="mdi:check-circle" width="18" height="18"></iconify-icon>
                        <span id="file-name" class="file_name"></span>
                    </div>
                </div>
            </div>

            {{-- Info --}}
            <div class="form_info">
                <iconify-icon icon="mdi:information" width="16" height="16"></iconify-icon>
                <p>Field dengan tanda <span class="text_required">*</span> wajib diisi. Pastikan data yang dimasukkan sesuai dengan dokumen resmi.</p>
            </div>

            {{-- Submit --}}
            <div class="form_submit">
                <p class="form_submit_text">
                    <iconify-icon icon="mdi:information" width="14" height="14"></iconify-icon>
                    Data akan diproses setelah bukti pembayaran diverifikasi
                </p>
                <button type="submit" id="submitBtn" class="btn_submit">
                    <iconify-icon icon="mdi:send" width="18" height="18"></iconify-icon>
                    <span>Kirim Pendaftaran</span>
                </button>
            </div>
        </form>
    </div>
</div>
<div class="divider"></div>
<div class="cta_program">
    <h3>Ingin bertemu? Jadwalkan Pertemuan!</h3>
    <a href="/pertemuan">
        <button>Jadwalkan Pertemuan</button>
    </a>
</div>

<script>
// ============================================
// COPY NUMBER
// ============================================
function copyNumber(number) {
    navigator.clipboard.writeText(number).then(() => {
        const copyBox = document.getElementById('copyBox');
        const copyText = document.getElementById('copyText');
        
        copyBox.classList.add('copied');
        copyText.textContent = 'Tersalin!';
        
        setTimeout(() => {
            copyBox.classList.remove('copied');
            copyText.textContent = 'Copy';
        }, 2000);
    }).catch(() => {
        alert('Gagal menyalin nomor');
    });
}

// ============================================
// FILE UPLOAD PREVIEW
// ============================================
document.getElementById('bukti_pembayaran')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    
    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2MB');
            this.value = '';
            preview.classList.add('hidden');
            return;
        }
        
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
        if (!allowedTypes.includes(file.type)) {
            alert('Tipe file harus JPG, PNG, atau PDF');
            this.value = '';
            preview.classList.add('hidden');
            return;
        }
        
        fileName.textContent = file.name;
        preview.classList.remove('hidden');
    } else {
        preview.classList.add('hidden');
    }
});

// ============================================
// FORM VALIDATION
// ============================================
document.getElementById('registrationForm')?.addEventListener('submit', function(e) {
    const fileInput = document.getElementById('bukti_pembayaran');
    
    if (!fileInput.files || fileInput.files.length === 0) {
        e.preventDefault();
        alert('Anda harus mengupload bukti pembayaran terlebih dahulu!');
        return;
    }
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <iconify-icon icon="mdi:loading" width="18" height="18" class="animate-spin"></iconify-icon>
        <span>Memproses...</span>
    `;
});

// ============================================
// AUTO REDIRECT AFTER SUCCESS
// ============================================
@if(session('success'))
    setTimeout(function() {
        window.location.href = '{{ route("download.formulir") }}';
    }, 3000);
@endif
</script>

@endsection