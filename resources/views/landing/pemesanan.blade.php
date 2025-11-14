<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan Lapade | Utan, Sumbawa</title>
    <meta name="description" content="Isi formulir pemesanan tiket resmi Wisata Lapade dan unggah bukti transfer untuk validasi petugas.">
    
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
        $hargaTiket = $wisata->harga_tiket ?? 0;
        $biayaParkirMotor = $wisata->biaya_parkir_motor ?? 0;
        $biayaParkirMobil = $wisata->biaya_parkir_mobil ?? 0;
        $whatsappNumber = $wisata->nomor_whatsapp ? preg_replace('/[^0-9]/', '', $wisata->nomor_whatsapp) : null;
        $today = date('Y-m-d');
    @endphp

    <nav class="fixed inset-x-0 top-0 z-30 bg-white/90 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('landing') }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-sky-100 text-lg font-bold text-sky-700">L</a>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Lapade</p>
                    <p class="text-base font-semibold text-slate-900">{{ $namaWisata }}</p>
                </div>
            </div>
            <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-sky-600">Login</a>
        </div>
    </nav>

    <main class="pt-28 pb-16">
        <section class="mx-auto max-w-6xl px-4">
            <div class="mb-8">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-sky-600">
                    <span>&larr;</span>
                    <span>Kembali ke halaman utama</span>
                </a>
            </div>

            <div class="grid gap-8 lg:grid-cols-[1fr,1fr]">
                <div class="space-y-6">
                    <div class="rounded-3xl bg-white p-8 shadow-lg shadow-slate-900/5">
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-500">Ringkasan</p>
                        <h1 class="mt-3 text-3xl font-bold text-slate-900">Pemesanan Tiket Lapade</h1>
                        <p class="mt-3 text-slate-600">Reservasi ini terhubung langsung dengan pengelola Lapade di Utan, Kabupaten Sumbawa.</p>
                        <dl class="mt-6 space-y-4 text-sm">
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                <dt class="text-slate-500">Destinasi</dt>
                                <dd class="font-semibold text-slate-900">{{ $namaWisata }}</dd>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                <dt class="text-slate-500">Lokasi</dt>
                                <dd class="font-semibold text-slate-900">Desa Lapade, Utan - NTB</dd>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                <dt class="text-slate-500">Kontak</dt>
                                <dd class="font-semibold text-slate-900">
                                    @if($wisata->nomor_whatsapp)
                                        <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" class="text-sky-600 hover:text-sky-500">{{ $wisata->nomor_whatsapp }}</a>
                                    @elseif($wisata->email_kontak)
                                        <a href="mailto:{{ $wisata->email_kontak }}" class="text-sky-600 hover:text-sky-500">{{ $wisata->email_kontak }}</a>
                                    @else
                                        Reservasi online
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div class="rounded-3xl border border-slate-100 bg-white p-8">
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-500">Daftar Harga</p>
                        <div class="mt-4 space-y-4">
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                <div>
                                    <p class="text-xs uppercase text-slate-500">Tiket Masuk</p>
                                    <p class="text-lg font-semibold text-slate-900">Rp {{ number_format($hargaTiket, 0, ',', '.') }}</p>
                                </div>
                                <span class="text-sm text-slate-500">per orang</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                <div>
                                    <p class="text-xs uppercase text-slate-500">Parkir motor</p>
                                    <p class="text-lg font-semibold text-slate-900">Rp {{ number_format($biayaParkirMotor, 0, ',', '.') }}</p>
                                </div>
                                <span class="text-sm text-slate-500">per unit</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                                <div>
                                    <p class="text-xs uppercase text-slate-500">Parkir mobil</p>
                                    <p class="text-lg font-semibold text-slate-900">Rp {{ number_format($biayaParkirMobil, 0, ',', '.') }}</p>
                                </div>
                                <span class="text-sm text-slate-500">per unit</span>
                            </div>
                        </div>
                        <div class="mt-6 rounded-2xl border border-dashed border-slate-200 p-4 text-sm text-slate-600">
                            <p class="font-semibold text-slate-900">Pembayaran hanya melalui rekening resmi:</p>
                            @if($wisata->nama_bank || $wisata->nomor_rekening || $wisata->atas_nama)
                                <ul class="mt-3 space-y-1">
                                    @if($wisata->nama_bank)
                                        <li>Bank: {{ $wisata->nama_bank }}</li>
                                    @endif
                                    @if($wisata->nomor_rekening)
                                        <li>No. Rekening: {{ $wisata->nomor_rekening }}</li>
                                    @endif
                                    @if($wisata->atas_nama)
                                        <li>Atas Nama: {{ $wisata->atas_nama }}</li>
                                    @endif
                                </ul>
                            @else
                                <p class="mt-3">Silakan hubungi kontak Lapade untuk konfirmasi rekening aktif.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <div class="rounded-3xl bg-white p-8 shadow-lg shadow-slate-900/5">
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-500">Formulir Pemesanan</p>
                        <h2 class="mt-3 text-2xl font-bold text-slate-900">Isi data pengunjung</h2>

                        @if($errors->any())
                            <div class="mt-4 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                                <p class="font-semibold">Periksa kembali:</p>
                                <ul class="mt-2 list-disc space-y-1 pl-5">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('pemesanan.store') }}" method="POST" enctype="multipart/form-data" id="formPemesanan" class="mt-6 space-y-6">
                            @csrf

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-600">Nama Lengkap</label>
                                <input type="text" name="nama_pemesan" value="{{ old('nama_pemesan') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-100" required>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-600">Email</label>
                                <input type="email" name="email_pemesan" value="{{ old('email_pemesan') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-100" required>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-600">Nomor WhatsApp</label>
                                <input type="text" name="nomor_whatsapp" value="{{ old('nomor_whatsapp') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-100" required>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-600">Tanggal Kunjungan</label>
                                <input type="date" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan') }}" min="{{ $today }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-100" required>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-600">Jumlah Tiket</label>
                                <input type="number" name="jumlah_tiket" value="{{ old('jumlah_tiket', 1) }}" min="1" data-harga="{{ $hargaTiket }}" class="hitung-total w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-100" required>
                                <p class="text-xs text-slate-500">Rp {{ number_format($hargaTiket, 0, ',', '.') }} per orang</p>
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-600">Parkir Motor</label>
                                    <input type="number" name="jumlah_parkir_motor" value="{{ old('jumlah_parkir_motor', 0) }}" min="0" data-harga="{{ $biayaParkirMotor }}" class="hitung-total w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-100" required>
                                    <p class="text-xs text-slate-500">Rp {{ number_format($biayaParkirMotor, 0, ',', '.') }} per unit</p>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-600">Parkir Mobil</label>
                                    <input type="number" name="jumlah_parkir_mobil" value="{{ old('jumlah_parkir_mobil', 0) }}" min="0" data-harga="{{ $biayaParkirMobil }}" class="hitung-total w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-100" required>
                                    <p class="text-xs text-slate-500">Rp {{ number_format($biayaParkirMobil, 0, ',', '.') }} per unit</p>
                                </div>
                            </div>

                            <div class="rounded-3xl bg-slate-900 px-6 py-5 text-white">
                                <p class="text-sm uppercase tracking-[0.3em] text-white/60">Total sementara</p>
                                <p class="mt-2 text-4xl font-semibold" id="totalHarga">Rp 0</p>
                                <p class="mt-1 text-sm text-white/70">Total akhir menyesuaikan jumlah yang Anda isi.</p>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-600">Upload Bukti Transfer</label>
                                <input type="file" name="bukti_transfer" accept="image/*" class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-100" required>
                                <p class="text-xs text-slate-500">Format JPG/PNG, maksimum 2 MB.</p>
                            </div>

                            <button type="submit" class="w-full rounded-2xl bg-sky-500 px-6 py-4 text-base font-semibold text-white shadow-lg shadow-sky-900/20 hover:bg-sky-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-200">
                                Kirim Pemesanan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jumlahTiket = document.querySelector('input[name="jumlah_tiket"]');
            const parkirMotor = document.querySelector('input[name="jumlah_parkir_motor"]');
            const parkirMobil = document.querySelector('input[name="jumlah_parkir_mobil"]');
            const totalElement = document.getElementById('totalHarga');
            const formatter = new Intl.NumberFormat('id-ID');

            function hitungTotal() {
                const tiket = parseInt(jumlahTiket.value, 10) || 0;
                const hargaTiket = parseFloat(jumlahTiket.dataset.harga) || 0;
                
                const motor = parseInt(parkirMotor.value, 10) || 0;
                const hargaMotor = parseFloat(parkirMotor.dataset.harga) || 0;
                
                const mobil = parseInt(parkirMobil.value, 10) || 0;
                const hargaMobil = parseFloat(parkirMobil.dataset.harga) || 0;
                
                const total = (tiket * hargaTiket) + (motor * hargaMotor) + (mobil * hargaMobil);
                totalElement.textContent = 'Rp ' + formatter.format(total);
            }

            jumlahTiket.addEventListener('input', hitungTotal);
            parkirMotor.addEventListener('input', hitungTotal);
            parkirMobil.addEventListener('input', hitungTotal);

            hitungTotal();
        });
    </script>
</body>
</html>
