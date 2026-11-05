@extends('layouts_front.app')

@section('content_front')

<div class="banner_page" style="background-image:url({{ asset('images/ginou_bg.png') }}) !important; background-position:bottom center !important; background-size:cover;">
    <img src="{{ asset('images/overlay_page.png') }}" alt="">
</div>

<div class="legalitas_layout">
    <div class="header_benefit_home" style="margin-bottom:0;">
        <h2>技能実習（Ginoujisshusei）</h2>
        <p>日本の技能実習制度は、インドネシアの若者を対象に1〜3年間実施されるプログラムです。仕事をしながら技術を学び、実務能力と生産性を身につけたうえで、帰国後に母国で能力を発揮できる人材を育てることを目的としています。</p>
    </div>
</div>
<div class="legalitas_grid">
    <div class="legalitas_box_left">
        <h3>一般条件</h3>
        <ul>
            <li>年齢 19〜28歳（技術系高校/高校卒業者対象）。</li>
            <li>専門学校、短大、大学卒業者は最大29歳まで。</li>
            <li>身体・精神ともに健康であること。</li>
            <li>身長最低 160cm（男性）、150cm（女性）。</li>
            <li>3年間のプログラム参加に同意し、契約条件を遵守できること。日本の技能実習プログラムに未参加であること。</li>
            <li>LPK Shirokuma Indonesiaの選考を通過していること。</li>
        </ul>
    </div>
    <div class="legalitas_box_right">
        <h3>必要書類</h3>
        <ul>
            <li>卒業証明書の写し（小学校、中学校、高校/専門学校、短大/大学）各5枚。</li>
            <li>職業紹介カード（黄色カード）5枚。</li>
            <li>住民票カード（KTP）5枚。</li>
            <li>家族手帳（KK）5枚。</li>
            <li>出生証明書 5枚。</li>
            <li>保護者/親族/配偶者の許可書。</li>
            <li>日本の技能実習プログラム未参加の誓約書。</li>
            <li>最新の赤背景の写真 4 x 6 と 3 x 4 を各6枚、写真用CD。</li>
        </ul>
    </div>
</div>
<div class="divider"></div>
<div class="cta_program">
    <h3>今すぐ登録して、キャリアを始めよう！</h3>
    <a href="/daftar">
        <button>今すぐ登録</button>
    </a>
</div>

@endsection