<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $billing->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; }
        .header { border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 20px; }
        .header table { width: 100%; }
        .logo { font-size: 24px; font-weight: bold; color: #2563eb; }
        .status { text-transform: uppercase; font-weight: bold; padding: 5px 10px; border-radius: 4px; font-size: 10px; }
        .status-lunas { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef9c3; color: #854d0e; }
        .status-unpaid { background: #fee2e2; color: #991b1b; }
        .details { margin-bottom: 40px; }
        .details table { width: 100%; }
        .details td { vertical-align: top; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        .items-table th { background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-align: left; padding: 10px; }
        .items-table td { padding: 10px; border-bottom: 1px solid #e2e8f0; }
        .total-section { text-align: right; }
        .total-section table { width: 250px; margin-left: auto; }
        .total-row { font-weight: bold; font-size: 14px; }
        .footer { margin-top: 50px; text-align: center; color: #94a3b8; font-size: 10px; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <table>
                <tr>
                    <td class="logo">LPK SHIROKUMA</td>
                    <td style="text-align: right;">
                        <span class="status {{ $billing->status == 'lunas' ? 'status-lunas' : ($billing->status == 'menunggu_verifikasi' ? 'status-pending' : 'status-unpaid') }}">
                            {{ str_replace('_', ' ', $billing->status) }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="details">
            <table>
                <tr>
                    <td>
                        <strong>Ditagihkan Kepada:</strong><br>
                        {{ $billing->siswa->nama_lengkap }}<br>
                        {{ $billing->siswa->no_hp }}<br>
                        {{ $billing->siswa->alamat }}
                    </td>
                    <td style="text-align: right;">
                        <strong>Nomor Invoice:</strong> #INV-{{ str_pad($billing->id, 5, '0', STR_PAD_LEFT) }}<br>
                        <strong>Tanggal Tagihan:</strong> {{ $billing->created_at->format('d M Y') }}<br>
                        <strong>Jatuh Tempo:</strong> {{ \Carbon\Carbon::parse($billing->jatuh_tempo)->format('d M Y') }}
                    </td>
                </tr>
            </table>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Deskripsi Tagihan</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $billing->judul }}</strong><br>
                        <small>{{ $billing->keterangan }}</small>
                    </td>
                    <td style="text-align: right;">Rp {{ number_format($billing->nominal, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="total-section">
            <table>
                <tr class="total-row">
                    <td>Total Pembayaran:</td>
                    <td style="text-align: right;">Rp {{ number_format($billing->nominal, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        @if($billing->status == 'lunas' && $billing->payment)
        <div style="margin-top: 30px; padding: 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
            <strong>Informasi Pembayaran:</strong><br>
            Bank: {{ $billing->payment->nama_bank }}<br>
            Rekening: {{ $billing->payment->nomor_rekening }}<br>
            Tanggal Bayar: {{ $billing->payment->created_at->format('d M Y H:i') }}
        </div>
        @endif

        <div class="footer">
            <p>Terima kasih atas pembayaran Anda.</p>
            <p>LPK SHIROKUMA - Sistem Akademik & Keuangan</p>
        </div>
    </div>
</body>
</html>