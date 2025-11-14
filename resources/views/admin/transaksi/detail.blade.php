@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Detail Transaksi</h5>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-semibold">Informasi Pemesanan</h6>
                        <table class="table">
                            <tr>
                                <td width="200">Kode Pemesanan</td>
                                <td>: {{ $pemesanan->kode_pemesanan }}</td>
                            </tr>
                            <tr>
                                <td>Nama Pemesan</td>
                                <td>: {{ $pemesanan->nama_pemesan }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>: {{ $pemesanan->email_pemesan }}</td>
                            </tr>
                            <tr>
                                <td>WhatsApp</td>
                                <td>: {{ $pemesanan->nomor_whatsapp }}</td>
                            </tr>
                            <tr>
                                <td>Wisata</td>
                                <td>: Wisata Lapade</td>
                            </tr>
                            <tr>
                                <td>Tanggal Kunjungan</td>
                                <td>: {{ $pemesanan->tanggal_kunjungan->format('d/m/Y') }}</td>
                            </tr>
                        </table>

                        <h6 class="fw-semibold mt-4">Detail Tiket</h6>
                        <table class="table">
                            <tr>
                                <td width="200">Jumlah Tiket</td>
                                <td>: {{ $pemesanan->jumlah_tiket }} tiket</td>
                            </tr>
                            @if($pemesanan->jumlah_parkir_motor > 0)
                            <tr>
                                <td>Parkir Motor</td>
                                <td>: {{ $pemesanan->jumlah_parkir_motor }} unit</td>
                            </tr>
                            @endif
                            @if($pemesanan->jumlah_parkir_mobil > 0)
                            <tr>
                                <td>Parkir Mobil</td>
                                <td>: {{ $pemesanan->jumlah_parkir_mobil }} unit</td>
                            </tr>
                            @endif
                            <tr class="fw-bold">
                                <td>Total</td>
                                <td>: Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h6 class="fw-semibold">Bukti Transfer</h6>
                        @if($pemesanan->bukti_transfer)
                            <img src="{{ Storage::url($pemesanan->bukti_transfer) }}" 
                                 alt="Bukti Transfer" 
                                 class="img-fluid rounded mb-3"
                                 style="max-height: 400px; cursor: pointer;"
                                 onclick="window.open(this.src, '_blank')">
                            <p class="text-muted small">
                                <i class="ti ti-info-circle"></i> Klik gambar untuk melihat ukuran penuh
                            </p>
                        @endif

                        <h6 class="fw-semibold mt-4">Status Pembayaran</h6>
                        <p>
                            @if($pemesanan->status_pembayaran == 'menunggu')
                                <span class="badge bg-warning fs-4">Menunggu Validasi</span>
                            @elseif($pemesanan->status_pembayaran == 'valid')
                                <span class="badge bg-success fs-4">Valid</span>
                            @else
                                <span class="badge bg-danger fs-4">Tidak Valid</span>
                            @endif
                        </p>

                        @if($pemesanan->validator)
                            <p class="mb-1"><strong>Divalidasi oleh:</strong> {{ $pemesanan->validator->name }}</p>
                            <p><strong>Tanggal Validasi:</strong> {{ $pemesanan->tanggal_validasi->format('d/m/Y H:i') }}</p>
                        @endif

                        @if($pemesanan->catatan_admin)
                            <div class="alert alert-info">
                                <strong>Catatan Admin:</strong><br>
                                {{ $pemesanan->catatan_admin }}
                            </div>
                        @endif

                        @if($pemesanan->status_pembayaran == 'menunggu')
                            <form action="{{ route('admin.transaksi.validasi', $pemesanan->id) }}" method="POST" class="mt-4">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Status Validasi</label>
                                    <select name="status_pembayaran" class="form-select" required>
                                        <option value="">Pilih Status</option>
                                        <option value="valid">Valid</option>
                                        <option value="tidak_valid">Tidak Valid</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Catatan (Opsional)</label>
                                    <textarea name="catatan_admin" class="form-control" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Validasi Pembayaran</button>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
