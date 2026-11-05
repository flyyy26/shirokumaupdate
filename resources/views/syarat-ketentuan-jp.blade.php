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
        <h1>利用規約</h1>
        <p>LPK SHIROKUMA Indonesia</p>
        <span class="terms_update">最終更新日: 2026年8月11日</span>
    </div>

    {{-- Terms Content --}}
    <div class="terms_content">

        {{-- 1. Pendahuluan --}}
        <section class="terms_section">
            <h2>1. はじめに</h2>
            <p>LPK SHIROKUMA Indonesia の公式ウェブサイトへようこそ。当サイトにアクセスし、サービスをご利用になることで、適用される利用規約に同意したものとみなされます。サービスをご利用になる前に、必ずご確認ください。</p>
            <p>LPK SHIROKUMA Indonesia は、以下の分野を扱う職業訓練機関です。</p>
            <ul>
                <li>日本語教育</li>
                <li>日本への研修・実習準備</li>
                <li>職業技能訓練</li>
                <li>キャリア相談</li>
            </ul>
        </section>

        {{-- 2. Definisi --}}
        <section class="terms_section">
            <h2>2. 定義</h2>
            <div class="terms_definition">
                <div class="def_item">
                    <span class="def_term">利用者</span>
                    <span class="def_desc">LPK SHIROKUMA Indonesia のサービスにアクセスし、利用する個人または団体を指します。</span>
                </div>
                <div class="def_item">
                    <span class="def_term">サービス</span>
                    <span class="def_desc">LPK SHIROKUMA Indonesia が提供するすべての研修プログラム、相談、情報を指します。</span>
                </div>
                <div class="def_item">
                    <span class="def_term">コンテンツ</span>
                    <span class="def_desc">LPK SHIROKUMA Indonesia のウェブサイトに掲載されるすべての情報、資料、画像、動画、データを指します。</span>
                </div>
                <div class="def_item">
                    <span class="def_term">受講生</span>
                    <span class="def_desc">LPK SHIROKUMA Indonesia に登録し、研修プログラムに参加する個人を指します。</span>
                </div>
            </div>
        </section>

        {{-- 3. Pendaftaran --}}
        <section class="terms_section">
            <h2>3. 登録および参加</h2>
            <ol>
                <li>受講生の登録は、公式ウェブサイトからオンラインで行うか、LPK SHIROKUMA Indonesia の事務所に直接来場して行います。</li>
                <li>志願者は、正確かつ完全な情報を登録フォームに入力する必要があります。</li>
                <li>LPK SHIROKUMA Indonesia は、提供された情報が不完全または不正確な場合、登録を拒否する権利を有します。</li>
                <li>受講生は、筆記試験や面接を含む、定められた選考プロセスをすべて受ける必要があります。</li>
                <li>選考結果は最終的なものであり、異議申し立てはできません。</li>
            </ol>
        </section>

        {{-- 4. Biaya dan Pembayaran --}}
        <section class="terms_section">
            <h2>4. 料金および支払い</h2>
            <ol>
                <li>研修料金は選択したプログラムに応じて決定され、正式に公表されます。</li>
                <li>支払いは銀行振込、電子マネー、または提供されるその他の支払方法で行えます。</li>
                <li>受講生は、定められたスケジュールに従って研修費を支払う必要があります。</li>
                <li>支払い遅延により、参加の延期またはキャンセルが発生する場合があります。</li>
                <li>支払済みの料金は、LPK SHIROKUMA Indonesia との特別な合意がない限り、返金されません。</li>
            </ol>
        </section>

        {{-- 5. Hak dan Kewajiban Peserta --}}
        <section class="terms_section">
            <h2>5. 受講生の権利と義務</h2>
            <div class="terms_two_col">
                <div class="terms_col">
                    <h3>受講生の権利</h3>
                    <ul>
                        <li>質の高い研修教材を受け取る</li>
                        <li>有能な講師からの指導を受ける</li>
                        <li>提供される研修施設を利用する</li>
                        <li>プログラム修了後に修了証を受け取る</li>
                        <li>実習・求人情報を受け取る</li>
                    </ul>
                </div>
                <div class="terms_col">
                    <h3>受講生の義務</h3>
                    <ul>
                        <li>すべての研修セッションに規律正しく参加する</li>
                        <li>LPK SHIROKUMA Indonesia の名誉を守る</li>
                        <li>講師や他の受講生を尊重する</li>
                        <li>定められた規則と規律を守る</li>
                        <li>研修費を期日までに支払う</li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- 6. Hak Kekayaan Intelektual --}}
        <section class="terms_section">
            <h2>6. 知的財産権</h2>
            <ol>
                <li>LPK SHIROKUMA Indonesia のウェブサイトに含まれるすべてのコンテンツは、著作権およびその他の知的財産権によって保護されています。</li>
                <li>利用者は、LPK SHIROKUMA Indonesia の書面による許可なく、コンテンツを複製、配布、または使用することはできません。</li>
                <li>受講生に提供される研修資料は、LPK SHIROKUMA Indonesia の所有物であり、無断で配布してはなりません。</li>
                <li>知的財産権の侵害には、適用される法律に基づく制裁が科されます。</li>
            </ol>
        </section>

        {{-- 7. Kerahasiaan Data --}}
        <section class="terms_section">
            <h2>7. 個人情報の保護</h2>
            <ol>
                <li>LPK SHIROKUMA Indonesia は、適用される法令に従って利用者の個人情報を保護することを約束します。</li>
                <li>受講生の個人情報は、研修および公式コミュニケーションの目的にのみ使用されます。</li>
                <li>LPK SHIROKUMA Indonesia は、許可なく利用者の個人情報を第三者に販売または共有しません。</li>
                <li>利用者は、当社にお問い合わせいただくことで、自身の個人情報の確認、修正、削除を請求できます。</li>
            </ol>
        </section>

        {{-- 8. キャンセルと辞退 --}}
        <section class="terms_section">
            <h2>8. キャンセルおよび辞退</h2>
            <ol>
                <li>受講生は、LPK SHIROKUMA Indonesia に書面で通知することにより、研修プログラムを辞退できます。</li>
                <li>研修開始後に辞退した場合、料金の返金は行われません。</li>
                <li>LPK SHIROKUMA Indonesia は、規則に違反した場合、受講生の参加を取り消す権利を有します。</li>
                <li>LPK SHIROKUMA Indonesia によるキャンセルは、一定の理由がある場合に限り、比例に応じた返金を行うことがあります。</li>
            </ol>
        </section>

        {{-- 9. 規約の変更 --}}
        <section class="terms_section">
            <h2>9. 利用規約の変更</h2>
            <ol>
                <li>LPK SHIROKUMA Indonesia は、事前の通知なく、この利用規約を随時変更する権利を有します。</li>
                <li>変更内容は、公式ウェブサイトまたはその他の広報媒体で公表されます。</li>
                <li>当社のサービスを継続して利用することにより、利用者は変更後の規約に同意したものとみなされます。</li>
            </ol>
        </section>

        {{-- 10. Hukum yang Berlaku --}}
        <section class="terms_section">
            <h2>10. 準拠法</h2>
            <ol>
                <li>本規約は、インドネシア共和国の法律に準拠します。</li>
                <li>発生した紛争は、協議により解決するものとします。</li>
                <li>協議が合意に至らない場合、紛争は当地の地方裁判所で解決されます。</li>
            </ol>
        </section>

        {{-- 11. Kontak Kami --}}
        <section class="terms_section terms_contact">
            <h2>11. お問い合わせ</h2>
            <p>本規約に関するご質問がございましたら、以下までご連絡ください。</p>
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
        <p>LPK SHIROKUMA Indonesia のサービスにアクセス・利用することにより、当社の適用されるすべての利用規約を読み、理解し、同意したものとみなします。</p>
        <div class="agreement_buttons">
            <a href="{{ url('/') }}" class="agree_btn">同意します</a>
            <a href="{{ url('/kontak') }}" class="contact_btn">お問い合わせ</a>
        </div>
    </div>

</div>

@endsection