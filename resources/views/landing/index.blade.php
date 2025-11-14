<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapade Adventure Pass | Pemesanan Tiket Wisata</title>
    <meta name="description" content="Pesan tiket resmi Wisata Lapade di Utan, Kabupaten Sumbawa, Nusa Tenggara Barat.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 antialiased scroll-smooth">
    @php
        $namaWisata = $wisata->nama_wisata ?? 'Wisata Lapade';
        $heroImagePath = optional($wisata->galeri->first())->path_file;
        $galleryImages = $wisata->galeri->take(5);
        $whatsappNumber = $wisata->nomor_whatsapp ? preg_replace('/[^0-9]/', '', $wisata->nomor_whatsapp) : null;
        $hargaDewasa = $wisata->harga_tiket_dewasa ?? $wisata->harga_tiket;
        $hargaAnak = $wisata->harga_tiket_anak ?? null;
    @endphp

    <div class="flex min-h-screen flex-col">
        <header class="relative isolate ">
            <nav class="fixed inset-x-0 top-0 z-30 bg-white/90 backdrop-blur">
                <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
                    <div class="flex items-center gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Lapade</p>
                        </div>
                    </div>
                    <div class="hidden items-center gap-6 text-sm font-medium text-slate-700 md:flex">
                        <a href="#harga" class="hover:text-sky-600">Harga</a>
                        <a href="#cara-pesan" class="hover:text-sky-600">Cara Pesan</a>
                        <a href="#kontak" class="hover:text-sky-600">Kontak</a>
                        <a href="{{ route('login') }}" class="rounded-full border border-slate-200 px-4 py-2 hover:border-sky-500 hover:text-sky-600">Login</a>
                    </div>
                    <div class="md:hidden">
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-sky-700">Login</a>
                    </div>
                </div>
            </nav>

            <section class="relative isolate overflow-hidden pt-32 pb-24">
                <div class="absolute inset-0">
                    @if($heroImagePath)
                        <img src="{{ asset('storage/' . $heroImagePath) }}" alt="{{ $namaWisata }}" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-slate-900/70"></div>
                    @else
                        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-sky-900 to-emerald-800"></div>
                        <div class="absolute inset-0 bg-slate-900/60"></div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-slate-900/20"></div>
                </div>

                <div class="relative z-10 mx-auto max-w-4xl px-4 text-center text-white">
                    <p class="mb-4 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1 text-sm font-medium">
                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                         Wisata Lapade - Utan, Kabupaten Sumbawa
                    </p>
                    <h1 class="text-4xl font-semibold leading-tight md:text-5xl">{{ $namaWisata }}</h1>
                    <p class="mt-6 text-lg text-white/80">
                        {{ $wisata->deskripsi ?: 'Kunjungi destinasi alam unggulan di Utan, Kecamatan Sumbawa, Nusa Tenggara Barat, dan pesan tiket resminya secara online.' }}
                    </p>
                    <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                        <a href="{{ route('pemesanan.create', $wisata->id) }}" class="inline-flex items-center justify-center rounded-full bg-sky-500 px-8 py-3 text-base font-semibold text-white shadow-lg shadow-sky-900/30 hover:bg-sky-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-white">
                            Pesan Tiket Sekarang
                        </a>
                       
                    </div>

                   
                </div>
            </section>
        </header>

        <main class="flex-1">

            <section class="bg-white py-16">
                <div class="mx-auto max-w-6xl px-4">
                    <div class="grid gap-10 lg:grid-cols-3">
                        <div class="rounded-3xl bg-slate-900 p-8 text-white lg:col-span-2">
                            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-white/70">Mengapa Memesan di Sini</p>
                            <h3 class="mt-3 text-3xl font-bold">Platform booking tiket wisata Lapade</h3>
                            <p class="mt-4 text-white/80">Reservasi terhubung langsung dengan pengelola Lapade di Utan sehingga kuota pengunjung, bukti pembayaran, dan data tiket selalu tervalidasi.</p>
                            <div class="mt-8 grid gap-6 md:grid-cols-3">
                                <div class="rounded-2xl bg-white/10 p-5">
                                    <p class="text-sm text-white/70">Kuota terkini</p>
                                    <p class="mt-2 text-lg font-semibold">Sesuai data lapangan</p>
                                </div>
                                <div class="rounded-2xl bg-white/10 p-5">
                                    <p class="text-sm text-white/70">Pembayaran aman</p>
                                    <p class="mt-2 text-lg font-semibold">Transfer rekening resmi</p>
                                </div>
                                <div class="rounded-2xl bg-white/10 p-5">
                                    <p class="text-sm text-white/70">Tiket digital</p>
                                    <p class="mt-2 text-lg font-semibold">QR siap dipindai</p>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-3xl border border-slate-100 bg-slate-50 p-8">
                            <h3 class="text-xl font-semibold text-slate-900">Informasi penting</h3>
                            <ul class="mt-6 space-y-4 text-sm text-slate-600">
                                <li class="flex gap-3">
                                    <span class="mt-1 h-2.5 w-2.5 rounded-full bg-sky-500"></span>
                                    Pemesanan berlaku untuk destinasi Lapade di Utan, Kecamatan Sumbawa, Nusa Tenggara Barat.
                                </li>
                                <li class="flex gap-3">
                                    <span class="mt-1 h-2.5 w-2.5 rounded-full bg-sky-500"></span>
                                    Tiket diterbitkan dalam bentuk kode QR untuk dipindai petugas.
                                </li>
                                <li class="flex gap-3">
                                    <span class="mt-1 h-2.5 w-2.5 rounded-full bg-sky-500"></span>
                                    Kontak yang tercantum pada halaman ini adalah kontak resmi Lapade.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <section id="harga" class="mx-auto max-w-6xl px-4 py-16">
                <div class="grid gap-8 lg:grid-cols-2">
                    <div class="rounded-3xl bg-white p-8 shadow-lg shadow-slate-900/5">
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-500">Informasi Harga</p>
                        <h3 class="mt-3 text-3xl font-bold text-slate-900">Tiket dan parkir</h3>
                        <p class="mt-3 text-slate-600">Seluruh harga bersumber langsung dari data pengelola Lapade dan otomatis tertera di tiket digital Anda.</p>
                        <div class="mt-8 grid gap-4 md:grid-cols-2">
                            @if(!is_null($hargaDewasa))
                                <div class="rounded-2xl border border-slate-100 p-5">
                                    <p class="text-sm font-medium text-slate-500">Tiket </p>
                                    <p class="mt-2 text-3xl font-semibold text-slate-900">Rp {{ number_format($hargaDewasa, 0, ',', '.') }}</p>
                                    <p class="mt-2 text-sm text-slate-500">per orang</p>
                                </div>
                            @endif
                           
                            <div class="rounded-2xl border border-slate-100 p-5">
                                <p class="text-sm font-medium text-slate-500">Parkir motor</p>
                                <p class="mt-2 text-3xl font-semibold text-slate-900">Rp {{ number_format($wisata->biaya_parkir_motor ?? 0, 0, ',', '.') }}</p>
                                <p class="mt-2 text-sm text-slate-500">per kendaraan</p>
                            </div>
                            <div class="rounded-2xl border border-slate-100 p-5">
                                <p class="text-sm font-medium text-slate-500">Parkir mobil</p>
                                <p class="mt-2 text-3xl font-semibold text-slate-900">Rp {{ number_format($wisata->biaya_parkir_mobil ?? 0, 0, ',', '.') }}</p>
                                <p class="mt-2 text-sm text-slate-500">per kendaraan</p>
                            </div>
                        </div>
                        <a href="{{ route('pemesanan.create', $wisata->id) }}" class="mt-8 inline-flex w-full items-center justify-center rounded-2xl bg-sky-500 px-6 py-4 text-base font-semibold text-white hover:bg-sky-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-200">
                            Pilih tanggal dan pesan tiket
                        </a>
                    </div>
                    <div class="grid gap-8">
                        <div class="rounded-3xl bg-slate-900 p-8 text-white">
                            <h4 class="text-2xl font-semibold">Apa yang Anda dapatkan</h4>
                            <ul class="mt-6 space-y-4 text-sm text-white/80">
                                <li class="flex gap-3">
                                    <span class="mt-1 h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                                    Bukti pembayaran resmi beserta QR code tiket.
                                </li>
                                <li class="flex gap-3">
                                    <span class="mt-1 h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                                    Dukungan petugas Lapade apabila terjadi kendala saat check-in.
                                </li>
                                <li class="flex gap-3">
                                    <span class="mt-1 h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                                    Informasi terkini terkait kondisi Lapade sebelum kunjungan.
                                </li>
                            </ul>
                        </div>
                        <div class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-8">
                            <h4 class="text-xl font-semibold text-slate-900">Catatan pengunjung</h4>
                            <p class="mt-3 text-sm text-slate-600">Pastikan data pengunjung sesuai identitas agar proses pemindaian tiket di pintu masuk berjalan lancar.</p>
                            <p class="mt-3 text-sm text-slate-500">Lapade melayani rombongan keluarga, pelajar, dan wisatawan umum dengan kuota menyesuaikan kondisi lapangan.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="cara-pesan" class="bg-gradient-to-b from-slate-900 to-slate-800 py-16 text-white">
                <div class="mx-auto max-w-6xl px-4">
                    <div class="mb-10 text-center">
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-white/60">Cara Pesan</p>
                        <h3 class="mt-3 text-3xl font-bold">Tiga langkah mudah menuju Lapade</h3>
                    </div>
                    <div class="grid gap-6 md:grid-cols-3">
                        <div class="rounded-3xl bg-white/5 p-6">
                            <p class="text-sm uppercase tracking-wide text-white/60">Langkah 1</p>
                            <h4 class="mt-3 text-xl font-semibold">Pilih tanggal dan paket</h4>
                            <p class="mt-2 text-sm text-white/80">Masukkan jumlah tiket dewasa maupun anak lalu pastikan data pengunjung sesuai.</p>
                        </div>
                        <div class="rounded-3xl bg-white/5 p-6">
                            <p class="text-sm uppercase tracking-wide text-white/60">Langkah 2</p>
                            <h4 class="mt-3 text-xl font-semibold">Lakukan pembayaran</h4>
                            <p class="mt-2 text-sm text-white/80">Transfer ke rekening resmi Lapade sesuai nominal total pemesanan.</p>
                        </div>
                        <div class="rounded-3xl bg-white/5 p-6">
                            <p class="text-sm uppercase tracking-wide text-white/60">Langkah 3</p>
                            <h4 class="mt-3 text-xl font-semibold">Terima tiket digital</h4>
                            <p class="mt-2 text-sm text-white/80">QR code otomatis dikirim via email dan WhatsApp untuk ditunjukkan ke petugas.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="kontak" class="mx-auto max-w-6xl px-4 py-16">
                <div class="grid gap-8 lg:grid-cols-2">
                    <div class="rounded-3xl bg-white p-8 shadow-lg shadow-slate-900/5">
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-500">Kontak Resmi</p>
                        <h3 class="mt-3 text-3xl font-bold text-slate-900">Butuh bantuan?</h3>
                        <p class="mt-3 text-slate-600">Tim Lapade siap membantu melalui kanal komunikasi berikut.</p>
                        <dl class="mt-8 space-y-5 text-sm">
                            @if($wisata->nomor_whatsapp)
                                <div class="flex items-start gap-4 rounded-2xl border border-slate-100 p-4">
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">WhatsApp</span>
                                    <div>
                                        <dt class="text-base font-semibold text-slate-900">{{ $wisata->nomor_whatsapp }}</dt>
                                        <dd class="mt-1 text-slate-600">
                                            <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener" class="text-sky-600 hover:text-sky-500">Chat sekarang</a>
                                        </dd>
                                    </div>
                                </div>
                            @endif
                            @if($wisata->email_kontak)
                                <div class="flex items-start gap-4 rounded-2xl border border-slate-100 p-4">
                                    <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">Email</span>
                                    <div>
                                        <dt class="text-base font-semibold text-slate-900">{{ $wisata->email_kontak }}</dt>
                                        <dd class="mt-1 text-slate-600">Kirim bukti pembayaran atau pertanyaan terkait kunjungan.</dd>
                                    </div>
                                </div>
                            @endif
                            <div class="flex items-start gap-4 rounded-2xl border border-slate-100 p-4">
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">Lokasi</span>
                                <div>
                                    <dt class="text-base font-semibold text-slate-900">Desa Lapade, Kecamatan Utan</dt>
                                    <dd class="mt-1 text-slate-600">Kabupaten Sumbawa, Nusa Tenggara Barat</dd>
                                </div>
                            </div>
                        </dl>
                    </div>
                    <div class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-8">
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-500">Informasi Pembayaran</p>
                        <h3 class="mt-3 text-2xl font-bold text-slate-900">Rekening resmi Lapade</h3>
                        @if($wisata->nama_bank || $wisata->nomor_rekening)
                            <div class="mt-6 space-y-4 rounded-2xl bg-white p-6 shadow-sm">
                                @if($wisata->nama_bank)
                                    <div>
                                        <p class="text-xs uppercase tracking-wide text-slate-500">Bank</p>
                                        <p class="text-lg font-semibold text-slate-900">{{ $wisata->nama_bank }}</p>
                                    </div>
                                @endif
                                @if($wisata->nomor_rekening)
                                    <div>
                                        <p class="text-xs uppercase tracking-wide text-slate-500">Nomor rekening</p>
                                        <p class="text-lg font-semibold text-slate-900">{{ $wisata->nomor_rekening }}</p>
                                    </div>
                                @endif
                                @if($wisata->atas_nama)
                                    <div>
                                        <p class="text-xs uppercase tracking-wide text-slate-500">Atas nama</p>
                                        <p class="text-lg font-semibold text-slate-900">{{ $wisata->atas_nama }}</p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <p class="mt-6 text-sm text-slate-600">Data rekening belum tersedia di sistem. Silakan hubungi kontak resmi untuk konfirmasi pembayaran.</p>
                        @endif
                        <p class="mt-6 text-sm text-slate-500">Simpan bukti transfer untuk diverifikasi petugas Lapade. Proses validasi memerlukan waktu maksimal 10 menit pada jam operasional.</p>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-slate-100 bg-white py-8">
            <div class="mx-auto flex max-w-6xl flex-col gap-4 px-4 text-center text-sm text-slate-500 md:flex-row md:items-center md:justify-between">
                <p>&copy; {{ date('Y') }} Lapade - Utan, Kabupaten Sumbawa, Nusa Tenggara Barat.</p>
                <p>Halaman pemesanan resmi destinasi wisata Lapade.</p>
            </div>
        </footer>
    </div>

    <a href="{{ route('pemesanan.create', $wisata->id) }}" class="fixed bottom-6 right-4 inline-flex items-center gap-2 rounded-full bg-sky-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-900/20 hover:bg-sky-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-200" aria-label="Pesan tiket Lapade sekarang">
        <span>Pesan Tiket</span>
    </a>
</body>
</html>
