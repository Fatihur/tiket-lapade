@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Laporan Penjualan Tiket</h5>

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
                            <label class="form-label">Wisata</label>
                            <select name="wisata_id" class="form-select">
                                <option value="">Semua Wisata</option>
                                @foreach($wisata as $w)
                                    <option value="{{ $w->id }}" {{ request('wisata_id') == $w->id ? 'selected' : '' }}>
                                        {{ $w->nama_wisata }}
                                    </option>
                                @endforeach
                            </select>
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
                                <th>Wisata</th>
                                <th>Tiket Dewasa</th>
                                <th>Tiket Anak</th>
                                <th>Total Harga</th>
                                <th>Divalidasi Oleh</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pemesanan as $p)
                            <tr>
                                <td>{{ $p->tanggal_kunjungan->format('d/m/Y') }}</td>
                                <td>{{ $p->kode_pemesanan }}</td>
                                <td>{{ $p->nama_pemesan }}</td>
                                <td>{{ $p->wisata->nama_wisata }}</td>
                                <td>{{ $p->jumlah_tiket_dewasa }}</td>
                                <td>{{ $p->jumlah_tiket_anak }}</td>
                                <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                <td>{{ $p->validator->name ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="6" class="text-end">TOTAL:</td>
                                <td>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($pemesanan->count() > 0)
                <div class="mt-3">
                    <button onclick="window.print()" class="btn btn-success">
                        <i class="ti ti-printer"></i> Cetak Laporan
                    </button>
                </div>
                @endif
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
