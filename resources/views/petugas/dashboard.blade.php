@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Dashboard Petugas Tiket</h5>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-light-primary">
                            <div class="card-body">
                                <h6 class="fw-semibold">Total Scan Hari Ini</h6>
                                <h2 class="fw-bold">{{ $totalScanHariIni }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light-success">
                            <div class="card-body text-center">
                                <a href="{{ route('petugas.scan') }}" class="btn btn-success btn-lg">
                                    <i class="ti ti-qrcode"></i> Scan Tiket
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <h6 class="fw-semibold mb-3">Riwayat Scan Terbaru</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kode Tiket</th>
                                <th>Nama Pemesan</th>
                             <th>Jumlah Pengunjung</th>
                             <th>Total Bayar</th>
                                <th>Waktu Scan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tiketDiscan as $tiket)
                            <tr>
                                <td>{{ $tiket->kode_tiket }}</td>
                                
                                <td>{{ $tiket->pemesanan->nama_pemesan }}</td>
                               <td>{{ $tiket->pemesanan->jumlah_tiket }}</td>
                                 <td>{{ $tiket->pemesanan->total_harga }}</td>
                                <td>{{ $tiket->tanggal_scan->format('d/m/Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada tiket yang discan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <a href="{{ route('petugas.riwayat') }}" class="btn btn-outline-primary">Lihat Semua Riwayat</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
