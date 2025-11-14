@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Dashboard Admin</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="card bg-light-primary">
                            <div class="card-body">
                                <h6 class="fw-semibold">Total Pemesanan</h6>
                                <h2 class="fw-bold">{{ $totalPemesanan }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light-warning">
                            <div class="card-body">
                                <h6 class="fw-semibold">Menunggu Validasi</h6>
                                <h2 class="fw-bold">{{ $pemesananMenunggu }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light-success">
                            <div class="card-body">
                                <h6 class="fw-semibold">Pemesanan Valid</h6>
                                <h2 class="fw-bold">{{ $pemesananValid }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light-info">
                            <div class="card-body">
                                <h6 class="fw-semibold">Total Pendapatan</h6>
                                <h2 class="fw-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h5 class="card-title fw-semibold mb-3">Pemesanan Terbaru</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Pemesan</th>
                                    <th>Wisata</th>
                                    <th>Tanggal Kunjungan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pemesananTerbaru as $p)
                                <tr>
                                    <td>{{ $p->kode_pemesanan }}</td>
                                    <td>{{ $p->nama_pemesan }}</td>
                                    <td>Wisata Lapade</td>
                                    <td>{{ $p->tanggal_kunjungan->format('d/m/Y') }}</td>
                                    <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        @if($p->status_pembayaran == 'menunggu')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif($p->status_pembayaran == 'valid')
                                            <span class="badge bg-success">Valid</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Valid</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.transaksi.show', $p->id) }}" class="btn btn-sm btn-primary">Detail</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada pemesanan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
