<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Tiket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            font-size: 11px;
        }
        .info {
            margin-bottom: 15px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 3px 0;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data th {
            background: #333;
            color: white;
            padding: 8px 5px;
            text-align: left;
            font-size: 10px;
        }
        table.data td {
            padding: 6px 5px;
            border-bottom: 1px solid #ddd;
        }
        table.data tr:nth-child(even) {
            background: #f9f9f9;
        }
        .total-row {
            background: #f0f0f0 !important;
            font-weight: bold;
            border-top: 2px solid #333;
        }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }
        .signature {
            margin-top: 40px;
        }
        .signature-box {
            display: inline-block;
            width: 200px;
            text-align: center;
        }
        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #333;
            padding-top: 5px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            background: #28a745;
            color: white;
            border-radius: 3px;
            font-size: 9px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENJUALAN TIKET</h1>
        <p>Wisata Lapade - Utan, Sumbawa</p>
        <p>Periode: {{ $tanggalDari }} s/d {{ $tanggalSampai }}</p>
        <p>Dicetak: {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="150"><strong>Total Transaksi</strong></td>
                <td>: {{ $pemesanan->count() }} transaksi</td>
            </tr>
            <tr>
                <td><strong>Total Tiket Terjual</strong></td>
                <td>: {{ $totalTiket }} tiket</td>
            </tr>
            <tr>
                <td><strong>Total Pendapatan</strong></td>
                <td>: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Tanggal</th>
                <th width="15%">Kode</th>
                <th width="20%">Nama Pemesan</th>
                <th width="8%">Jumlah</th>
                <th width="15%">Total</th>
                <th width="12%">Validasi</th>
                <th width="13%">Verifikasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pemesanan as $index => $p)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $p->tanggal_kunjungan->format('d/m/Y') }}</td>
                <td>{{ $p->kode_pemesanan }}</td>
                <td>{{ $p->nama_pemesan }}</td>
                <td class="text-center">{{ $p->jumlah_tiket }}</td>
                <td class="text-right">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                <td>{{ $p->validator->name ?? '-' }}</td>
                <td>{{ $p->verifikatorBendahara->name ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right"><strong>TOTAL</strong></td>
                <td class="text-center"><strong>{{ $totalTiket }}</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p><strong>Catatan:</strong></p>
        <ul style="margin: 5px 0; padding-left: 20px;">
            <li>Laporan ini hanya menampilkan transaksi yang sudah diverifikasi oleh Bendahara</li>
            <li>Semua transaksi sudah melalui proses validasi pembayaran oleh Admin</li>
            <li>Data ini bersifat resmi dan dapat dipertanggungjawabkan</li>
        </ul>
    </div>

    <div class="signature">
        <table width="100%">
            <tr>
                <td width="50%">
                    <div class="signature-box">
                        <p>Mengetahui,</p>
                        <div class="signature-line">
                            <strong>Bendahara</strong>
                        </div>
                    </div>
                </td>
                <td width="50%" class="text-right">
                    <div class="signature-box">
                        <p>Dicetak oleh,</p>
                        <div class="signature-line">
                            <strong>{{ auth()->user()->name }}</strong><br>
                            <small>Admin</small>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
