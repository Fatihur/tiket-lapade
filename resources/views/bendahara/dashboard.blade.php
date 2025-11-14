@extends('layouts.app')

@section('title', 'Dashboard Bendahara')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h5 class="card-title fw-semibold mb-4">Dashboard Bendahara</h5>
        
        <!-- Statistik Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-light-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-success text-white p-3 me-3">
                                <i class="ti ti-currency-dollar fs-6"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Pendapatan</h6>
                                <h4 class="mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary text-white p-3 me-3">
                                <i class="ti ti-file-invoice fs-6"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Transaksi</h6>
                                <h4 class="mb-0">{{ $totalTransaksi }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-info text-white p-3 me-3">
                                <i class="ti ti-circle-check fs-6"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Terverifikasi</h6>
                                <h4 class="mb-0">{{ $totalTerverifikasi }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-warning text-white p-3 me-3">
                                <i class="ti ti-clock fs-6"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Belum Verifikasi</h6>
                                <h4 class="mb-0">{{ $totalBelumVerifikasi }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

        <!-- Transaksi Terbaru -->
        <div class="card">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Transaksi Terbaru</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Pemesan</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksiTerbaru as $t)
                            <tr>
                                <td>{{ $t->kode_pemesanan }}</td>
                                <td>{{ $t->nama_pemesan }}</td>
                                <td>{{ $t->tanggal_kunjungan->format('d/m/Y') }}</td>
                                <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    @if($t->diverifikasi_bendahara)
                                        <span class="badge bg-success">Terverifikasi</span>
                                    @else
                                        <span class="badge bg-warning">Belum Verifikasi</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 text-center">
                    <a href="{{ route('bendahara.laporan') }}" class="btn btn-outline-primary">
                        Lihat Semua Laporan <i class="ti ti-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
