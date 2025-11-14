@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Daftar Transaksi Pemesanan</h5>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="valid" {{ request('status') == 'valid' ? 'selected' : '' }}>Valid</option>
                                <option value="tidak_valid" {{ request('status') == 'tidak_valid' ? 'selected' : '' }}>Tidak Valid</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}" placeholder="Dari Tanggal">
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}" placeholder="Sampai Tanggal">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>

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
                            @forelse($pemesanan as $p)
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
                                <td colspan="7" class="text-center">Tidak ada data</td>
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
