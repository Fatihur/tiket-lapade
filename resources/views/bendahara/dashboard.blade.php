@extends('layouts.app')

@section('title', 'Dashboard Bendahara')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Dashboard Bendahara</h5>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-light-success">
                            <div class="card-body">
                                <h6 class="fw-semibold">Total Pendapatan</h6>
                                <h2 class="fw-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light-primary">
                            <div class="card-body">
                                <h6 class="fw-semibold">Terverifikasi</h6>
                                <h2 class="fw-bold">{{ $totalTerverifikasi }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light-warning">
                            <div class="card-body">
                                <h6 class="fw-semibold">Belum Verifikasi</h6>
                                <h2 class="fw-bold">{{ $totalBelumVerifikasi }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}" placeholder="Dari Tanggal">
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}" placeholder="Sampai Tanggal">
                        </div>
                        <div class="col-md-3">
                            <select name="status_verifikasi" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="terverifikasi" {{ request('status_verifikasi') == 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="belum_verifikasi" {{ request('status_verifikasi') == 'belum_verifikasi' ? 'selected' : '' }}>Belum Verifikasi</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('bendahara.dashboard') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>

                <h6 class="fw-semibold mb-3">Laporan Transaksi Valid</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Pemesan</th>
                                <th>Tanggal Kunjungan</th>
                                <th>Jumlah Tiket</th>
                                <th>Total</th>
                                <th>Divalidasi Oleh</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pemesanan as $p)
                            <tr>
                                <td>{{ $p->kode_pemesanan }}</td>
                                <td>{{ $p->nama_pemesan }}</td>
                                <td>{{ $p->tanggal_kunjungan->format('d/m/Y') }}</td>
                                <td>{{ $p->jumlah_tiket }} orang</td>
                                <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                <td>{{ $p->validator->name ?? '-' }}</td>
                                <td>
                                    @if($p->diverifikasi_bendahara)
                                        <span class="badge bg-success">
                                            <i class="ti ti-check"></i> Terverifikasi
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            {{ $p->verifikatorBendahara->name ?? '-' }}<br>
                                            {{ $p->tanggal_verifikasi_bendahara ? $p->tanggal_verifikasi_bendahara->format('d/m/Y H:i') : '-' }}
                                        </small>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="ti ti-clock"></i> Belum Verifikasi
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$p->diverifikasi_bendahara)
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalVerifikasi{{ $p->id }}">
                                            <i class="ti ti-check"></i> Verifikasi
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $p->id }}">
                                            <i class="ti ti-eye"></i> Detail
                                        </button>
                                        <form action="{{ route('bendahara.batal-verifikasi', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Batalkan verifikasi?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning">
                                                <i class="ti ti-x"></i> Batal
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal Verifikasi -->
                            <div class="modal fade" id="modalVerifikasi{{ $p->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Verifikasi Laporan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('bendahara.verifikasi', $p->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td width="40%">Kode Pemesanan</td>
                                                        <td>: {{ $p->kode_pemesanan }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama Pemesan</td>
                                                        <td>: {{ $p->nama_pemesan }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jumlah Tiket</td>
                                                        <td>: {{ $p->jumlah_tiket }} orang</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Pembayaran</td>
                                                        <td>: Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                                    </tr>
                                                </table>
                                                <div class="mb-3">
                                                    <label class="form-label">Catatan (Opsional)</label>
                                                    <textarea name="catatan_bendahara" class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">Verifikasi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Detail -->
                            <div class="modal fade" id="modalDetail{{ $p->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title">Detail Verifikasi</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td width="40%">Kode Pemesanan</td>
                                                    <td>: {{ $p->kode_pemesanan }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Total Pembayaran</td>
                                                    <td>: Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Diverifikasi Oleh</td>
                                                    <td>: {{ $p->verifikatorBendahara->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal Verifikasi</td>
                                                    <td>: {{ $p->tanggal_verifikasi_bendahara ? $p->tanggal_verifikasi_bendahara->format('d/m/Y H:i') : '-' }}</td>
                                                </tr>
                                                @if($p->catatan_bendahara)
                                                <tr>
                                                    <td>Catatan</td>
                                                    <td>: {{ $p->catatan_bendahara }}</td>
                                                </tr>
                                                @endif
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $pemesanan->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
