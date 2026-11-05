@extends('layouts_front.app')

@section('content_front')

<style>
/* ============================================
   REGISTER LAYOUT
   ============================================ */
.register_layout {
    width: 100%;
    padding: 3vw 8vw 4vw 8vw;
    background: url(../images/blue-bg.png), linear-gradient(90deg, #01102D 0%, #294966 48.56%, #08203E 100%);
    background-blend-mode: multiply;
    background-size: contain;
    background-position: center;
    min-height: 70vh;
    position: relative;
    overflow-x: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* ============================================
   REGISTER CARD
   ============================================ */
.register_card {
    width: 100%;
    max-width: 520px;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 1.2vw;
    border: 0.1vw solid rgba(255, 255, 255, 0.08);
    padding: 2.5vw;
    transition: all 0.3s ease;
    max-height: 80vh;
    overflow-y: auto;
}

.register_card::-webkit-scrollbar {
    width: 4px;
}

.register_card::-webkit-scrollbar-track {
    background: transparent;
}

.register_card::-webkit-scrollbar-thumb {
    background: rgba(183, 144, 78, 0.3);
    border-radius: 2vw;
}

.register_card:hover {
    border-color: rgba(183, 144, 78, 0.3);
    box-shadow: 0 0.8vw 2vw rgba(183, 144, 78, 0.05);
}

/* ============================================
   REGISTER HEADER
   ============================================ */
.register_header {
    display: flex;
    align-items: center;
    gap: 0.8vw;
    margin-bottom: 1.8vw;
    padding-bottom: 1.2vw;
    border-bottom: 0.1vw solid rgba(255, 255, 255, 0.06);
}

.register_icon {
    width: 3.5vw;
    height: 3.5vw;
    background: rgba(183, 144, 78, 0.12);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.register_icon iconify-icon {
    color: #D2B780;
}

.register_header h2 {
    font-size: 1.4vw;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
}

.register_header p {
    font-size: 0.8vw;
    color: #94a3b8;
    margin: 0;
}

/* ============================================
   ALERT
   ============================================ */
.alert_success {
    display: flex;
    align-items: center;
    gap: 0.6vw;
    background: rgba(34, 197, 94, 0.1);
    border: 0.1vw solid rgba(34, 197, 94, 0.15);
    color: #4ade80;
    padding: 0.8vw 1.2vw;
    border-radius: 0.6vw;
    margin-bottom: 1.2vw;
    font-size: 0.85vw;
}

.alert_error {
    background: rgba(239, 68, 68, 0.08);
    border: 0.1vw solid rgba(239, 68, 68, 0.15);
    color: #f87171;
    padding: 0.8vw 1.2vw;
    border-radius: 0.6vw;
    margin-bottom: 1.2vw;
    font-size: 0.85vw;
}

.alert_error .alert_error_header {
    display: flex;
    align-items: center;
    gap: 0.5vw;
    margin-bottom: 0.3vw;
}

.alert_error .alert_error_list {
    padding-left: 2vw;
    margin: 0;
    font-size: 0.8vw;
    list-style: disc;
}

.alert_error .alert_error_list li {
    margin-bottom: 0.1vw;
}

/* ============================================
   FORM
   ============================================ */
.register_form {
    display: flex;
    flex-direction: column;
    gap: 1.2vw;
}

.form_section {
    display: flex;
    flex-direction: column;
    gap: 0.8vw;
    padding-bottom: 1.2vw;
    border-bottom: 0.1vw solid rgba(255, 255, 255, 0.04);
}

.form_section:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.section_title {
    display: flex;
    align-items: center;
    gap: 0.5vw;
    font-size: 0.95vw;
    font-weight: 600;
    color: #ffffff;
    margin-bottom: 0.2vw;
}

.section_title iconify-icon {
    color: #D2B780;
}

/* ============================================
   FORM GROUP - STACKED
   ============================================ */
.form_group {
    display: flex;
    flex-direction: column;
    gap: 0.3vw;
}

.form_label {
    display: flex;
    align-items: center;
    gap: 0.3vw;
    font-size: 0.8vw;
    font-weight: 500;
    color: #e2e6eb;
}

.text_required {
    color: #f87171;
}

/* ============================================
   INPUT GROUP
   ============================================ */
.input_group {
    position: relative;
    display: flex;
    align-items: center;
}

.input_group .input_icon {
    position: absolute;
    left: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.8vw;
    height: 100%;
    pointer-events: none;
    z-index: 2;
}

.input_group .input_icon iconify-icon {
    color: #64748b;
    transition: color 0.3s ease;
}

.input_group:focus-within .input_icon iconify-icon {
    color: #D2B780;
}

.input_group .input_eye {
    position: absolute;
    right: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.8vw;
    height: 100%;
    background: transparent;
    border: none;
    color: #64748b;
    cursor: pointer;
    transition: color 0.3s ease;
    z-index: 2;
}

.input_group .input_eye:hover {
    color: #ffffff;
}

.input_group .input_eye iconify-icon {
    font-size: 1.2vw;
}

/* ============================================
   FORM INPUT
   ============================================ */
.form_input {
    width: 100%;
    background: rgba(255, 255, 255, 0.05);
    border: 0.1vw solid rgba(255, 255, 255, 0.1);
    border-radius: 0.6vw;
    padding: 0.7vw 1vw 0.7vw 2.8vw;
    color: #ffffff;
    font-size: 0.85vw;
    transition: all 0.3s ease;
}

.form_input:focus {
    outline: none;
    border-color: #B7904E;
    box-shadow: 0 0 0 0.15vw rgba(183, 144, 78, 0.15);
}

.form_input::placeholder {
    color: #64748b;
}

select.form_input {
    appearance: none;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'><polyline points='6 9 12 15 18 9'/></svg>");
    background-repeat: no-repeat;
    background-position: right 1vw center;
    background-size: 1vw;
    padding-right: 2.5vw;
}

select.form_input option {
    background: #1f2937;
    color: #ffffff;
}

select.form_input:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* ============================================
   PASSWORD STRENGTH
   ============================================ */
.password_strength {
    margin-top: 0.3vw;
    font-size: 0.7vw;
    color: #94a3b8;
}

.password_strength .strength_bars {
    display: flex;
    gap: 0.2vw;
    margin-top: 0.2vw;
}

.password_strength .strength_bar {
    flex: 1;
    height: 0.2vw;
    border-radius: 0.1vw;
    background: #374151;
}

.password_strength .strength_bar.active {
    background: #4ade80;
}

/* ============================================
   ALAMAT PREVIEW
   ============================================ */
.alamat_preview {
    background: rgba(183, 144, 78, 0.05);
    border: 0.1vw solid rgba(183, 144, 78, 0.1);
    border-radius: 0.5vw;
    padding: 0.8vw 1vw;
}

.alamat_preview p {
    font-size: 0.8vw;
    color: #c0cad8;
    margin: 0;
}

/* ============================================
   PHOTO UPLOAD
   ============================================ */
.photo_upload {
    display: flex;
    align-items: center;
    gap: 1.2vw;
}

.photo_preview {
    width: 5vw;
    height: 5vw;
    background: rgba(255, 255, 255, 0.05);
    border: 0.1vw solid rgba(255, 255, 255, 0.1);
    border-radius: 0.6vw;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
}

.photo_preview iconify-icon {
    color: #64748b;
}

.photo_preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.photo_upload_info {
    display: flex;
    flex-direction: column;
    gap: .6vw;
}

.photo_upload_btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4vw;
    background: rgba(183, 144, 78, 0.15);
    color: #D2B780;
    padding: 0.4vw 1.2vw;
    border-radius: 0.5vw;
    font-size: 0.8vw;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    width: fit-content;
}

.photo_upload_btn:hover {
    background: rgba(183, 144, 78, 0.25);
}

.photo_hint {
    font-size: 0.65vw;
    color: #94a3b8;
    margin: 0;
}

.photo_file_name {
    font-size: 0.65vw;
    color: #64748b;
    margin: 0;
}

.photo_error {
    color: #f87171;
    font-size: 0.65vw;
}

/* ============================================
   TERMS
   ============================================ */
.form_terms {
    display: flex;
    align-items: flex-start;
    gap: 0.5vw;
    padding-top: 0.5vw;
}

.terms_label {
    display: flex;
    align-items: flex-start;
    gap: 0.5vw;
    cursor: pointer;
    font-size: 0.8vw;
    color: #94a3b8;
}

.terms_checkbox {
    width: 1vw;
    height: 1vw;
    margin-top: 0.1vw;
    accent-color: #D2B780;
    cursor: pointer;
    flex-shrink: 0;
}

.terms_link {
    color: #D2B780;
    text-decoration: none;
    transition: color 0.3s ease;
}

.terms_link:hover {
    color: #B7904E;
    text-decoration: underline;
}

/* ============================================
   SUBMIT BUTTON
   ============================================ */
.btn_submit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.6vw;
    background: linear-gradient(90deg, #B7904E 26.92%, #D2B780 48.56%, #B7904E 71.63%);
    color: #ffffff;
    padding: 0.8vw 2vw;
    border-radius: 0.6vw;
    font-size: 0.9vw;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 0.3vw;
    width: 100%;
}

.btn_submit:hover {
    opacity: 0.9;
    transform: scale(1.01);
    box-shadow: 0 0.3vw 0.8vw rgba(183, 144, 78, 0.3);
}

.btn_submit:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

/* ============================================
   REGISTER FOOTER
   ============================================ */
.register_footer {
    text-align: center;
    margin-top: 1.2vw;
    padding-top: 1.2vw;
    border-top: 0.1vw solid rgba(255, 255, 255, 0.06);
    font-size: 0.8vw;
    color: #94a3b8;
}

.register_footer a {
    color: #D2B780;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.register_footer a:hover {
    color: #B7904E;
    text-decoration: underline;
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .register_layout {
        padding: 4vw 5vw 8vw 5vw;
        min-height: 60vh;
    }

    .register_card {
        padding: 5vw;
        border-radius: 2.5vw;
        max-width: 100%;
        max-height: 75vh;
    }

        .register_header {
        gap: 3vw;
        margin-bottom: 6vw;
        padding-bottom: 4.5vw;
    }

    .register_icon {
        width: 10vw;
        height: 10vw;
    }

    .register_icon iconify-icon {
        font-size: 5vw;
    }

    .register_header h2 {
        font-size: 4vw;
        margin-bottom:1.6vw;
    }

    .register_header p {
        font-size: 3.5vw;
    }

    .register_form {
        gap: 3vw;
    }

        .form_section {
        gap: 6vw;
        padding-bottom: 5vw;
    }

        .section_title {
        font-size: 4vw;
        gap: 2.5vw;
        margin-bottom: 2.5vw;
    }

        .form_label {
        font-size: 3.5vw;
        gap: 1.8vw;
    }

    .input_group .input_icon {
        width: 8vw;
    }

    .input_group .input_icon iconify-icon {
        font-size: 4vw;
    }

       .form_input {
        font-size: 3.5vw;
        padding: 2.8vw 2.5vw 3.8vw 4vw;
        border-radius: 1.5vw;
        border-width: 0.15vw;
        margin-top: 2vw;
    }

    .input_group .input_eye {
        width: 8vw;
    }

    .input_group .input_eye iconify-icon {
        font-size: 4vw;
    }

    select.form_input {
        background-position: right 2.5vw center;
        background-size: 2.5vw;
        padding-right: 5vw;
    }

    .alamat_preview {
        padding: 2vw;
        border-radius: 1.5vw;
    }

        .alamat_preview p {
        font-size: 3.5vw;
    }

    .photo_upload {
        flex-direction: column;
        align-items: flex-start;
        gap: 2vw;
    }
    .photo_upload_info {
    display: flex;
    flex-direction: column;
    gap: 2.2vw;
}

    .photo_preview {
        width: 14vw;
        height: 14vw;
    }

    .photo_upload_btn {
        font-size: 3.5vw;
        padding: 2.5vw 5vw;
        border-radius: 2vw;
    }

       .photo_hint, .photo_file_name, .photo_error {
        font-size: 3.5vw;
    }

    .form_terms {
        padding-top: 1vw;
    }

        .terms_label {
        font-size: 3.5vw;
        gap: 3vw;
    }

        .terms_checkbox {
        width: 4.5vw;
        height: 4.5vw;
    }

        .btn_submit {
        font-size: 4.4vw;
        padding: 2.8vw 5vw;
        border-radius: 2.5vw;
        gap: 1.5vw;
        margin-top: 3vw;
    }

    .register_footer {
        font-size: 3.5vw;
        margin-top: 6vw;
        padding-top: 6vw;
    }

    .alert_success,
    .alert_error {
        font-size: 3.5vw;
        padding: 2.5vw 3.5vw;
        border-radius: 2.5vw;
        gap: 1.5vw;
    }

    .alert_error .alert_error_list {
        font-size: 2.8vw;
        padding-left: 4vw;
    }

    .password_strength {
        font-size: 2.8vw;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .register_card {
        padding: 3vw;
    }

    .register_header h2 {
        font-size: 1.8vw;
    }

    .register_header p {
        font-size: 1vw;
    }

    .input_group .input_icon {
        width: 3.5vw;
    }

    .input_group .input_icon iconify-icon {
        font-size: 1.6vw;
    }

    .form_input {
        font-size: 1.1vw;
        padding: 0.8vw 1.2vw 0.8vw 3.8vw;
    }

    .input_group .input_eye {
        width: 3.5vw;
    }

    .input_group .input_eye iconify-icon {
        font-size: 1.6vw;
    }

    .btn_submit {
        font-size: 1.1vw;
        padding: 0.8vw 2.5vw;
    }
}
</style>

{{-- Register Layout --}}
<div class="register_layout">
    <img src="{{ asset('images/visi-misi-left.svg') }}" alt="" class="visi_misi_left hidden_top_header">
    <img src="{{ asset('images/visi-misi-right.svg') }}" alt="" class="visi_misi_right hidden_top_header">

    {{-- Register Card --}}
    <div class="register_card">
        {{-- Header --}}
        <div class="register_header">
            <div class="register_icon">
                <iconify-icon icon="mdi:account-plus" width="28" height="28"></iconify-icon>
            </div>
            <div>
                <h2>Form Pembuatan CV</h2>
                <p>Lengkapi data diri Anda dengan benar</p>
            </div>
        </div>

        {{-- Flash Notification --}}
        @if(session('success'))
        <div class="alert_success">
            <iconify-icon icon="mdi:check-circle" width="18" height="18"></iconify-icon>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="alert_error">
            <iconify-icon icon="mdi:alert-circle" width="18" height="18"></iconify-icon>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="alert_error">
            <div class="alert_error_header">
                <iconify-icon icon="mdi:alert" width="18" height="18"></iconify-icon>
                <span class="font-semibold">Terdapat {{ $errors->count() }} kesalahan:</span>
            </div>
            <ul class="alert_error_list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="register_form" id="registerForm">
            @csrf

            {{-- ============================================ --}}
            {{-- INFORMASI PRIBADI --}}
            {{-- ============================================ --}}
            <div class="form_section">
                <h3 class="section_title">
                    <iconify-icon icon="mdi:account" width="20" height="20"></iconify-icon>
                    Informasi Pribadi
                </h3>

                {{-- Nama Lengkap --}}
                <div class="form_group">
                    <label class="form_label">Nama Lengkap <span class="text_required">*</span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" 
                           placeholder="Masukkan nama lengkap"
                           class="form_input" required>
                </div>

                {{-- Nama Lengkap (Katakana) --}}
                <div class="form_group">
                    <label class="form_label">Nama Lengkap (Katakana) <span class="text_required">*</span></label>
                    <input type="text" name="nama_lengkap_katakana" value="{{ old('nama_lengkap_katakana') }}" 
                           placeholder="Masukkan nama lengkap dalam Katakana"
                           class="form_input" required>
                </div>

                {{-- Nama Panggilan --}}
                <div class="form_group">
                    <label class="form_label">Nama Panggilan</label>
                    <input type="text" name="nama_panggilan" value="{{ old('nama_panggilan') }}" 
                           placeholder="Contoh: Andi"
                           class="form_input">
                </div>

                {{-- Nama Panggilan (Katakana) --}}
                <div class="form_group">
                    <label class="form_label">Nama Panggilan (Katakana)</label>
                    <input type="text" name="nama_panggilan_katakana" value="{{ old('nama_panggilan_katakana') }}" 
                           placeholder="Contoh: アンディ"
                           class="form_input">
                </div>

                {{-- Email --}}
                <div class="form_group">
                    <label class="form_label">Email <span class="text_required">*</span></label>
                    <div class="input_group">
                        <span class="input_icon">
                            <iconify-icon icon="mdi:email-outline" width="18" height="18"></iconify-icon>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" 
                               placeholder="nama@email.com"
                               class="form_input" required>
                    </div>
                </div>

                {{-- No HP --}}
                <div class="form_group">
                    <label class="form_label">Nomor HP <span class="text_required">*</span></label>
                    <div class="input_group">
                        <span class="input_icon">
                            <iconify-icon icon="mdi:phone-outline" width="18" height="18"></iconify-icon>
                        </span>
                        <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" 
                               placeholder="Contoh: 081234567890"
                               class="form_input" required>
                    </div>
                </div>

                {{-- Password --}}
                <div class="form_group">
                    <label class="form_label">Password <span class="text_required">*</span></label>
                    <div class="input_group">
                        <span class="input_icon">
                            <iconify-icon icon="mdi:lock-outline" width="18" height="18"></iconify-icon>
                        </span>
                        <input type="password" name="password" id="password"
                               placeholder="Minimal 6 karakter"
                               class="form_input" required minlength="6">
                        <button type="button" onclick="togglePassword('password', 'password-icon')" 
                                class="input_eye">
                            <iconify-icon id="password-icon" icon="mdi:eye-outline" width="18" height="18"></iconify-icon>
                        </button>
                    </div>
                    <div id="password-strength" class="password_strength hidden">
                        <span>Kekuatan Password: <span id="strength-text"></span></span>
                        <div class="strength_bars">
                            <div id="strength-bar-1" class="strength_bar"></div>
                            <div id="strength-bar-2" class="strength_bar"></div>
                            <div id="strength-bar-3" class="strength_bar"></div>
                        </div>
                    </div>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="form_group">
                    <label class="form_label">Konfirmasi Password <span class="text_required">*</span></label>
                    <div class="input_group">
                        <span class="input_icon">
                            <iconify-icon icon="mdi:lock-outline" width="18" height="18"></iconify-icon>
                        </span>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               placeholder="Ulangi password"
                               class="form_input" required>
                        <button type="button" onclick="togglePassword('password_confirmation', 'confirm-icon')" 
                                class="input_eye">
                            <iconify-icon id="confirm-icon" icon="mdi:eye-outline" width="18" height="18"></iconify-icon>
                        </button>
                    </div>
                </div>
            </div>

            {{-- ============================================ --}}
            {{-- DATA DIRI --}}
            {{-- ============================================ --}}
            <div class="form_section">
                <h3 class="section_title">
                    <iconify-icon icon="mdi:card-account-details" width="20" height="20"></iconify-icon>
                    Data Diri
                </h3>

                {{-- Tempat Lahir --}}
                <div class="form_group">
                    <label class="form_label">Tempat Lahir <span class="text_required">*</span></label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" 
                           placeholder="Contoh: Jakarta"
                           class="form_input" required>
                </div>

                {{-- Tanggal Lahir --}}
                <div class="form_group">
                    <label class="form_label">Tanggal Lahir <span class="text_required">*</span></label>
                    <input type="text" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" 
                           placeholder="DD/MM/YYYY"
                           class="form_input flatpickr" required>
                </div>

                {{-- Jenis Kelamin --}}
                <div class="form_group">
                    <label class="form_label">Jenis Kelamin <span class="text_required">*</span></label>
                    <select name="jenis_kelamin" class="form_input" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                {{-- Agama --}}
                <div class="form_group">
                    <label class="form_label">Agama <span class="text_required">*</span></label>
                    <select name="agama" class="form_input" required>
                        <option value="">Pilih Agama</option>
                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                </div>
            </div>

            {{-- ============================================ --}}
            {{-- ALAMAT --}}
            {{-- ============================================ --}}
            <div class="form_section">
                <h3 class="section_title">
                    <iconify-icon icon="mdi:map-marker" width="20" height="20"></iconify-icon>
                    Alamat Lengkap <span class="text_required">*</span>
                </h3>

                {{-- Provinsi --}}
                <div class="form_group">
                    <label class="form_label">Provinsi <span class="text_required">*</span></label>
                    <select id="provinsi" class="form_input" required>
                        <option value="">Pilih Provinsi</option>
                    </select>
                </div>

                {{-- Kabupaten --}}
                <div class="form_group">
                    <label class="form_label">Kabupaten/Kota <span class="text_required">*</span></label>
                    <select id="kabupaten" class="form_input" disabled required>
                        <option value="">Pilih Kabupaten/Kota</option>
                    </select>
                </div>

                {{-- Kecamatan --}}
                <div class="form_group">
                    <label class="form_label">Kecamatan <span class="text_required">*</span></label>
                    <select id="kecamatan" class="form_input" disabled required>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                </div>

                {{-- Desa --}}
                <div class="form_group">
                    <label class="form_label">Desa/Kelurahan <span class="text_required">*</span></label>
                    <select id="desa" class="form_input" disabled required>
                        <option value="">Pilih Desa/Kelurahan</option>
                    </select>
                </div>

                {{-- Preview Alamat --}}
                <input type="hidden" name="alamat" id="alamat_lengkap" value="{{ old('alamat') }}">
                <div class="alamat_preview">
                    <p id="alamat_preview_text">
                        {{ old('alamat') ?: 'Pilih provinsi, kabupaten, kecamatan, dan desa' }}
                    </p>
                </div>
            </div>

            {{-- ============================================ --}}
            {{-- FOTO PROFIL --}}
            {{-- ============================================ --}}
            <div class="form_section">
                <h3 class="section_title">
                    <iconify-icon icon="mdi:camera" width="20" height="20"></iconify-icon>
                    Foto Profil
                </h3>

                <div class="photo_upload">
                    <div class="photo_preview" id="photoPreview">
                        <iconify-icon icon="mdi:camera-plus" width="32" height="32"></iconify-icon>
                    </div>
                    <div class="photo_upload_info">
                        <input type="file" name="foto" id="foto" accept="image/jpeg,image/png,image/jpg" class="hidden">
                        <label for="foto" class="photo_upload_btn">
                            <iconify-icon icon="mdi:cloud-upload" width="18" height="18"></iconify-icon>
                            Pilih Foto
                        </label>
                        <p class="photo_hint">Format: JPG, PNG. Maksimal 10MB</p>
                        <p id="file-name" class="photo_file_name">Tidak ada file dipilih</p>
                        <div id="foto-error" class="photo_error hidden"></div>
                    </div>
                </div>
            </div>

            {{-- ============================================ --}}
            {{-- TERMS & SUBMIT --}}
            {{-- ============================================ --}}
            <div class="form_terms">
                <label class="terms_label">
                    <input type="checkbox" name="terms" id="terms" class="terms_checkbox" required>
                    <span>
                        Saya menyetujui 
                        <a href="{{ route('syarat-ketentuan') }}" class="terms_link">Syarat & Ketentuan</a> 
                        dan 
                        <a href="{{ route('kebijakan-privasi') }}" class="terms_link">Kebijakan Privasi</a>
                    </span>
                </label>
            </div>

            {{-- Submit --}}
            <button type="submit" id="submitBtn" class="btn_submit">
                <iconify-icon icon="mdi:account-plus" width="18" height="18"></iconify-icon>
                <span>Daftar Sekarang</span>
            </button>
        </form>

        {{-- Login Link --}}
        <div class="register_footer">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
        </div>
    </div>
</div>
<div class="divider"></div>

<script>
// ============================================
// TOGGLE PASSWORD
// ============================================
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.setAttribute('icon', 'mdi:eye-off-outline');
    } else {
        input.type = 'password';
        icon.setAttribute('icon', 'mdi:eye-outline');
    }
}

// ============================================
// PASSWORD STRENGTH
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const strengthContainer = document.getElementById('password-strength');
    const strengthText = document.getElementById('strength-text');
    const bars = [
        document.getElementById('strength-bar-1'),
        document.getElementById('strength-bar-2'),
        document.getElementById('strength-bar-3')
    ];

    if (password) {
        password.addEventListener('input', function() {
            const value = this.value;
            
            if (value.length === 0) {
                strengthContainer.classList.add('hidden');
                return;
            }
            
            strengthContainer.classList.remove('hidden');
            
            let strength = 0;
            if (value.length >= 6) strength++;
            if (value.length >= 8) strength++;
            if (/[A-Z]/.test(value)) strength++;
            if (/[a-z]/.test(value)) strength++;
            if (/[0-9]/.test(value)) strength++;
            if (/[^A-Za-z0-9]/.test(value)) strength++;
            
            bars.forEach(bar => {
                bar.className = 'strength_bar';
            });
            
            if (strength <= 2) {
                strengthText.textContent = 'Lemah';
                strengthText.style.color = '#f87171';
                bars[0].classList.add('active');
                bars[0].style.background = '#f87171';
            } else if (strength <= 4) {
                strengthText.textContent = 'Sedang';
                strengthText.style.color = '#fbbf24';
                bars[0].classList.add('active');
                bars[1].classList.add('active');
                bars[0].style.background = '#fbbf24';
                bars[1].style.background = '#fbbf24';
            } else {
                strengthText.textContent = 'Kuat';
                strengthText.style.color = '#4ade80';
                bars[0].classList.add('active');
                bars[1].classList.add('active');
                bars[2].classList.add('active');
                bars[0].style.background = '#4ade80';
                bars[1].style.background = '#4ade80';
                bars[2].style.background = '#4ade80';
            }
        });
    }
});

