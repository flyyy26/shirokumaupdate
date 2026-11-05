<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Baru - LPK Shirokuma</title>
    <style>
        /* Reset styles */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            line-height: 1.6;
        }
        
        /* Container */
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        /* Header */
        .email-header {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            padding: 30px 40px;
            text-align: center;
        }
        
        .header-title {
            color: white;
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .header-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            margin-top: 8px;
        }
        
        /* Content */
        .email-content {
            padding: 40px;
        }
        
        .greeting {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 24px;
        }
        
        .message {
            color: #4b5563;
            margin-bottom: 32px;
            font-size: 15px;
        }
        
        /* Info Card */
        .info-card {
            background: linear-gradient(145deg, #f8fafc, #f1f5f9);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 32px;
            border: 1px solid #e2e8f0;
        }
        
        .info-title {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #2563eb;
            display: inline-block;
        }
        
        /* Data Grid */
        .data-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 12px 8px;
        }
        
        .data-label {
            font-weight: 600;
            color: #4b5563;
            font-size: 14px;
        }
        
        .data-value {
            color: #1f2937;
            font-size: 14px;
        }
        
        .data-value.highlight {
            color: #2563eb;
            font-weight: 600;
        }
        
        /* Status Badge */
        .status-badge {
            display: inline-block;
            background-color: #fef3c7;
            color: #d97706;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 4px;
        }
        
        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0;
        }
        
        .data-table tr {
            border-bottom: 1px solid #e2e8f0;
        }
        
        .data-table tr:last-child {
            border-bottom: none;
        }
        
        .data-table td {
            padding: 10px 0;
        }
        
        .data-table td:first-child {
            font-weight: 600;
            color: #4b5563;
            width: 35%;
        }
        
        .data-table td:last-child {
            color: #1f2937;
        }
        
        /* Action Button */
        .action-button {
            text-align: center;
            margin: 32px 0 24px;
        }
        
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: white;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            box-shadow: 0 6px 8px rgba(37, 99, 235, 0.3);
            transform: translateY(-2px);
        }
        
        /* Footer */
        .email-footer {
            padding: 30px 40px;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }
        
        .footer-text {
            color: #6b7280;
            font-size: 13px;
            margin: 4px 0;
        }
        
        .footer-logo {
            margin-top: 16px;
        }
        
        .footer-logo img {
            height: 30px;
            opacity: 0.7;
        }
        
        /* Divider */
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e2e8f0, transparent);
            margin: 24px 0;
        }
        
        /* Alert Box */
        .alert-box {
            background-color: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 16px;
            border-radius: 8px;
            margin: 24px 0;
        }
        
        .alert-box.warning {
            background-color: #fffbeb;
            border-left-color: #f59e0b;
        }
        
        .alert-box.success {
            background-color: #f0fdf4;
            border-left-color: #10b981;
        }
        
        .alert-text {
            color: #7f1d1d;
            font-size: 13px;
            margin: 0;
        }
        
        .alert-text.warning {
            color: #92400e;
        }
        
        .alert-text.success {
            color: #065f46;
        }
        
        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-container {
                border-radius: 12px;
            }
            
            .email-header {
                padding: 20px;
            }
            
            .email-content {
                padding: 10px;
            }
            
            .email-footer {
                padding: 20px;
            }
            
            .header-title {
                font-size: 24px;
            }
            
            .data-table td:first-child {
                width: 40%;
            }
            
            .btn {
                display: block;
                padding: 14px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1 class="header-title">LPK Shirokuma</h1>
            <p class="header-subtitle">Pusat Pelatihan Bahasa Jepang & Karir</p>
        </div>
        
        <!-- Content -->
        <div class="email-content">
            <div class="greeting">
                <strong>Halo Admin,</strong>
            </div>
            
            <p class="message">
                Ada pendaftaran baru yang masuk melalui website. Berikut adalah ringkasan data pendaftar:
            </p>
            
            <!-- Info Card -->
            <div class="info-card">
                <h3 class="info-title">📋 Data Pendaftar</h3>
                
                <!-- Table Format -->
                <table class="data-table">
                    <tr>
                        <td>Nama Lengkap</td>
                        <td><strong>{{ $pendaftaran->nama_lengkap }}</strong></td>
                    </tr>
                    <tr>
                        <td>Program</td>
                        <td>
                            @if($pendaftaran->program == 'magang')
                                <span style="color: #2563eb;">Magang</span>
                            @else
                                <span style="color: #7c3aed;">Ginoujisshusei</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Nomor HP</td>
                        <td>{{ $pendaftaran->no_hp }}</td>
                    </tr>
                    <tr>
                        <td>Pendidikan Terakhir</td>
                        <td>{{ $pendaftaran->pendidikan_terakhir }}</td>
                    </tr>
                    <tr>
                        <td>Jurusan</td>
                        <td>{{ $pendaftaran->jurusan }}</td>
                    </tr>
                    <tr>
                        <td>Pengalaman Bahasa Jepang</td>
                        <td>
                            @if($pendaftaran->pernah_belajar_jepang)
                                <span style="color: #059669;">✓ Sudah Pernah</span>
                            @else
                                <span style="color: #dc2626;">✗ Belum Pernah</span>
                            @endif
                        </td>
                    </tr>
                </table>
                
                <!-- Additional Info -->
                <div style="margin-top: 16px; padding-top: 16px; border-top: 1px dashed #e2e8f0;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #4b5563; font-size: 13px;">Tanggal Daftar:</span>
                        <span style="color: #1f2937; font-size: 13px; font-weight: 500;">
                            {{ \Carbon\Carbon::parse($pendaftaran->created_at)->locale('id')->translatedFormat('d F Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Detail Lengkap dalam Grid -->
            <div style="margin-top: 24px;">
                <h4 style="color: #1f2937; font-size: 16px; font-weight: 600; margin-bottom: 16px;">📌 Informasi Tambahan</h4>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <!-- Tempat, Tanggal Lahir -->
                    <div style="background-color: #f9fafb; padding: 12px; border-radius: 8px;">
                        <div style="color: #6b7280; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Tempat, Tanggal Lahir</div>
                        <div style="color: #1f2937; font-size: 14px; font-weight: 500;">
                            {{ $pendaftaran->tempat_lahir }}, {{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}
                        </div>
                    </div>
                    
                    <!-- Alamat -->
                    <div style="background-color: #f9fafb; padding: 12px; border-radius: 8px; grid-column: span 2;">
                        <div style="color: #6b7280; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Alamat</div>
                        <div style="color: #1f2937; font-size: 14px;">
                            {{ $pendaftaran->alamat }}
                        </div>
                    </div>
                    
                    <!-- Data Fisik -->
                    @if($pendaftaran->tinggi_badan || $pendaftaran->berat_badan)
                    <div style="background-color: #f9fafb; padding: 12px; border-radius: 8px; grid-column: span 2;">
                        <div style="color: #6b7280; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Data Fisik</div>
                        <div style="display: flex; gap: 16px;">
                            @if($pendaftaran->tinggi_badan)
                            <span style="color: #1f2937; font-size: 14px;">Tinggi: {{ $pendaftaran->tinggi_badan }} cm</span>
                            @endif
                            @if($pendaftaran->berat_badan)
                            <span style="color: #1f2937; font-size: 14px;">Berat: {{ $pendaftaran->berat_badan }} kg</span>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Status Pembayaran -->
            <div style="margin-top: 24px;">
                <div style="background-color: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 16px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 32px; height: 32px; background-color: #0ea5e9; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                <path d="M12 2v20M2 12h20" stroke="currentColor"/>
                            </svg>
                        </div>
                        <div>
                            <div style="color: #0369a1; font-size: 13px; font-weight: 600;">Status Pembayaran</div>
                            <div style="color: #0284c7; font-size: 14px;">Bukti pembayaran telah dilampirkan dan menunggu verifikasi</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Button -->
            <div class="action-button">
                <a href="{{ url('/admin/pendaftaran/' . $pendaftaran->id) }}" class="btn">
                    🔍 Lihat Detail Lengkap
                </a>
            </div>
            
            <div class="divider"></div>
            
            <!-- Quick Actions -->
            <div style="text-align: center;">
                <p style="color: #4b5563; font-size: 13px; margin-bottom: 8px;">
                    <strong>Aksi Cepat:</strong>
                </p>
                <div style="display: flex; gap: 12px; justify-content: center;">
                    <a href="{{ url('/admin/pendaftaran/' . $pendaftaran->id . '/verify') }}" 
                       style="color: #059669; text-decoration: none; font-size: 13px; padding: 6px 12px; background-color: #f0fdf4; border-radius: 6px;">
                        ✓ Verifikasi
                    </a>
                    <a href="mailto:{{ $pendaftaran->no_hp }}@whatsapp.com" 
                       style="color: #2563eb; text-decoration: none; font-size: 13px; padding: 6px 12px; background-color: #eff6ff; border-radius: 6px;">
                        💬 Kontak
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <p class="footer-text">© {{ date('Y') }} LPK Shirokuma. All rights reserved.</p>
            <p class="footer-text">Jl. Contoh No. 123, Jakarta</p>
            <p class="footer-text">
                <a href="mailto:info@lpkshirokuma.com" style="color: #2563eb; text-decoration: none;">info@lpkshirokuma.com</a> • 
                <a href="tel:+62123456789" style="color: #2563eb; text-decoration: none;">(021) 1234-5678</a>
            </p>
            <div class="footer-logo">
                <span style="color: #94a3b8; font-size: 12px;">LPK Shirokuma - Membangun Karir di Jepang</span>
            </div>
        </div>
    </div>
</body>
</html>