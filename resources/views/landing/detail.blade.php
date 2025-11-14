<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tiket | Lapade - Utan, Sumbawa</title>
    <meta name="description" content="Lihat detail fasilitas, harga tiket, dan galeri resmi Wisata Lapade sebelum melakukan pemesanan.">
    
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
        $namaWisata = $wisata->nama_wisata ?? 'Wisata Lapade';
        $deskripsi = $wisata->deskripsi ?: 'Pengelola Lapade menyediakan suasana alam pesisir Utan yang masih asri dengan fasilitas yang terus ditingkatkan.';
        $hargaDewasa = $wisata->harga_tiket_dewasa ?? $wisata->harga_tiket;
        $hargaAnak = $wisata->harga_tiket_anak ?? null;
    @endphp

    <div class="flex min-h-screen flex-col">
        <header class="relative isolate">
            <nav class="fixed inset-x-0 top-0 z-30 bg-white/90 backdrop-blur">
                <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('landing') }}" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-sky-100 text-lg font-bold text-sky-700">L</a>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Lapade</p>
                            <p class="text-base font-semibold text-slate-900">{{ $namaWisata }}</p>
                        </div>
                    </div>
                    <div class="hidden items-center gap-4 text-sm font-medium text-slate-700 md:flex">
                        <a href="{{ route('landing') }}" class="hover:text-sky-600">Beranda</a>
                        <a href="{{ route('pemesanan.create', $wisata->id) }}" class="rounded-full border border-slate-200 px-4 py-2 hover:border-sky-500 hover:text-sky-600">Pesan Tiket</a>
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-sky-600">Login</a>
                    </div>
                    <div class="md:hidden">
                        <a href="{{ route('pemesanan.create', $wisata->id) }}" class="text-sm font-semibold text-sky-700">Pesan Tiket</a>
                    </div>
                </div>
            </nav>

            <section class="relative isolate overflow-hidden pt-32 pb-24">
                <div class="absolute inset-0">
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-sky-900 to-emerald-800"></div>
                    <div class="absolute inset-0 bg-slate-900/60"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-slate-900/25"></div>
                </div>
                <div class="relative z-10 mx-auto max-w-4xl px-4 text-center text-white">
                    <p class="mb-4 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1 text-sm font-medium">
                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                        Detail resmi wisata Lapade
                    </p>
                    <h1 class="text-4xl font-semibold leading-tight md:text-5xl">{{ $namaWisata }}</h1>
                    <p class="mt-5 text-lg text-white/80">{{ $deskripsi }}</p>
                    <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                        <a href="{{ route('pemesanan.create', $wisata->id) }}" class="inline-flex items-center justify-center rounded-full bg-sky-500 px-8 py-3 text-base font-semibold text-white shadow-lg shadow-sky-900/30 hover:bg-sky-400">
                            Pesan Tiket Resmi
                        </a>
                        <a href="{{ route('landing') }}" class="inline-flex items-center justify-center rounded-full border border-white/40 px-8 py-3 text-base font-semibold text-white hover:border-white hover:bg-white/10">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </section>
        </header>

        <main class="flex-1">
            <section class="mx-auto max-w-6xl px-4 py-16">
                <div class="grid gap-8 lg:grid-cols-3">
                    <div class="lg:col-span-2">
                        <div class="rounded-3xl bg-white p-8 shadow-lg shadow-slate-900/5">
                            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-500">Tentang Lapade</p>
                            <h2 class="mt-3 text-3xl font-bold text-slate-900">Suasana pesisir Utan yang autentik</h2>
                            <p class="mt-4 text-slate-600">{{ $deskripsi }}</p>
                            <div class="mt-8 grid gap-6 md:grid-cols-2">
                                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                                    <p class="text-xs uppercase tracking-wide text-slate-500">Lokasi</p>
                                    <p class="mt-2 text-lg font-semibold text-slate-900">Desa Lapade, Utan</p>
                                    <p class="text-sm text-slate-600">Kabupaten Sumbawa, Nusa Tenggara Barat</p>
                                </div>
                                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                                    <p class="text-xs uppercase tracking-wide text-slate-500">Kontak resmi</p>
                                    @if($wisata->nomor_whatsapp)
                                        <p class="mt-2 text-lg font-semibold text-slate-900">{{ $wisata->nomor_whatsapp }}</p>
                                        <p class="text-sm text-slate-600">WhatsApp pengelola Lapade</p>
                                    @elseif($wisata->email_kontak)
                                        <p class="mt-2 text-lg font-semibold text-slate-900">{{ $wisata->email_kontak }}</p>
                                        <p class="text-sm text-slate-600">Email resmi Lapade</p>
                                    @else
                                        <p class="mt-2 text-lg font-semibold text-slate-900">Reservasi online</p>
                                        <p class="text-sm text-slate-600">Isi formulir pemesanan</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 rounded-3xl bg-white p-8 shadow-lg shadow-slate-900/5">
                            <h3 class="text-2xl font-bold text-slate-900">Galeri terbaru</h3>
                            @if($wisata->galeri->count())
                                <div class="mt-6 grid gap-4 md:grid-cols-2">
                                    <div class="overflow-hidden rounded-2xl">
                                        <img src="{{ Storage::url(optional($wisata->galeri->first())->path_file) }}" alt="{{ $namaWisata }}" class="h-64 w-full object-cover">
                                    </div>
                                    <div class="grid gap-4">
                                        @forelse($galleryImages as $galeri)
                                            <div class="overflow-hidden rounded-2xl">
                                                <img src="{{ Storage::url($galeri->path_file) }}" alt="{{ $namaWisata }}" class="h-40 w-full object-cover">
                                            </div>
                                        @empty
                                            <div class="rounded-2xl border border-dashed border-slate-200 p-6 text-center text-sm text-slate-500">
                                                Dokumentasi tambahan akan disertakan segera.
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            @else
                                <div class="mt-6 rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-8 text-center text-slate-500">
                                    Galeri belum tersedia. Informasi tiket dan kontak tetap bisa digunakan.
                                </div>
                            @endif
                        </div>
                    </div>
                    <div>
                        <div class="rounded-3xl bg-slate-900 p-8 text-white">
                            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-white/60">Informasi Harga</p>
                            <h3 class="mt-3 text-3xl font-bold">Tiket & fasilitas</h3>
                            <div class="mt-6 space-y-4">
                                @if(!is_null($hargaDewasa))
                                    <div class="rounded-2xl bg-white/10 p-4">
                                        <p class="text-sm text-white/70">Tiket dewasa</p>
                                        <p class="mt-2 text-3xl font-semibold">Rp {{ number_format($hargaDewasa, 0, ',', '.') }}</p>
                                    </div>
                                @endif
                                @if(!is_null($hargaAnak))
                                    <div class="rounded-2xl bg-white/10 p-4">
                                        <p class="text-sm text-white/70">Tiket anak</p>
                                        <p class="mt-2 text-3xl font-semibold">Rp {{ number_format($hargaAnak, 0, ',', '.') }}</p>
                                    </div>
                                @endif
                                <div class="rounded-2xl bg-white/10 p-4">
                                    <p class="text-sm text-white/70">Parkir motor</p>
                                    <p class="mt-2 text-3xl font-semibold">Rp {{ number_format($wisata->biaya_parkir_motor ?? 0, 0, ',', '.') }}</p>
                                </div>
                                <div class="rounded-2xl bg-white/10 p-4">
                                    <p class="text-sm text-white/70">Parkir mobil</p>
                                    <p class="mt-2 text-3xl font-semibold">Rp {{ number_format($wisata->biaya_parkir_mobil ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <a href="{{ route('pemesanan.create', $wisata->id) }}" class="mt-8 inline-flex w-full items-center justify-center rounded-2xl bg-sky-500 px-6 py-3 text-base font-semibold text-white hover:bg-sky-400">
                                Lanjut ke Form Pemesanan
                            </a>
                        </div>

                        <div class="mt-6 rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-6 text-sm text-slate-600">
                            <p class="font-semibold text-slate-900">Info pembayaran</p>
                            @if($wisata->nama_bank || $wisata->nomor_rekening || $wisata->atas_nama)
                                <ul class="mt-4 space-y-2">
                                    @if($wisata->nama_bank)
                                        <li>Bank: <span class="font-semibold text-slate-900">{{ $wisata->nama_bank }}</span></li>
                                    @endif
                                    @if($wisata->nomor_rekening)
                                        <li>No. Rekening: <span class="font-semibold text-slate-900">{{ $wisata->nomor_rekening }}</span></li>
                                    @endif
                                    @if($wisata->atas_nama)
                                        <li>Atas Nama: <span class="font-semibold text-slate-900">{{ $wisata->atas_nama }}</span></li>
                                    @endif
                                </ul>
                            @else
                                <p class="mt-4">Detail rekening belum tersedia. Mohon hubungi kontak resmi Lapade untuk konfirmasi.</p>
                            @endif
                            <p class="mt-4 text-xs text-slate-500">Simpan bukti transfer untuk divalidasi petugas Lapade.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
