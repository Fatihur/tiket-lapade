@extends('layouts.app')

@section('title', 'Pengaturan Wisata')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Pengaturan Informasi Wisata</h5>
                <p class="text-muted mb-4">Informasi ini akan ditampilkan di halaman landing page</p>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="fw-semibold">Status</h6>
                                <p class="mb-0">
                                    @if($wisata->aktif)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-light-primary">
                            <div class="card-body">
                                <h6 class="fw-semibold">Harga Tiket</h6>
                                <p class="mb-0 fw-bold">Rp {{ number_format($wisata->harga_tiket, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light-success">
                            <div class="card-body">
                                <h6 class="fw-semibold">Parkir Motor</h6>
                                <p class="mb-0 fw-bold">Rp {{ number_format($wisata->biaya_parkir_motor, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light-warning">
                            <div class="card-body">
                                <h6 class="fw-semibold">Parkir Mobil</h6>
                                <p class="mb-0 fw-bold">Rp {{ number_format($wisata->biaya_parkir_mobil, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="mt-4">
                    <a href="{{ route('admin.wisata.edit', $wisata->id) }}" class="btn btn-primary">
                        <i class="ti ti-edit"></i> Edit Informasi Wisata
                    </a>
                    <a href="{{ route('landing') }}" target="_blank" class="btn btn-outline-secondary">
                        <i class="ti ti-external-link"></i> Lihat Landing Page
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