// ============================================
// NO HP - HANYA ANGKA
// ============================================
document.getElementById('no_hp')?.addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '');
});

// ============================================
// FILE UPLOAD PREVIEW
// ============================================
document.getElementById('foto')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    const fileName = document.getElementById('file-name');
    const preview = document.getElementById('photoPreview');
    const errorContainer = document.getElementById('foto-error');
    
    if (file) {
        errorContainer.classList.add('hidden');
        errorContainer.textContent = '';
        
        if (file.size > 10 * 1024 * 1024) {
            errorContainer.textContent = 'Ukuran file maksimal 10MB';
            errorContainer.classList.remove('hidden');
            this.value = '';
            fileName.textContent = 'Tidak ada file dipilih';
            preview.innerHTML = '<iconify-icon icon="mdi:camera-plus" width="32" height="32"></iconify-icon>';
            return;
        }
        
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            errorContainer.textContent = 'Format file harus JPG atau PNG';
            errorContainer.classList.remove('hidden');
            this.value = '';
            fileName.textContent = 'Tidak ada file dipilih';
            preview.innerHTML = '<iconify-icon icon="mdi:camera-plus" width="32" height="32"></iconify-icon>';
            return;
        }
        
        fileName.textContent = file.name;
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(file);
    } else {
        fileName.textContent = 'Tidak ada file dipilih';
        preview.innerHTML = '<iconify-icon icon="mdi:camera-plus" width="32" height="32"></iconify-icon>';
    }
});

