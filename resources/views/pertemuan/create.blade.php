@extends('layouts_front.app')

@section('content_front')

<style>
/* ============================================
   PERTEMUAN LAYOUT
   ============================================ */
.pertemuan_layout {
    width: 100%;
    padding: 4vw 23vw 4vw 23vw;
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
.pertemuan_header {
    text-align: center;
    margin-bottom: 2.5vw;
}

.pertemuan_header h1 {
    font-size: 3.2vw;
    font-family: techna, sans-serif;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 0.5vw;
}

.pertemuan_header p {
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
    align-items: center;
    gap: 0.8vw;
    background: rgba(34, 197, 94, 0.12);
    border: 1px solid rgba(34, 197, 94, 0.25);
    color: #4ade80;
    padding: 1vw 1.5vw;
    border-radius: 0.6vw;
    margin-bottom: 1.5vw;
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

/* ============================================
   TOGGLE NAVIGATION
   ============================================ */
.toggle_navigation {
    display: flex;
    justify-content: center;
    margin-bottom: 2vw;
}

.toggle_nav_inner {
    display: flex;
    align-items: center;
    gap: 1.2vw;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    padding: 0.6vw 1.5vw;
    border-radius: 2vw;
    border: 0.1vw solid rgba(255, 255, 255, 0.08);
}

.toggle_label {
    display: flex;
    align-items: center;
    gap: 0.4vw;
    font-size: 0.85vw;
    color: #94a3b8;
    transition: color 0.3s ease;
}

.toggle_label.active {
    color: #D2B780;
}

.toggle_switch {
    position: relative;
    width: 3.5vw;
    height: 1.8vw;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 2vw;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 0.08vw solid rgba(255, 255, 255, 0.1);
}

.toggle_switch .toggle_handle {
    position: absolute;
    top: 0.15vw;
    left: 0.15vw;
    width: 1.4vw;
    height: 1.4vw;
    background: #94a3b8;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.toggle_switch.active {
    background: rgba(183, 144, 78, 0.3);
    border-color: #B7904E;
}

.toggle_switch.active .toggle_handle {
    left: 1.8vw;
    background: #D2B780;
}

/* ============================================
   CARD
   ============================================ */
.pertemuan_card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 1vw;
    border: 0.1vw solid rgba(255, 255, 255, 0.08);
    padding: 2vw;
    margin-bottom: 2.5vw;
    transition: all 0.3s ease;
}

.pertemuan_card:hover {
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

.form_textarea {
    min-height: 6vw;
    resize: vertical;
}

/* ============================================
   SELECT
   ============================================ */
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
    justify-content: flex-end;
    gap: 1vw;
    margin-top: 1.5vw;
    padding-top: 1.5vw;
    border-top: 0.1vw solid rgba(255, 255, 255, 0.05);
    flex-wrap: wrap;
}

.btn_reset {
    display: inline-flex;
    align-items: center;
    gap: 0.4vw;
    background: rgba(255, 255, 255, 0.05);
    color: #94a3b8;
    padding: 0.6vw 1.5vw;
    border-radius: 0.6vw;
    font-size: 0.85vw;
    font-weight: 500;
    border: 0.1vw solid rgba(255, 255, 255, 0.08);
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn_reset:hover {
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(255, 255, 255, 0.15);
}

.btn_submit {
    display: inline-flex;
    align-items: center;
    gap: 0.5vw;
    background: linear-gradient(90deg, #B7904E 26.92%, #D2B780 48.56%, #B7904E 71.63%);
    color: #ffffff;
    padding: 0.6vw 2vw;
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
.pertemuan_questions {
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
    .pertemuan_layout {
        padding: 9vw 4vw 9vw 4vw;
    }

    .pertemuan_header h1 {
        font-size: 7vw;
        margin-bottom: 1.5vw;
    }

    .pertemuan_header p {
        font-size: 3.4vw;
        max-width: 85vw;
    }

    .pertemuan_card {
        padding: 5vw;
        border-radius: 4.5vw;
    }

        .form_grid {
        grid-template-columns: 1fr;
        gap: 4.5vw;
    }

    .form_section {
        margin-bottom: 4vw;
        padding-bottom: 4vw;
    }

    .section_title {
        font-size: 4vw;
        gap: 2.5vw;
        margin-bottom: 3vw;
    }

    .form_label {
        font-size: 3.5vw;
    }

        .form_input {
        font-size: 3.5vw;
        padding: 2.5vw 3.5vw;
        border-radius: 2.5vw;
        border-width: 0.15vw;
        margin-top: 2vw;
    }

    .form_textarea {
        min-height: 12vw;
    }

    select.form_input {
        background-position: right 2.5vw center;
        background-size: 2.5vw;
        padding-right: 5vw;
    }
    .toggle_navigation {
        display: flex;
        justify-content: center;
        margin-bottom: 6vw;
    }

    .toggle_nav_inner {
        padding: 1.5vw 3vw;
        border-radius: 4vw;
        gap: 2.5vw;
    }

    .toggle_label {
        font-size: 3.5vw;
        gap: 0.8vw;
    }

    .toggle_switch {
        width: 10vw;
        height: 5vw;
        border-radius: 4vw;
    }

    .toggle_switch .toggle_handle {
        width: 4vw;
        height: 4vw;
        top: 0.4vw;
        left: 0.4vw;
    }

    .toggle_switch.active .toggle_handle {
        left: 5.2vw;
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

        .btn_reset, .btn_submit {
        font-size: 3.5vw;
        padding: 3.5vw 4vw;
        border-radius: 2.5vw;
        justify-content: center;
        width: 100%;
    }

    .pertemuan_questions {
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

    .alert_success, .alert_error {
        padding: 2.5vw 3vw;
        border-radius: 1.5vw;
        font-size: 3vw;
        gap: 1.5vw;
        margin-bottom: 5vw;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .pertemuan_layout {
        padding: 9vw 4vw 9vw 4vw;
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

{{-- Pertemuan Layout --}}
<div class="pertemuan_layout">
    <img src="{{ asset('images/visi-misi-left.svg') }}" alt="" class="visi_misi_left hidden_top_header">
    <img src="{{ asset('images/visi-misi-right.svg') }}" alt="" class="visi_misi_right hidden_top_header">

    {{-- Header --}}
    <div class="pertemuan_header">
        <h1>Form Pertemuan</h1>
        <p>Isi data untuk menjadwalkan pertemuan dan konsultasi dengan tim LPK SHIROKUMA Indonesia.</p>
    </div>

    {{-- Flash Notification --}}
    @if(session('success'))
    <div class="alert_success">
        <iconify-icon icon="mdi:check-circle" width="20" height="20"></iconify-icon>
        <span>{{ session('success') }}</span>
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

    {{-- Toggle Navigation --}}
    <div class="toggle_navigation">
        <div class="toggle_nav_inner">
            <span class="toggle_label {{ !request()->routeIs('pertemuan.create') ? 'active' : '' }}">
                <iconify-icon icon="mdi:clipboard-text" width="16" height="16"></iconify-icon>
                Daftar Online
            </span>
            
            <div class="toggle_switch {{ request()->routeIs('pertemuan.create') ? 'active' : '' }}" 
                 onclick="togglePage()" id="pageToggle">
                <div class="toggle_handle"></div>
            </div>
            
            <span class="toggle_label {{ request()->routeIs('pertemuan.create') ? 'active' : '' }}">
                <iconify-icon icon="mdi:calendar-check" width="16" height="16"></iconify-icon>
                Daftar Offline
            </span>
        </div>
    </div>

    {{-- Main Form --}}
    <div class="pertemuan_card">
        <form action="{{ route('pertemuan.store') }}" method="POST" id="pertemuanForm">
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

                    <!-- No HP -->
                    <div class="form_group">
                        <label class="form_label">No HP <span class="text_required">*</span></label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                               class="form_input" placeholder="081234567890">
                    </div>

                    <!-- Email -->
                    <div class="form_group">
                        <label class="form_label">Email <span class="text_required">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="form_input" placeholder="email@example.com">
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
                    <textarea name="alamat_lengkap" rows="4" required
                              class="form_input form_textarea" placeholder="Masukkan alamat lengkap untuk pertemuan">{{ old('alamat_lengkap') }}</textarea>
                </div>
            </div>

            {{-- Catatan --}}
            <div class="form_section">
                <h3 class="section_title">
                    <iconify-icon icon="mdi:note-text" width="20" height="20"></iconify-icon>
                    Catatan
                </h3>
                
                <div class="form_group_full">
                    <label class="form_label">Catatan Tambahan</label>
                    <textarea name="catatan" rows="3" class="form_input form_textarea" 
                              placeholder="Tuliskan catatan atau pertanyaan yang ingin disampaikan">{{ old('catatan') }}</textarea>
                </div>
            </div>

            {{-- Info --}}
            <div class="form_info">
                <iconify-icon icon="mdi:information" width="16" height="16"></iconify-icon>
                <p>Field dengan tanda <span class="text_required">*</span> wajib diisi. Data Anda akan digunakan untuk keperluan pertemuan dan konsultasi.</p>
            </div>

            {{-- Submit --}}
            <div class="form_submit">
                <button type="reset" class="btn_reset">
                    <iconify-icon icon="mdi:refresh" width="18" height="18"></iconify-icon>
                    Reset
                </button>
                <button type="submit" id="submitBtn" class="btn_submit">
                    <iconify-icon icon="mdi:calendar-check" width="18" height="18"></iconify-icon>
                    <span>Simpan Pertemuan</span>
                </button>
            </div>
        </form>
    </div>

</div>
<div class="divider"></div>
<div class="cta_program">
    <h3>Daftar Sekarang dan Mulai Karirmu!</h3>
    <a href="/daftar">
        <button>Daftar Sekarang</button>
    </a>
</div>

<script>
// ============================================
// TOGGLE PAGE
// ============================================
function togglePage() {
    const toggle = document.getElementById('pageToggle');
    const isPertemuan = toggle.classList.contains('active');
    
    toggle.style.transform = 'scale(0.95)';
    
    setTimeout(() => {
        if (isPertemuan) {
            window.location.href = '{{ route("pendaftaran.create") }}';
        } else {
            window.location.href = '{{ route("pertemuan.create") }}';
        }
    }, 300);
}

// ============================================
// FORM VALIDATION
// ============================================
document.getElementById('pertemuanForm')?.addEventListener('submit', function(e) {
    const nama = document.querySelector('input[name="nama_lengkap"]');
    const program = document.querySelector('select[name="program"]');
    const noHp = document.querySelector('input[name="no_hp"]');
    const email = document.querySelector('input[name="email"]');
    const alamat = document.querySelector('textarea[name="alamat_lengkap"]');
    
    if (!nama.value.trim()) {
        e.preventDefault();
        alert('Nama lengkap harus diisi');
        nama.focus();
        return;
    }
    
    if (!program.value) {
        e.preventDefault();
        alert('Program harus dipilih');
        program.focus();
        return;
    }
    
    if (!noHp.value.trim()) {
        e.preventDefault();
        alert('No HP harus diisi');
        noHp.focus();
        return;
    }
    
    if (!email.value.trim()) {
        e.preventDefault();
        alert('Email harus diisi');
        email.focus();
        return;
    }
    
    if (!alamat.value.trim()) {
        e.preventDefault();
        alert('Alamat harus diisi');
        alamat.focus();
        return;
    }
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <iconify-icon icon="mdi:loading" width="18" height="18" class="animate-spin"></iconify-icon>
        <span>Menyimpan...</span>
    `;
});
</script>
@endsection