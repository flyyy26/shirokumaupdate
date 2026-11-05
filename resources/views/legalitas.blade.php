@extends('layouts_front.app')

@section('content_front')

<style>
    .legality_layout{
    width:100%;
    padding:4.8vw 10vw;
    padding-bottom:10vw;
    background-size: cover;
    background-position:center;
    position:relative;
    background: linear-gradient(180deg, rgba(182, 145, 82, 0) 0%, rgba(233, 207, 130, 0) 17.31%, rgba(182, 145, 82, 0) 42.31%, rgba(233, 207, 130, 0.13) 76.44%, rgba(182, 145, 82, 0.58) 100%);
}
.legalitas_card_layout{
    width:100%;
    display:grid;
    grid-gap:2vw;
    grid-template-columns:repeat(4, 1fr);
}
.legalitas_card_box img{
    width:100%;
    border: .12vw solid #01102D;
}
.container_legality{
    width:100%;
    padding:4vw 10vw;
    padding-bottom:2vw;
    background-image:url(../images/program_box_small.png);
    background-size:contain;
    background-position:contain;
    position:relative;
}
.legalitas_card_layout{
    margin-top:-15vw;
}
.img_akreditasi_layout{
    margin-bottom:-9vw;
    margin-top:1.8vw;
    width:100%; 
    display:flex;
    align-items:center;
    justify-content:center;
    gap:2vw;
}
.legalitas_bla_hidden_swap{
    display:flex;
}
.img_akreditasi img{
    width:24vw;
    display:block;
    margin:auto;
    border: .12vw solid #01102D;
}
.img_akreditasi_sc img{
    width:17vw;
}
.legalitas_bla_hidden{
    display:none;
}
.img_akreditasi_mobile{
    display:none;
}

