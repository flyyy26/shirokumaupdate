@extends('layouts_front.app')

@section('content_front')

{{-- Banner --}}
<div class="banner_page" style="background-image:url(../images/contact_page.png) !important; background-position:bottom center !important; background-size:cover;">
    <img src="images/overlay_page.png" alt="">
</div>

{{-- Contact Layout --}}
<div class="contact_layout">
    <div class="gmaps_grid_layout">
        <div class="maps_box">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d464.411709387462!2d108.22036229891293!3d-7.360565457687157!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f570002188f4d%3A0xc19012cc5ef47e0d!2sLPK%20SHIROKUMA%20TASIKMALAYA!5e0!3m2!1sen!2sid!4v1786386146156!5m2!1sen!2sid" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="strict-origin-when-cross-origin">
            </iframe>
        </div>
        <div class="maps_box_camera">
            <iframe src="https://www.google.com/maps/embed?pb=!4v1786387246809!6m8!1m7!1sf-LrvrGqwTnT_Vx0EMyXHg!2m2!1d-7.360776242692399!2d108.2200367781659!3f2.4747979522579726!4f-11.775177724219972!5f0.7820865974627469" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
        </div>
    </div>

    {{-- Contact Form --}}
    <div class="contact_form_box">
        <h1>Kontak Kami</h1>
        <p class="contact_subtitle">Silakan kirim pesan kepada kami, kami akan merespon secepat mungkin.</p>
        
        {{-- 🔥 TAMPILKAN NOTIFIKASI --}}
        @if(session('success'))
        <div class="alert alert-success" style="background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.3); color: #4ade80; padding: 1vw 1.5vw; border-radius: 0.6vw; margin-bottom: 1.5vw; display: flex; align-items: center; gap: 0.8vw;">
            <iconify-icon icon="mdi:check-circle" width="24" height="24"></iconify-icon>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-error" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171; padding: 1vw 1.5vw; border-radius: 0.6vw; margin-bottom: 1.5vw; display: flex; align-items: flex-start; gap: 0.8vw; flex-direction: column;">
            <div style="display: flex; align-items: center; gap: 0.8vw;">
                <iconify-icon icon="mdi:alert-circle" width="24" height="24"></iconify-icon>
                <span>Terdapat kesalahan pada form:</span>
            </div>
            <ul style="margin: 0; padding-left: 2.5vw; color: #fca5a5; font-size: 0.85vw;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- 🔥 TAMBAHKAN ACTION FORM --}}
        <form action="{{ route('contact.store') }}" method="POST" id="contact-form">
            @csrf
            <div class="form_field">
                <label for="name">Nama Lengkap <span class="text-red-400">*</span></label>
                <input type="text" name="name" id="name" placeholder="Masukkan nama Anda" value="{{ old('name') }}" required>
                <span class="input-icon">👤</span>
                @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="form_field">
                <label for="phone">Nomor Whatsapp <span class="text-red-400">*</span></label>
                <input type="text" name="phone" id="phone" placeholder="Masukkan nomor Anda" value="{{ old('phone') }}" required>
                <span class="input-icon">📱</span>
                @error('phone') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="form_field">
                <label for="email">Email <span class="text-red-400">*</span></label>
                <input type="email" name="email" id="email" placeholder="Masukkan email Anda" value="{{ old('email') }}" required>
                <span class="input-icon">✉️</span>
                @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="form_field">
                <label for="message">Pesan <span class="text-red-400">*</span></label>
                <textarea name="message" id="message" placeholder="Masukkan pesan Anda" required>{{ old('message') }}</textarea>
                <span class="input-icon">💬</span>
                @error('message') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <button type="submit" class="btn_submit">
                <span>Kirim Pesan</span>
                <svg class="btn_icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                </svg>
            </button>
        </form>

        <div class="contact_info_wrapper">
            <div class="contact_address">
                <div class="address_icon">📍</div>
                <div>
                    <h4>LPK SHIROKUMA INDONESIA</h4>
                    <p>Perum Winayajaya Blok A.26, RT.002/RW.003 Kelurahan Sambongjaya, Kecamatan Mangkubumi Kota Tasikmalaya, Jawa Barat</p>
                </div>
            </div>

            <div class="contact_detail_layout">
                <div class="contact_detail">
                    <div class="detail_icon">📞</div>
                    <div>
                        <span class="detail_label">Telepon</span>
                        <p>+62851-2121-2200</p>
                    </div>
                </div>
                <div class="contact_detail">
                    <div class="detail_icon">✉️</div>
                    <div>
                        <span class="detail_label">Email</span>
                        <p>lpkshirokuma@gmail.com</p>
                    </div>
                </div>
            </div>

            <div class="social_links">
                <a href="https://www.instagram.com/lpk_so_shirokuma/" target="_blank" class="social_link" aria-label="Instagram">
                    <iconify-icon icon="mdi:instagram" class="social_icon"></iconify-icon>
                </a>
                <a href="https://www.facebook.com/p/LPK-Shirokuma-Indonesia-61583256083793/" target="_blank" class="social_link" aria-label="Facebook">
                    <iconify-icon icon="mdi:facebook" class="social_icon"></iconify-icon>
                </a>
                <a href="https://www.tiktok.com/@lpk_shirokuma" target="_blank" class="social_link" aria-label="TikTok">
                    <iconify-icon icon="ic:baseline-tiktok" class="social_icon"></iconify-icon>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="divider"></div>
<div class="cta_program">
    <h3>Daftar Sekarang dan Mulai Karirmu!</h3>
    <a href="/daftar">
        <button>Daftar Sekarang</button>
    </a>
</div>
@endsection