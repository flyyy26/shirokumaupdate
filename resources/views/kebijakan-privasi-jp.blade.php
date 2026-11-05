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
        <h1>プライバシーポリシー</h1>
        <p>LPK SHIROKUMA Indonesia</p>
        <span class="privacy_update">最終更新日: 2026年8月11日</span>
    </div>

    {{-- Privacy Content --}}
    <div class="privacy_content">

        {{-- 1. Pendahuluan --}}
        <section class="privacy_section">
            <h2>1. はじめに</h2>
            <p>LPK SHIROKUMA Indonesia は、お客様のプライバシーと個人情報を保護することに尽力しています。本プライバシーポリシーでは、当社がお客様から提供された個人情報をどのように収集、利用、保存、保護するかをご説明します。</p>
            <p>当社のサービスをご利用になることで、本ポリシーに定めるデータ収集および利用方法に同意したものとみなされます。</p>
        </section>

        {{-- 2. Informasi yang Kami Kumpulkan --}}
        <section class="privacy_section">
            <h2>2. 収集する情報</h2>
            <p>当社は利用者から次の情報を収集します。</p>
            <div class="privacy_grid">
                <div class="privacy_card">
                    <div class="card_icon">👤</div>
                    <h3>本人情報</h3>
                    <ul>
                        <li>氏名</li>
                        <li>生年月日</li>
                        <li>性別</li>
                        <li>国籍</li>
                        <li>身分証明書番号 / パスポート番号</li>
                    </ul>
                </div>
                <div class="privacy_card">
                    <div class="card_icon">📞</div>
                    <h3>連絡先情報</h3>
                    <ul>
                        <li>住所</li>
                        <li>電話番号 / WhatsApp</li>
                        <li>メールアドレス</li>
                        <li>緊急連絡先</li>
                    </ul>
                </div>
                <div class="privacy_card">
                    <div class="card_icon">📚</div>
                    <h3>学歴情報</h3>
                    <ul>
                        <li>学歴</li>
                        <li>成績 / 学業実績</li>
                        <li>研修証明書</li>
                        <li>語学能力</li>
                    </ul>
                </div>
                <div class="privacy_card">
                    <div class="card_icon">💼</div>
                    <h3>職歴情報</h3>
                    <ul>
                        <li>職歴</li>
                        <li>実習経験</li>
                        <li>職業技能</li>
                        <li>職務経歴の参考情報</li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- 3. Cara Kami Menggunakan Informasi --}}
        <section class="privacy_section">
            <h2>3. 情報の利用方法</h2>
            <p>収集した情報は、次の目的で使用します。</p>
            <ol>
                <li><strong>登録および管理:</strong> 研修または実習の参加登録を処理するため。</li>
                <li><strong>連絡:</strong> 研修プログラム、スケジュール、重要なお知らせをお知らせするため。</li>
                <li><strong>サービス改善:</strong> 研修およびサービス品質を評価し、改善するため。</li>
                <li><strong>法令遵守:</strong> 適用される法令および規制を遵守するため。</li>
                <li><strong>実習配置:</strong> パートナー企業との連携のため。</li>
                <li><strong>報告:</strong> 内部レポートや統計を作成し、プログラム開発に活用するため。</li>
            </ol>
        </section>

        {{-- 4. Dasar Hukum Pemrosesan Data --}}
        <section class="privacy_section">
            <h2>4. 個人情報処理の法的根拠</h2>
            <p>当社は、次の法的根拠に基づいて個人情報を処理します。</p>
            <div class="privacy_legal">
                <div class="legal_item">
                    <span class="legal_badge">✅</span>
                    <div>
                        <h3>同意</h3>
                        <p>特定の目的で個人情報の処理に同意いただいています。</p>
                    </div>
                </div>
                <div class="legal_item">
                    <span class="legal_badge">📋</span>
                    <div>
                        <h3>契約</h3>
                        <p>契約の履行または契約締結前の行為のために必要です。</p>
                    </div>
                </div>
                <div class="legal_item">
                    <span class="legal_badge">⚖️</span>
                    <div>
                        <h3>法的義務</h3>
                        <p>適用される法的義務を遵守するために必要です。</p>
                    </div>
                </div>
                <div class="legal_item">
                    <span class="legal_badge">🎯</span>
                    <div>
                        <h3>正当な利益</h3>
                        <p>サービス向上やセキュリティ確保など、当社の正当な利益のために必要です。</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- 5. Penyimpanan dan Keamanan Data --}}
        <section class="privacy_section">
            <h2>5. データの保存と安全管理</h2>
            <ol>
                <li>お客様の個人情報は安全なシステムに保存され、権限を持つ担当者のみがアクセスできます。</li>
                <li>当社は、不正アクセス、改ざん、破壊からデータを保護するため、技術的および組織的な適切なセキュリティ対策を実施しています。</li>
                <li>個人情報は、収集目的の達成に必要な期間、または法令により保存が義務付けられている期間のみ保存します。</li>
                <li>不要になった場合は、個人情報は安全に削除または匿名化されます。</li>
            </ol>
        </section>

        {{-- 6. Berbagi Data dengan Pihak Ketiga --}}
        <section class="privacy_section">
            <h2>6. 第三者への情報提供</h2>
            <p>当社はお客様の個人情報を販売または賃貸することはありません。ただし、次の場合には情報を共有することがあります。</p>
            <ul>
                <li><strong>提携企業:</strong> 実習配置や就職支援のため。</li>
                <li><strong>サービス提供者:</strong> オンライン学習プラットフォームや決済システムなど、運営を支援する第三者。</li>
                <li><strong>政府機関:</strong> 法令に基づく場合または公益のため。</li>
                <li><strong>コンサルタント:</strong> 監査や運営に関する相談のため。</li>
            </ul>
            <p class="privacy_note">当社にデータを受け取った第三者は、当社と同等のセキュリティおよび機密保持基準を遵守する必要があります。</p>
        </section>

        {{-- 7. Hak Anda sebagai Subjek Data --}}
        <section class="privacy_section">
            <h2>7. ご本人の権利</h2>
            <p>個人情報の主体として、次の権利を有します。</p>
            <div class="privacy_rights">
                <div class="right_item">
                    <span class="right_icon">🔍</span>
                    <div>
                        <h3>開示請求</h3>
                        <p>当社が保有する本人情報のコピーを請求できます。</p>
                    </div>
                </div>
                <div class="right_item">
                    <span class="right_icon">✏️</span>
                    <div>
                        <h3>訂正権</h3>
                        <p>個人情報に誤りがある場合、訂正を請求できます。</p>
                    </div>
                </div>
                <div class="right_item">
                    <span class="right_icon">🗑️</span>
                    <div>
                        <h3>削除権</h3>
                        <p>特定の条件下で個人情報の削除を請求できます。</p>
                    </div>
                </div>
                <div class="right_item">
                    <span class="right_icon">⛔</span>
                    <div>
                        <h3>制限権</h3>
                        <p>個人情報の処理を制限するよう請求できます。</p>
                    </div>
                </div>
                <div class="right_item">
                    <span class="right_icon">📤</span>
                    <div>
                        <h3>移行可能性</h3>
                        <p>個人情報を構造化された一般的な形式で受け取る権利があります。</p>
                    </div>
                </div>
                <div class="right_item">
                    <span class="right_icon">🙅</span>
                    <div>
                        <h3>反対権</h3>
                        <p>直接マーケティング目的の処理に反対できます。</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- 8. Cookie dan Teknologi Pelacakan --}}
        <section class="privacy_section">
            <h2>8. Cookie および追跡技術</h2>
            <p>当社のウェブサイトは、ユーザー体験向上のためにCookieおよび類似技術を使用しています。</p>
            <ul>
                <li><strong>必須Cookie:</strong> ナビゲーションや安全なエリアへのアクセスなど、基本機能に必要です。</li>
                <li><strong>分析Cookie:</strong> 利用者がどのようにサイトを利用しているかを把握し、コンテンツとサービスを改善するために使用します。</li>
                <li><strong>設定Cookie:</strong> 選択した言語などの設定を記憶します。</li>
                <li><strong>マーケティングCookie:</strong> 利用者の興味に関連するコンテンツを表示するために使用します。</li>
            </ul>
            <p class="privacy_note">Cookie設定はブラウザで管理できます。ただし、一部のCookieを無効にすると、サイトの機能に影響する場合があります。</p>
        </section>

        {{-- 9. Perlindungan Data Anak --}}
        <section class="privacy_section">
            <h2>9. 子どもの個人情報保護</h2>
            <p>LPK SHIROKUMA Indonesia は、法定代理人の同意なしに18歳未満の子どもの個人情報を意図的に収集しません。適切な同意なしに18歳未満の個人情報を収集したことが判明した場合は、速やかに削除いたします。</p>
            <p>18歳未満の受講者向け研修では、保護者または法定代理人の書面による同意を取得します。</p>
        </section>

        {{-- 10. Perubahan Kebijakan Privasi --}}
        <section class="privacy_section">
            <h2>10. プライバシーポリシーの変更</h2>
            <ol>
                <li>当社は、運営上の理由、法令、または規制の変更に応じて、本ポリシーを随時更新する場合があります。</li>
                <li>変更内容は公式ウェブサイトで告知され、公開後すぐに適用されます。</li>
                <li>当社のプライバシー実務の最新情報を確認するため、定期的に本ページをご確認ください。</li>
                <li>変更後もサービスをご利用いただく場合、更新版のプライバシーポリシーに同意したものとみなします。</li>
            </ol>
        </section>

        {{-- 11. Kontak Kami --}}
        <section class="privacy_section privacy_contact">
            <h2>11. お問い合わせ</h2>
            <p>個人情報に関するご質問、懸念事項、またはご自身の権利行使をご希望の場合は、以下までご連絡ください。</p>
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
                    <span>月曜～金曜 08:00 ～ 17:00 WIB</span>
                </div>
            </div>
        </section>

    </div>

    {{-- Consent --}}
    <div class="privacy_consent">
        <p>LPK SHIROKUMA Indonesia のサービスにアクセス・利用することにより、適用されるプライバシーポリシーを読み、理解し、同意したものとみなします。</p>
        <div class="consent_buttons">
            <a href="{{ url('/') }}" class="agree_btn">✅ 同意します</a>
            <a href="{{ url('/kontak') }}" class="contact_btn">📞 お問い合わせ</a>
        </div>
    </div>

</div>

@endsection