@extends('layouts_front.app')

@section('content_front')

<style>
/* ============================================
   LOGIN LAYOUT
   ============================================ */
.login_layout {
    width: 100%;
    padding: 5vw 6vw 5vw 6vw;
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
   LOGIN CARD
   ============================================ */
.login_card {
    width: 100%;
    max-width: 500px;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 1.2vw;
    border: 0.1vw solid rgba(255, 255, 255, 0.08);
    padding: 2.5vw;
    transition: all 0.3s ease;
}

.login_card:hover {
    border-color: rgba(183, 144, 78, 0.3);
    box-shadow: 0 0.8vw 2vw rgba(183, 144, 78, 0.05);
}

/* ============================================
   LOGIN HEADER
   ============================================ */
.login_header {
    display: flex;
    align-items: center;
    gap: 0.8vw;
    margin-bottom: 1.8vw;
    padding-bottom: 1.2vw;
    border-bottom: 0.1vw solid rgba(255, 255, 255, 0.06);
}

.login_icon {
    width: 3.5vw;
    height: 3.5vw;
    background: rgba(183, 144, 78, 0.12);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.login_icon iconify-icon {
    color: #D2B780;
}

.login_header h2 {
    font-size: 1.4vw;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
}

.login_header p {
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
   FORM - PERBAIKI ICON POSITION
   ============================================ */
.login_form {
    display: flex;
    flex-direction: column;
    gap: 1.2vw;
}

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

.form_label iconify-icon {
    color: #D2B780;
}

/* 🔥 INPUT GROUP - PERBAIKI */
.input_group {
    position: relative;
    display: flex;
    align-items: center;
}

/* Icon kiri - email & lock */
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

/* 🔥 INPUT FIELD */
.form_input {
    width: 100%;
    background: rgba(255, 255, 255, 0.05);
    border: 0.1vw solid rgba(255, 255, 255, 0.1);
    border-radius: 0.6vw;
    padding: 0.7vw 1vw 0.7vw 2.8vw;
    color: #ffffff;
    font-size: 0.85vw;
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
}

.form_input:focus {
    outline: none;
    border-color: #B7904E;
    box-shadow: 0 0 0 0.15vw rgba(183, 144, 78, 0.15);
}

.form_input::placeholder {
    color: #64748b;
}

/* 🔥 EYE BUTTON - PERBAIKI POSISI */
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

/* 🔥 ERROR MESSAGE */
.form_error {
    display: flex;
    align-items: center;
    gap: 0.3vw;
    color: #f87171;
    font-size: 0.7vw;
    margin-top: 0.2vw;
}

/* ============================================
   FORM ACTIONS
   ============================================ */
.form_actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.8vw;
}

.checkbox_label {
    display: flex;
    align-items: center;
    gap: 0.4vw;
    cursor: pointer;
    color: #94a3b8;
    transition: color 0.3s ease;
}

.checkbox_label:hover {
    color: #ffffff;
}

.checkbox_input {
    width: 0.9vw;
    height: 0.9vw;
    background: rgba(255, 255, 255, 0.05);
    border: 0.1vw solid rgba(255, 255, 255, 0.15);
    border-radius: 0.2vw;
    accent-color: #D2B780;
    cursor: pointer;
}

.forgot_link {
    display: flex;
    align-items: center;
    gap: 0.3vw;
    color: #94a3b8;
    text-decoration: none;
    transition: color 0.3s ease;
}

.forgot_link:hover {
    color: #D2B780;
}

.forgot_link iconify-icon {
    color: #D2B780;
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
    padding: 0.7vw 2vw;
    border-radius: 0.6vw;
    font-size: 0.9vw;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 0.3vw;
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

.btn_submit .btn_icon {
    transition: transform 0.3s ease;
}

.btn_submit:hover .btn_icon {
    transform: translateX(0.2vw);
}

/* ============================================
   LOGIN FOOTER
   ============================================ */
.login_footer {
    text-align: center;
    margin-top: 1.2vw;
    padding-top: 1.2vw;
    border-top: 0.1vw solid rgba(255, 255, 255, 0.06);
    font-size: 0.8vw;
    color: #94a3b8;
}

.login_footer a {
    color: #D2B780;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.login_footer a:hover {
    color: #B7904E;
    text-decoration: underline;
}

/* ============================================
   RESPONSIVE - PERBAIKI ICON SIZE
   ============================================ */
@media (max-width: 768px) {
    .login_layout {
        padding: 4vw 5vw 8vw 5vw;
        min-height: 60vh;
    }

    .login_card {
        padding: 5vw;
        border-radius: 2.5vw;
        max-width: 100%;
    }

        .login_header {
        gap: 4vw;
        margin-bottom: 6vw;
        padding-bottom: 5.5vw;
    }

    .login_icon {
        width: 10vw;
        height: 10vw;
    }

    .login_icon iconify-icon {
        font-size: 5vw;
    }

    .login_header h2 {
        font-size: 5vw;
        margin-bottom: 1vw;
    }

        .login_header p {
        font-size: 3.5vw;
    }

    .login_form {
        gap: 3vw;
    }

        .form_label {
        font-size: 4vw;
        gap: 2.8vw;
    }

    /* 🔥 MOBILE - ICON POSITION */
    .input_group .input_icon {
        width: 8vw;
    }

    .input_group .input_icon iconify-icon {
        font-size: 4vw;
    }

        .form_input {
        font-size: 3.5vw;
        padding: 2.8vw 4.5vw 2.8vw 8vw;
        border-radius: 1.5vw;
        border-width: 0.15vw;
        margin-top: 2vw;
    }

    .input_group .input_eye {
        width: 8vw;
    }

    .input_group .input_eye iconify-icon {
        font-size: 11vw;
    }

    .form_error {
        font-size: 1.8vw;
    }

        .form_actions {
        font-size: 3.5vw;
        margin-top: 3vw;
    }

    .checkbox_input {
        width: 2.5vw;
        height: 2.5vw;
    }
    .checkbox_label {
    display: flex;
    align-items: center;
    gap: 2vw;
    cursor: pointer;
    color: #94a3b8;
    transition: color 0.3s ease;
}
.forgot_link {
    display: flex;
    align-items: center;
    gap: 1.3vw;
    color: #94a3b8;
    text-decoration: none;
    transition: color 0.3s ease;
}

        .btn_submit {
        font-size: 3.5vw;
        padding: 3.8vw 6vw;
        border-radius: 2.5vw;
        gap: 2.5vw;
    }

        .login_footer {
        font-size: 3.5vw;
        margin-top: 6vw;
        padding-top: 5vw;
    }

    .alert_success,
    .alert_error {
        font-size: 3.5vw;
        padding: 2.5vw 2.5vw;
        border-radius: 2.5vw;
        gap: 1.8vw;
    }

    .alert_error .alert_error_list {
        font-size: 1.8vw;
        padding-left: 4vw;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .login_card {
        padding: 3vw;
    }

    .login_header h2 {
        font-size: 1.8vw;
    }

    .login_header p {
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


{{-- Login Layout --}}
<div class="login_layout">
    <img src="{{ asset('images/visi-misi-left.svg') }}" alt="" class="visi_misi_left hidden_top_header">
    <img src="{{ asset('images/visi-misi-right.svg') }}" alt="" class="visi_misi_right hidden_top_header">

    {{-- Login Card --}}
    <div class="login_card">
        {{-- Header --}}
        <div class="login_header">
            <div class="login_icon">
                <iconify-icon icon="mdi:login" width="28" height="28"></iconify-icon>
            </div>
            <div>
                <h2>Selamat Datang</h2>
                <p>Silakan login untuk melanjutkan</p>
            </div>
        </div>

        {{-- Flash Notification --}}
        @if(session('error'))
        <div class="alert_error">
            <iconify-icon icon="mdi:alert-circle" width="18" height="18"></iconify-icon>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        @if(session('success'))
        <div class="alert_success">
            <iconify-icon icon="mdi:check-circle" width="18" height="18"></iconify-icon>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="alert_error">
            <div class="alert_error_header">
                <iconify-icon icon="mdi:alert" width="18" height="18"></iconify-icon>
                <span class="font-semibold">Terdapat kesalahan:</span>
            </div>
            <ul class="alert_error_list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}" class="login_form">
            @csrf

            {{-- Email Field --}}
            <div class="form_group">
                <label class="form_label">
                    <iconify-icon icon="mdi:email" width="14" height="14"></iconify-icon>
                    Alamat Email
                </label>
                <div class="input_group">
                    <span class="input_icon">
                        <iconify-icon icon="mdi:email-outline" width="18" height="18"></iconify-icon>
                    </span>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="nama@email.com" 
                           required
                           autofocus
                           class="form_input">
                </div>
                @error('email')
                    <p class="form_error">
                        <iconify-icon icon="mdi:alert-circle" width="12" height="12"></iconify-icon>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Password Field --}}
            <div class="form_group">
                <label class="form_label">
                    <iconify-icon icon="mdi:lock" width="14" height="14"></iconify-icon>
                    Password
                </label>
                <div class="input_group">
                    <span class="input_icon">
                        <iconify-icon icon="mdi:lock-outline" width="18" height="18"></iconify-icon>
                    </span>
                    <input type="password" 
                           name="password" 
                           id="password"
                           placeholder="••••••••" 
                           required
                           class="form_input">
                    <button type="button" 
                            onclick="togglePassword()" 
                            class="input_eye">
                        <iconify-icon id="password-icon" icon="mdi:eye-outline" width="18" height="18"></iconify-icon>
                    </button>
                </div>
                @error('password')
                    <p class="form_error">
                        <iconify-icon icon="mdi:alert-circle" width="12" height="12"></iconify-icon>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Remember Me & Forgot Password --}}
            <div class="form_actions">
                <label class="checkbox_label">
                    <input type="checkbox" name="remember" class="checkbox_input">
                    <span>Ingat saya</span>
                </label>
                <a href="#" class="forgot_link">
                    <iconify-icon icon="mdi:help-circle" width="14" height="14"></iconify-icon>
                    Lupa password?
                </a>
            </div>

            {{-- Submit Button --}}
            <button type="submit" id="submitBtn" class="btn_submit">
                <iconify-icon icon="mdi:login" width="18" height="18" class="btn_icon"></iconify-icon>
                <span>Masuk ke Aplikasi</span>
            </button>
        </form>

        {{-- Register Link --}}
        <div class="login_footer">
            <p>Belum punya akun? <a href="{{ route('register') }}">Buat CV Sekarang</a></p>
        </div>
    </div>
</div>
<div class="divider"></div>

<script>
// ============================================
// TOGGLE PASSWORD
// ============================================
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const passwordIcon = document.getElementById('password-icon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.setAttribute('icon', 'mdi:eye-off-outline');
    } else {
        passwordInput.type = 'password';
        passwordIcon.setAttribute('icon', 'mdi:eye-outline');
    }
}

// ============================================
// AUTO DISMISS ERROR NOTIFICATIONS
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const errorAlerts = document.querySelectorAll('.alert_error, .alert_success');
    errorAlerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 500);
        }, 5000);
    });
});

// ============================================
// LOADING STATE ON FORM SUBMIT
// ============================================
document.querySelector('.login_form')?.addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <iconify-icon icon="mdi:loading" width="18" height="18" class="animate-spin"></iconify-icon>
        <span>Memproses...</span>
    `;
    
    setTimeout(() => {
        if (submitBtn.disabled) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    }, 5000);
});
</script>
@endsection