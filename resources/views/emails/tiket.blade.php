<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Wisata</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .ticket-info {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #666;
        }
        .value {
            color: #333;
        }
        .qr-section {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background: white;
            border-radius: 8px;
        }
        .qr-code {
            max-width: 250px;
            margin: 20px auto;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #eee;
            color: #666;
            font-size: 14px;
        }
        .important-note {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎫 Tiket Wisata Anda</h1>
        <p>Pembayaran Berhasil Divalidasi</p>
    </div>

    <div class="content">
        <p>Halo <strong>{{ $pemesanan->nama_pemesan }}</strong>,</p>
        
        <p>Terima kasih telah melakukan pemesanan tiket. Pembayaran Anda telah divalidasi dan tiket Anda sudah siap digunakan!</p>

        <div class="ticket-info">
            <h3 style="margin-top: 0; color: #667eea;">📋 Detail Pemesanan</h3>
            
            <div class="info-row">
                <span class="label">Kode Pemesanan:</span>
                <span class="value">{{ $pemesanan->kode_pemesanan }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Wisata:</span>
                <span class="value">Wisata Lapade</span>
            </div>
            
            <div class="info-row">
                <span class="label">Tanggal Kunjungan:</span>
                <span class="value">{{ $pemesanan->tanggal_kunjungan->format('d F Y') }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Jumlah Tiket:</span>
                <span class="value">{{ $pemesanan->jumlah_tiket }} tiket</span>
            </div>
            
            <div class="info-row">
                <span class="label">Total Pembayaran:</span>
                <span class="value"><strong>Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</strong></span>
            </div>
        </div>

        <div class="important-note">
            <strong>⚠️ Penting:</strong>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Simpan email ini dengan baik</li>
                <li>Tunjukkan QR Code di bawah ini saat memasuki lokasi wisata</li>
                <li>Setiap QR Code hanya dapat digunakan <strong>SATU KALI</strong></li>
                <li>Datang sesuai tanggal kunjungan yang tertera</li>
            </ul>
        </div>

        <div style="background: #e3f2fd; border-left: 4px solid #2196f3; padding: 20px; margin: 30px 0; border-radius: 8px;">
            <h3 style="color: #1976d2; margin-top: 0;">📎 Tiket Terlampir</h3>
            <p style="margin: 10px 0; color: #333;">
                Tiket Anda terlampir dalam email ini dalam format <strong>PDF</strong>.
            </p>
            <p style="margin: 10px 0; color: #333;">
                Silakan <strong>download dan cetak</strong> tiket PDF, atau simpan di HP Anda.
            </p>
            <p style="margin: 10px 0; color: #333;">
                Tunjukkan <strong>QR Code</strong> yang ada di tiket PDF saat memasuki lokasi wisata.
            </p>
        </div>

        <div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 8px;">
            <p style="margin: 0; color: #856404;">
                <strong>💡 Tips:</strong> Simpan file PDF tiket di HP Anda agar mudah diakses saat berkunjung.
            </p>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <p>Butuh bantuan? Hubungi kami:</p>
            @php
                $wisata = \App\Models\Wisata::first();
            @endphp
            @if($wisata && $wisata->email_kontak)
                <p>📧 Email: {{ $wisata->email_kontak }}</p>
            @endif
            @if($wisata && $wisata->nomor_whatsapp)
                <p>📱 WhatsApp: {{ $wisata->nomor_whatsapp }}</p>
            @endif
        </div>

        <div class="footer">
            <p><strong>Selamat Berlibur! 🎉</strong></p>
            <p style="font-size: 12px; color: #999;">
                Email ini dikirim secara otomatis, mohon tidak membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>