// ============================================
// WILAYAH API
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const provinsi = document.getElementById('provinsi');
    const kabupaten = document.getElementById('kabupaten');
    const kecamatan = document.getElementById('kecamatan');
    const desa = document.getElementById('desa');
    const alamatHidden = document.getElementById('alamat_lengkap');
    const alamatPreview = document.getElementById('alamat_preview_text');

    // Load Provinces
    fetch('/wilayah/provinces')
        .then(response => response.json())
        .then(data => {
            provinsi.innerHTML = '<option value="">Pilih Provinsi</option>';
            data.forEach(item => {
                provinsi.innerHTML += `<option value="${item.id}">${item.name}</option>`;
            });
        })
        .catch(() => {
            showError('Gagal memuat data provinsi');
        });

    // Province change
    provinsi.addEventListener('change', function() {
        const id = this.value;
        kabupaten.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
        kabupaten.disabled = true;
        kecamatan.innerHTML = '<option value="">Pilih Kecamatan</option>';
        kecamatan.disabled = true;
        desa.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
        desa.disabled = true;
        
        if (id) {
            fetch(`/wilayah/regencies/${id}`)
                .then(response => response.json())
                .then(data => {
                    kabupaten.disabled = false;
                    data.forEach(item => {
                        kabupaten.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                })
                .catch(() => showError('Gagal memuat data kabupaten'));
        }
        updateAlamat();
    });

    // Kabupaten change
    kabupaten.addEventListener('change', function() {
        const id = this.value;
        kecamatan.innerHTML = '<option value="">Pilih Kecamatan</option>';
        kecamatan.disabled = true;
        desa.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
        desa.disabled = true;
        
        if (id) {
            fetch(`/wilayah/districts/${id}`)
                .then(response => response.json())
                .then(data => {
                    kecamatan.disabled = false;
                    data.forEach(item => {
                        kecamatan.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                })
                .catch(() => showError('Gagal memuat data kecamatan'));
        }
        updateAlamat();
    });

    // Kecamatan change
    kecamatan.addEventListener('change', function() {
        const id = this.value;
        desa.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
        desa.disabled = true;
        
        if (id) {
            fetch(`/wilayah/villages/${id}`)
                .then(response => response.json())
                .then(data => {
                    desa.disabled = false;
                    data.forEach(item => {
                        desa.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    });
                })
                .catch(() => showError('Gagal memuat data desa'));
        }
        updateAlamat();
    });

    // Desa change
    desa.addEventListener('change', updateAlamat);

    function updateAlamat() {
        const prov = provinsi.options[provinsi.selectedIndex]?.text || '';
        const kab = kabupaten.options[kabupaten.selectedIndex]?.text || '';
        const kec = kecamatan.options[kecamatan.selectedIndex]?.text || '';
        const d = desa.options[desa.selectedIndex]?.text || '';

        const parts = [];
        if (d && d !== 'Pilih Desa/Kelurahan') parts.push(d.toUpperCase());
        if (kec && kec !== 'Pilih Kecamatan') parts.push('KEC. ' + kec.toUpperCase());
        if (kab && kab !== 'Pilih Kabupaten/Kota') parts.push(kab.toUpperCase());
        if (prov && prov !== 'Pilih Provinsi') parts.push(prov.toUpperCase());
        
        if (parts.length > 0) {
            parts.push('INDONESIA');
            const alamat = parts.join(', ');
            alamatHidden.value = alamat;
            alamatPreview.textContent = alamat;
        } else {
            alamatHidden.value = '';
            alamatPreview.textContent = 'Pilih provinsi, kabupaten, kecamatan, dan desa';
        }
    }
});

// ============================================
// SHOW ERROR
// ============================================
function showError(message) {
    const alert = document.createElement('div');
    alert.className = 'alert_error';
    alert.style.marginBottom = '1.2vw';
    alert.innerHTML = `
        <iconify-icon icon="mdi:alert-circle" width="18" height="18"></iconify-icon>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;color:#f87171;cursor:pointer;">
            <iconify-icon icon="mdi:close" width="16" height="16"></iconify-icon>
        </button>
    `;
    const form = document.querySelector('.register_form');
    if (form) {
        form.insertBefore(alert, form.firstChild);
    }
}

// ============================================
// FORM SUBMIT
// ============================================
document.getElementById('registerForm')?.addEventListener('submit', function(e) {
    const foto = document.getElementById('foto').files[0];
    const terms = document.getElementById('terms');
    const alamat = document.getElementById('alamat_lengkap').value;
    const submitBtn = document.getElementById('submitBtn');
    
    if (!terms.checked) {
        e.preventDefault();
        showError('Anda harus menyetujui Syarat & Ketentuan');
        terms.focus();
        return;
    }
    
    if (!alamat || alamat === 'Pilih provinsi, kabupaten, kecamatan, dan desa') {
        e.preventDefault();
        showError('Silakan pilih alamat lengkap terlebih dahulu');
        return;
    }
    
    if (foto) {
        if (foto.size > 10 * 1024 * 1024) {
            e.preventDefault();
            showError('Ukuran foto maksimal 10MB');
            return;
        }
        
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(foto.type)) {
            e.preventDefault();
            showError('Format foto harus JPG atau PNG');
            return;
        }
    }
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <iconify-icon icon="mdi:loading" width="18" height="18" class="animate-spin"></iconify-icon>
        <span>Mendaftar...</span>
    `;
});

// ============================================
// AUTO DISMISS ERROR
// ============================================
setTimeout(() => {
    document.querySelectorAll('.alert_error, .alert_success').forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s, transform 0.5s';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.style.display = 'none', 500);
        }, 5000);
    });
}, 100);
</script>
@endsection