@extends('layouts.app')

@section('title', 'Laporan & Verifikasi Transaksi')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title fw-semibold mb-0">Laporan & Verifikasi Transaksi</h5>
            
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistik -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-light-success">
                    <div class="card-body">
                        <h6 class="fw-semibold">Total Pendapatan</h6>
                        <h3 class="fw-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light-info">
                    <div class="card-body">
                        <h6 class="fw-semibold">Terverifikasi</h6>
                        <h3 class="fw-bold">{{ $totalTerverifikasi }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light-warning">
                    <div class="card-body">
                        <h6 class="fw-semibold">Belum Verifikasi</h6>
                        <h3 class="fw-bold">{{ $totalBelumVerifikasi }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status Verifikasi</label>
                            <select name="status_verifikasi" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="terverifikasi" {{ request('status_verifikasi') == 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="belum_verifikasi" {{ request('status_verifikasi') == 'belum_verifikasi' ? 'selected' : '' }}>Belum Verifikasi</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('bendahara.laporan') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Transaksi -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-semibold mb-0">Daftar Transaksi</h6>
                    <div>
                        <button type="button" class="btn btn-success btn-sm" id="btnVerifikasiBulk" style="display:none;">
                            <i class="ti ti-check"></i> Verifikasi Terpilih (<span id="countSelected">0</span>)
                        </button>
                    </div>
                </div>
                
                <form id="formBulkVerifikasi" action="{{ route('bendahara.laporan.bulk-verifikasi') }}" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="30">
                                        <input type="checkbox" class="form-check-input" id="checkAll">
                                    </th>
                                    <th>Kode</th>
                                    <th>Nama Pemesan</th>
                                    <th>Wisata</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pemesanan as $p)
                                <tr class="{{ !$p->diverifikasi_bendahara ? 'table-warning-subtle' : '' }}">
                                    <td>
                                        @if(!$p->diverifikasi_bendahara)
                                            <input type="checkbox" class="form-check-input check-item" name="pemesanan_ids[]" value="{{ $p->id }}">
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $p->kode_pemesanan }}</strong>
                                    </td>
                                    <td>
                                        {{ $p->nama_pemesan }}
                                        <br><small class="text-muted">{{ $p->email_pemesan }}</small>
                                    </td>
                                    <td>{{ $wisata->nama ?? '-' }}</td>
                                    <td>{{ $p->tanggal_kunjungan->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $p->jumlah_tiket }} orang</span>
                                    </td>
                                    <td>
                                        <strong class="text-success">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        @if($p->diverifikasi_bendahara)
                                            <span class="badge bg-success">
                                                <i class="ti ti-check"></i> Terverifikasi
                                            </span>
                                            <br><small class="text-muted">{{ $p->verifikatorBendahara->name ?? '-' }}</small>
                                            <br><small class="text-muted">{{ $p->tanggal_verifikasi_bendahara ? $p->tanggal_verifikasi_bendahara->format('d/m/Y H:i') : '' }}</small>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                <i class="ti ti-clock"></i> Belum Verifikasi
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$p->diverifikasi_bendahara)
                                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal{{ $p->id }}">
                                                <i class="ti ti-check"></i> Verifikasi
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detail{{ $p->id }}">
                                                <i class="ti ti-eye"></i> Detail
                                            </button>
                                            <form action="{{ route('bendahara.laporan.batal-verifikasi', $p->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Batalkan verifikasi transaksi ini?')">
                                                    <i class="ti ti-x"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <i class="ti ti-inbox" style="font-size: 48px; opacity: 0.3;"></i>
                                        <p class="text-muted mt-2">Tidak ada data transaksi</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </form>

                <!-- Modals untuk setiap transaksi -->
                @foreach($pemesanan as $p)
                    <!-- Modal Verifikasi -->
                    <div class="modal fade" id="modal{{ $p->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Verifikasi Laporan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('bendahara.laporan.verifikasi', $p->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%">Kode</td>
                                                <td>: {{ $p->kode_pemesanan }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nama</td>
                                                <td>: {{ $p->nama_pemesan }}</td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah</td>
                                                <td>: {{ $p->jumlah_tiket }} orang</td>
                                            </tr>
                                            <tr>
                                                <td>Total</td>
                                                <td>: Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                            </tr>
                                        </table>
                                        <div class="mb-3">
                                            <label class="form-label">Catatan (Opsional)</label>
                                            <textarea name="catatan_bendahara" class="form-control" rows="3" placeholder="Tambahkan catatan verifikasi..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="ti ti-check"></i> Verifikasi
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Detail -->
                    <div class="modal fade" id="detail{{ $p->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title">
                                        <i class="ti ti-check-circle"></i> Detail Verifikasi
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="40%"><strong>Kode</strong></td>
                                            <td>: {{ $p->kode_pemesanan }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nama Pemesan</strong></td>
                                            <td>: {{ $p->nama_pemesan }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email</strong></td>
                                            <td>: {{ $p->email_pemesan }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Jumlah Tiket</strong></td>
                                            <td>: {{ $p->jumlah_tiket }} orang</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total</strong></td>
                                            <td>: <strong class="text-success">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><hr></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Diverifikasi Oleh</strong></td>
                                            <td>: {{ $p->verifikatorBendahara->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal Verifikasi</strong></td>
                                            <td>: {{ $p->tanggal_verifikasi_bendahara ? $p->tanggal_verifikasi_bendahara->format('d/m/Y H:i') : '-' }}</td>
                                        </tr>
                                        @if($p->catatan_bendahara)
                                        <tr>
                                            <td><strong>Catatan</strong></td>
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
                @endforeach

                @if($pemesanan->hasPages())
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Menampilkan {{ $pemesanan->firstItem() }} - {{ $pemesanan->lastItem() }} dari {{ $pemesanan->total() }} transaksi
                    </div>
                    <div>
                        {{ $pemesanan->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Bulk Verifikasi -->
<div class="modal fade" id="modalBulkVerifikasi">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="ti ti-check"></i> Verifikasi Transaksi Terpilih
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="ti ti-info-circle"></i>
                    Anda akan memverifikasi <strong><span id="bulkCount">0</span> transaksi</strong> sekaligus.
                </div>
                <div class="mb-3">
                    <label class="form-label">Catatan (Opsional)</label>
                    <textarea name="catatan_bendahara_bulk" class="form-control" rows="3" placeholder="Tambahkan catatan untuk semua transaksi yang dipilih..."></textarea>
                </div>
                <p class="text-muted small mb-0">
                    <i class="ti ti-alert-circle"></i> Pastikan data sudah benar sebelum melakukan verifikasi.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="btnKonfirmasiBulk">
                    <i class="ti ti-check"></i> Verifikasi Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkAll = document.getElementById('checkAll');
    const checkItems = document.querySelectorAll('.check-item');
    const btnVerifikasiBulk = document.getElementById('btnVerifikasiBulk');
    const countSelected = document.getElementById('countSelected');
    const formBulk = document.getElementById('formBulkVerifikasi');
    const modalBulk = new bootstrap.Modal(document.getElementById('modalBulkVerifikasi'));
    const bulkCount = document.getElementById('bulkCount');
    const btnKonfirmasiBulk = document.getElementById('btnKonfirmasiBulk');

    // Check All
    checkAll?.addEventListener('change', function() {
        checkItems.forEach(item => {
            item.checked = this.checked;
        });
        updateBulkButton();
    });

    // Check Items
    checkItems.forEach(item => {
        item.addEventListener('change', function() {
            updateCheckAll();
            updateBulkButton();
        });
    });

    // Update Check All status
    function updateCheckAll() {
        if (checkAll) {
            const totalChecked = document.querySelectorAll('.check-item:checked').length;
            checkAll.checked = totalChecked === checkItems.length && checkItems.length > 0;
            checkAll.indeterminate = totalChecked > 0 && totalChecked < checkItems.length;
        }
    }

    // Update Bulk Button
    function updateBulkButton() {
        const totalChecked = document.querySelectorAll('.check-item:checked').length;
        if (totalChecked > 0) {
            btnVerifikasiBulk.style.display = 'inline-block';
            countSelected.textContent = totalChecked;
        } else {
            btnVerifikasiBulk.style.display = 'none';
        }
    }

    // Show Modal Bulk
    btnVerifikasiBulk?.addEventListener('click', function() {
        const totalChecked = document.querySelectorAll('.check-item:checked').length;
        bulkCount.textContent = totalChecked;
        modalBulk.show();
    });

    // Konfirmasi Bulk Verifikasi
    btnKonfirmasiBulk?.addEventListener('click', function() {
        const totalChecked = document.querySelectorAll('.check-item:checked').length;
        if (totalChecked > 0) {
            if (confirm(`Anda yakin ingin memverifikasi ${totalChecked} transaksi sekaligus?`)) {
                // Copy catatan bulk ke form
                const catatanBulk = document.querySelector('textarea[name="catatan_bendahara_bulk"]').value;
                if (catatanBulk) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'catatan_bendahara';
                    input.value = catatanBulk;
                    formBulk.appendChild(input);
                }
                formBulk.submit();
            }
        }
    });

    // Initial check
    updateBulkButton();
});
</script>
@endpush

@endsection
