@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-semibold mb-0">Laporan Penjualan Tiket</h5>
                    <a href="{{ route('admin.laporan.cetak-pdf', request()->all()) }}" class="btn btn-danger" target="_blank">
                        <i class="ti ti-file-type-pdf"></i> Cetak PDF
                    </a>
                </div>
                
                <div class="alert alert-info">
                    <i class="ti ti-info-circle me-2"></i>
                    <strong>Informasi:</strong> Laporan ini hanya menampilkan transaksi yang sudah diverifikasi oleh Bendahara.
                </div>

                <form method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">Tanggal Dari</label>
                            <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tanggal Sampai</label>
                            <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-light-success">
                            <div class="card-body">
                                <h6 class="fw-semibold">Total Pendapatan</h6>
                                <h2 class="fw-bold text-success">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light-primary">
                            <div class="card-body">
                                <h6 class="fw-semibold">Total Tiket Terjual</h6>
                                <h2 class="fw-bold text-primary">{{ $totalTiket }} Tiket</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kode Pemesanan</th>
                                <th>Nama Pemesan</th>
                                <th>Jumlah Tiket</th>
                                <th>Total Harga</th>
                                <th>Divalidasi Oleh</th>
                                <th>Diverifikasi Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pemesanan as $p)
                            <tr>
                                <td>{{ $p->tanggal_kunjungan->format('d/m/Y') }}</td>
                                <td>{{ $p->kode_pemesanan }}</td>
                                <td>{{ $p->nama_pemesan }}</td>
                                <td>{{ $p->jumlah_tiket }} orang</td>
                                <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                <td>{{ $p->validator->name ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="ti ti-check"></i> {{ $p->verifikatorBendahara->name ?? '-' }}
                                    </span>
                                    <br>
                                    <small class="text-muted">{{ $p->tanggal_verifikasi_bendahara ? $p->tanggal_verifikasi_bendahara->format('d/m/Y H:i') : '-' }}</small>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <i class="ti ti-inbox" style="font-size: 48px; opacity: 0.3;"></i>
                                    <p class="mt-2 mb-0">Belum ada transaksi yang diverifikasi oleh Bendahara</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="4" class="text-end">TOTAL:</td>
                                <td>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

               
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar, .app-header, .btn, form, .card-title { display: none !important; }
    .card { border: none !important; box-shadow: none !important; }
}
</style>
@endsection
