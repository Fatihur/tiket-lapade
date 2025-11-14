<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Berhasil | Lapade</title>
    <meta name="description" content="Pemesanan tiket Lapade berhasil. Simpan kode reservasi dan tunggu validasi pembayaran dari petugas.">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    @php
        $namaWisata = 'Wisata Lapade';
        $tanggalKunjungan = $pemesanan->tanggal_kunjungan instanceof \Carbon\Carbon
            ? $pemesanan->tanggal_kunjungan->translatedFormat('d F Y')
            : $pemesanan->tanggal_kunjungan;
    @endphp

    <nav class="fixed inset-x-0 top-0 z-30 bg-white/90 backdrop-blur">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('landing') }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100 text-lg font-bold text-emerald-700">L</a>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Lapade</p>
                    <p class="text-base font-semibold text-slate-900">{{ $namaWisata }}</p>
                </div>
            </div>
            <a href="{{ route('landing') }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600">Beranda</a>
        </div>
    </nav>

    <main class="flex min-h-screen items-center justify-center px-4 pt-28 pb-16">
        <div class="w-full max-w-3xl rounded-3xl bg-white p-10 shadow-xl shadow-emerald-900/5">
            <div class="mx-auto mb-8 flex h-20 w-20 items-center justify-center rounded-full bg-emerald-50 text-emerald-500">
                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="text-center">
                <h1 class="text-3xl font-bold text-slate-900">Pemesanan Berhasil!</h1>
                <p class="mt-3 text-base text-slate-600">Data Anda sudah diterima sistem Lapade. Validasi dilakukan oleh petugas sebelum tiket digital dikirim.</p>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2">
                <div class="rounded-3xl border border-slate-100 bg-slate-50 p-6">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Kode Pemesanan</p>
                    <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $pemesanan->kode_pemesanan }}</p>
                </div>
                <div class="rounded-3xl border border-slate-100 bg-slate-50 p-6">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Status</p>
                    <span class="mt-2 inline-flex items-center justify-center rounded-full bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-700">Menunggu Validasi</span>
                </div>
            </div>

            <div class="mt-8 rounded-3xl border border-slate-100 bg-white p-6">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-500">Detail Pemesan</p>
                <dl class="mt-4 space-y-4 text-sm text-slate-600">
                    <div class="flex items-center justify-between">
                        <dt>Nama</dt>
                        <dd class="font-semibold text-slate-900">{{ $pemesanan->nama_pemesan }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt>Email</dt>
                        <dd class="font-semibold text-slate-900">{{ $pemesanan->email_pemesan }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt>Wisata</dt>
                        <dd class="font-semibold text-slate-900">{{ $namaWisata }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt>Tanggal Kunjungan</dt>
                        <dd class="font-semibold text-slate-900">{{ $tanggalKunjungan }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt>Total Pembayaran</dt>
                        <dd class="text-lg font-semibold text-slate-900">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</dd>
                    </div>
                </dl>
            </div>

            <div class="mt-8 rounded-3xl border border-dashed border-emerald-200 bg-emerald-50 p-6 text-sm text-emerald-900">
                <p class="font-semibold">Catatan penting</p>
                <ul class="mt-3 list-disc space-y-1 pl-5">
                    <li>Validasi pembayaran dilakukan maksimal 24 jam pada hari kerja.</li>
                    <li>Tiket digital dan QR code akan dikirim ke email/WhatsApp yang Anda daftarkan.</li>
                    <li>Simpan bukti transfer hingga status berubah menjadi <strong>Lunas</strong>.</li>
                </ul>
            </div>

            <div class="mt-10 flex flex-wrap justify-center gap-4">
                <a href="{{ route('landing') }}" class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-8 py-3 text-base font-semibold text-white shadow-lg shadow-emerald-900/20 hover:bg-emerald-400">
                    Kembali ke Beranda
                </a>
                <a href="mailto:{{ $pemesanan->email_pemesan }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 px-8 py-3 text-base font-semibold text-slate-700 hover:border-emerald-400 hover:text-emerald-600">
                    Butuh Bantuan?
                </a>
            </div>
        </div>
    </main>
</body>
</html>
