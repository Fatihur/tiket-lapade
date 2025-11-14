@extends('layouts.app')

@section('title', 'Riwayat Scan Tiket')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-semibold mb-0">Riwayat Scan Tiket</h5>
                    <a href="{{ route('petugas.scan') }}" class="btn btn-primary">
                        <i class="ti ti-qrcode"></i> Scan Tiket
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal Scan</th>
                                <th>Kode Tiket</th>
                                <th>Nama Pemesan</th>
                                <th>Wisata</th>
                                <th>Tanggal Kunjungan</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $tiket)
                                <tr>
                                    <td>{{ $tiket->tanggal_scan ? \Carbon\Carbon::parse($tiket->tanggal_scan)->format('d/m/Y H:i') : '-' }}</td>
                                    <td>
                                        <strong>{{ $tiket->kode_tiket }}</strong>
                                    </td>
                                    <td>{{ $tiket->pemesanan->nama_pemesan }}</td>
                                    <td>Wisata Lapade</td>
                                    <td>{{ \Carbon\Carbon::parse($tiket->pemesanan->tanggal_kunjungan)->format('d/m/Y') }}</td>
                                    <td>
                                        {{ $tiket->pemesanan->jumlah_tiket_dewasa }} Dewasa
                                        @if($tiket->pemesanan->jumlah_tiket_anak > 0)
                                            , {{ $tiket->pemesanan->jumlah_tiket_anak }} Anak
                                        @endif
                                    </td>
                                    <td>
                                        @if($tiket->sudah_digunakan)
                                            <span class="badge bg-success">Tervalidasi</span>
                                        @else
                                            <span class="badge bg-secondary">Belum Digunakan</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="ti ti-inbox" style="font-size: 48px; opacity: 0.3;"></i>
                                        <p class="mt-2 mb-0">Belum ada riwayat scan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($riwayat->hasPages())
                    <div class="mt-4">
                        {{ $riwayat->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Statistik Scan Hari Ini</h5>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary-subtle text-primary p-3 me-3">
                                <i class="ti ti-check fs-6"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Scan</h6>
                                <h4 class="mb-0">{{ $totalScanHariIni ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-success-subtle text-success p-3 me-3">
                                <i class="ti ti-circle-check fs-6"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Valid</h6>
                                <h4 class="mb-0">{{ $validHariIni ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-info-subtle text-info p-3 me-3">
                                <i class="ti ti-user fs-6"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Pengunjung</h6>
                                <h4 class="mb-0">{{ $totalScanHariIni ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
