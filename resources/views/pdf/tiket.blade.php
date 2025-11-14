@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tiket - {{ $pemesanan->kode_pemesanan }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        @page {
            size: 120mm 150mm;
            margin: 0;
        }
        body {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            line-height: 1.2;
            padding: 0;
            margin: 0;
            width: 105mm;
        }
        .receipt {
            border: 2px dashed #333;
            padding: 8mm;
            background: white;
            width: 100%;
        }
        .header {
            text-align: center;
            border-bottom: 1px dashed #333;
            padding-bottom: 6px;
            margin-bottom: 6px;
        }
        .header h1 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        .header p {
            font-size: 10px; 
            margin: 1px 0;
        }
        .section {
            margin: 6px 0;
            padding: 5px 0;
            border-bottom: 1px dashed #ddd;
        }
        .section:last-child {
            border-bottom: none;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin: 2px 0;
        }
        .label {
            font-weight: bold;
        }
        .value {
            text-align: right;
        }
        .ticket-box {
            border: 2px solid #333;
            padding: 8px;
            margin: 6px 0;
            text-align: center;
            page-break-inside: avoid;
        }
        .ticket-box h3 {
            font-size: 12px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .ticket-code {
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin: 5px 0;
            padding: 4px;
            background: #f0f0f0;
        }
        .qr-code {
            margin: 6px auto;
            display: block;
        }
        .qr-code img {
            width: 120px;
            height: 120px;
        }
        .note {
            font-size: 9px;
            text-align: center;
            margin-top: 6px;
            padding-top: 6px;
            border-top: 1px dashed #333;
        }
        .note p {
            margin: 2px 0;
        }
        .total {
            font-size: 12px;
            font-weight: bold;
            margin-top: 3px;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <h1>WISATA LAPADE</h1>
            <p>TIKET MASUK</p>
            <p>{{ $pemesanan->tanggal_kunjungan->format('d/m/Y') }}</p>
        </div>

        <!-- Info Pemesanan -->
        <div class="section">
            <div class="row">
                <span class="label">No. Pemesanan</span>
                <span class="value">{{ $pemesanan->kode_pemesanan }}</span>
            </div>
            <div class="row">
                <span class="label">Nama</span>
                <span class="value">{{ $pemesanan->nama_pemesan }}</span>
            </div>
            <div class="row">
                <span class="label">Tanggal</span>
                <span class="value">{{ $pemesanan->tanggal_kunjungan->format('d/m/Y') }}</span>
            </div>
        </div>

        <!-- Detail Tiket -->
        <div class="section">
            @php
                $wisata = \App\Models\Wisata::first();
            @endphp
            <div class="row">
                <span class="label">Jumlah Pengunjung</span>
                <span class="value">{{ $pemesanan->jumlah_tiket }} x Rp {{ number_format($wisata->harga_tiket ?? 0, 0, ',', '.') }}</span>
            </div>
            @if($pemesanan->jumlah_parkir_motor > 0)
            <div class="row">
                <span class="label">Parkir Motor</span>
                <span class="value">{{ $pemesanan->jumlah_parkir_motor }} x Rp {{ number_format($wisata->biaya_parkir_motor ?? 0, 0, ',', '.') }}</span>
            </div>
            @endif
            @if($pemesanan->jumlah_parkir_mobil > 0)
            <div class="row">
                <span class="label">Parkir Mobil</span>
                <span class="value">{{ $pemesanan->jumlah_parkir_mobil }} x Rp {{ number_format($wisata->biaya_parkir_mobil ?? 0, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="row total">
                <span class="label">TOTAL</span>
                <span class="value">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- QR Code Tiket -->
        @foreach($pemesanan->tiket as $index => $tiket)
        <div class="ticket-box">
            <h3>TIKET #{{ $index + 1 }} - {{ strtoupper($tiket->jenis_tiket) }}</h3>
            <div class="ticket-code">{{ $tiket->kode_tiket }}</div>
            <div class="qr-code">
                @php
                    $qrCodeSvg = QrCode::format('svg')
                        ->size(120)
                        ->errorCorrection('H')
                        ->generate($tiket->kode_tiket);
                    $qrCodeBase64 = base64_encode($qrCodeSvg);
                @endphp
                <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}" alt="QR">
            </div>
            <p style="font-size: 10px; margin-top: 5px;">SCAN DI PINTU MASUK</p>
        </div>
        @endforeach

        <!-- Footer Note -->
        <div class="note">
            <p><strong>PENTING:</strong></p>
            <p>* Tiket hanya berlaku 1x scan</p>
            <p>* Tidak dapat dikembalikan</p>
            <p>* Simpan tiket ini dengan baik</p>
            @php
                $wisata = \App\Models\Wisata::first();
            @endphp
            @if($wisata && $wisata->nomor_whatsapp)
            <p style="margin-top: 8px;">Info: {{ $wisata->nomor_whatsapp }}</p>
            @endif
            <p style="margin-top: 8px; font-size: 9px;">Terima kasih atas kunjungan Anda</p>
        </div>
    </div>
</body>
</html>