.tahap_container{
    width:100%;
    padding:4vw 13vw;
    padding-top:8.5vw;
    background: url(../images/blue-bg.png), linear-gradient(90deg, #01102D 0%, #294966 48.56%, #08203E 100%);
    background-blend-mode: multiply;
    background-size: contain;
    background-position: center;
}
.tahap_layout{
    display:grid;
    align-items:start;
    justify-items:center;
    grid-template-columns: repeat(9, 1fr);
}
.tahap_box{
    text-align:center;
}
.tahap_box img{
    margin-bottom:.8vw;
    width:7vw;
}
.arrow_img {
    width:4vw;
    margin-top: 3vw;
}
.tahap_box p{
    color:white;
    font-size:.85vw;
}

@media (max-width:768px) {
    .legality_layout {
        padding: 9.8vw 10vw;
        padding-bottom: 14vw;
    }
    .legalitas_card_layout {
        width: 100%;
        display: grid;
        grid-gap: 3.8vw;
        grid-template-columns: repeat(2, 1fr);
    }
    .img_akreditasi_layout{
        margin-bottom: -23vw;
        margin-top: 3.8vw;
        display:grid;
        grid-template-columns: repeat(2, 1fr);
        gap:2vw;
    }
    .legalitas_bla_hidden_swap{
        display:none;
    }
    .img_akreditasi img {
        width: 80vw;
        margin-bottom: -23vw;
        margin-top: 3.8vw;
    }
    .legalitas_bla_hidden{
        display:block;
    }
    .img_akreditasi_mobile{
        display:block;
    }
    .tahap_container {
        padding: 14vw 12vw;
        padding-top: 27.5vw;
    }
    .tahap_layout {
        grid-template-columns: repeat(1, 1fr);
    }
    .tahap_box img {
        margin-bottom: 2.8vw;
        width: 29vw;
    }
    .tahap_box p {
        color: white;
        font-size: 3.5vw;
    }
    .arrow_img {
        width: 13vw;
        margin-top: 8vw;
        margin-bottom: 8vw;
        transform: rotate(90deg);
    }
}
</style>

<div class="banner_page" style="background-image:url(../images/legalitas_page.webp) !important; background-position:bottom center !important; background-size:cover;">
    <img src="images/overlay_page.png" alt="">
</div>

<div class="legality_layout">
    <div class="header_benefit_home">
        <h2>Legalitas LPK Shirokuma</h2>
        <p>LPK Shirokuma beroperasi dengan izin resmi dari pemerintah dan memenuhi semua persyaratan hukum. Kami menjamin bahwa program kami aman dan terpercaya.</p>
    </div>
</div>
<div class="container_legality">
    <div class="legalitas_card_layout">
        <div class="legalitas_card_box">
            <img src=" {{ asset('images/legality-page-1.png') }}" alt="">
        </div>
        <div class="legalitas_card_box">
            <img src="{{ asset('images/legality-page-2.png') }}" alt="">
        </div>
        <div class="legalitas_card_box">
            <img src="{{ asset('images/legality-page-3.png') }}" alt="">
        </div>
        <div class="legalitas_card_box">
            <img src="{{ asset('images/legality-page-4.png') }}" alt="">
        </div>
        <div class="legalitas_card_box legalitas_bla_hidden">
            <img src="{{ asset('images/legality-new-1.jpg') }}" alt="">
        </div>
        <div class="legalitas_card_box legalitas_bla_hidden">
            <img src="{{ asset('images/legality-new-2.jpg') }}" alt="">
        </div>
    </div>
    <div class="img_akreditasi img_akreditasi_mobile">
        <img src="{{ asset('images/akreditasi.jpg') }}" alt="">
    </div>
    <div class="img_akreditasi_layout legalitas_bla_hidden_swap">
        <div class="img_akreditasi img_akreditasi_sc">
            <img src="{{ asset('images/legality-new-1.jpg') }}" alt="">
        </div>
        <div class="img_akreditasi">
            <img src="{{ asset('images/akreditasi.jpg') }}" alt="">
        </div>
        <div class="img_akreditasi img_akreditasi_sc">
            <img src="{{ asset('images/legality-new-2.jpg') }}" alt="">
        </div>
    </div>
</div>
<div class="divider"></div>
<div class="tahap_container">
    <div class="header_benefit_home">
        <h2 style="color:white;">Tahap Berangkat ke Jepang</h2>
        <p style="color:white;">Proses pemberangkatan di LPK Shirokuma dilakukan dengan persiapan matang, mulai dari pengurusan dokumen, pelatihan intensif, hingga bimbingan terakhir sebelum keberangkatan.</p>
    </div>
    <div class="tahap_layout">
        <div class="tahap_box">
            <img src="images/tahap_1.png" alt="">
            <p>Pelatihan dasar selama 3 bulan</p>
        </div>
        <img src="images/arrow.svg" alt="" class="arrow_img">
        <div class="tahap_box">
            <img src="images/tahap_2.png" alt="">
            <p>Tes Wawancara, jika lulus lanjut MCU</p>
        </div>
        <img src="images/arrow.svg" alt="" class="arrow_img">
        <div class="tahap_box">
            <img src="images/tahap_3.png" alt="">
            <p>Pemantapan di SO selama 3 bulan</p>
        </div>
        <img src="images/arrow.svg" alt="" class="arrow_img">
        <div class="tahap_box">
            <img src="images/tahap_4.png" alt="">
            <p>Pemberkasan dokumen</p>
        </div>
        <img src="images/arrow.svg" alt="" class="arrow_img">
        <div class="tahap_box">
            <img src="images/tahap_5.png" alt="">
            <p>Siap bekerja & berangkat ke Jepang</p>
        </div>
    </div>
</div>
<div class="cta_program">
    <h3>Daftar Sekarang dan Mulai Karirmu!</h3>
    <a href="/daftar">
        <button>Daftar Sekarang</button>
    </a>
</div>
<div class="divider"></div>
<div class="section_9">
    <div class="header_program_home">
        <h2>Legalitas LPK Shirokuma</h2>
    </div>
    <div class="swiper klienSwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="klien_box">
                    <img src="images/legality-1.png" alt="Kopassus">
                </div>
            </div>
            <div class="swiper-slide">
                <div class="klien_box">
                    <img src="images/legality-2.png" alt="STIN">
                </div>
            </div>
            <div class="swiper-slide">
                <div class="klien_box">
                    <img src="images/legality-7.png" alt="Kemnaker">
                </div>
            </div>
            <div class="swiper-slide">
                <div class="klien_box">
                    <img src="images/legality-3.png" alt="Siemens">
                </div>
            </div>
            
            
            <div class="swiper-slide">
                <div class="klien_box">
                    <img src="images/legality-5.png" alt="PLN">
                </div>
            </div>
            <div class="swiper-slide">
                <div class="klien_box">
                    <img src="images/legality-6.png" alt="Pertamina">
                </div>
            </div>
            <div class="swiper-slide">
                <div class="klien_box">
                    <img src="images/legality-4.png" alt="Pussenkav">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection