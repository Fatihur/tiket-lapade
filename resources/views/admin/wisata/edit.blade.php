@extends('layouts.app')

@section('title', 'Edit Informasi Wisata')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Edit Informasi Wisata</h5>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.wisata.update', $wisata->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $wisata->deskripsi) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga Tiket</label>
                        <input type="number" name="harga_tiket" class="form-control" value="{{ old('harga_tiket', $wisata->harga_tiket) }}" required>
                        <small class="text-muted">Harga per tiket (tidak dibedakan dewasa/anak)</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Biaya Parkir Motor</label>
                            <input type="number" name="biaya_parkir_motor" class="form-control" value="{{ old('biaya_parkir_motor', $wisata->biaya_parkir_motor) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Biaya Parkir Mobil</label>
                            <input type="number" name="biaya_parkir_mobil" class="form-control" value="{{ old('biaya_parkir_mobil', $wisata->biaya_parkir_mobil) }}" required>
                        </div>
                    </div>

                    <h6 class="fw-semibold mt-4 mb-3">Informasi Pembayaran</h6>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nama Bank</label>
                            <input type="text" name="nama_bank" class="form-control" value="{{ old('nama_bank', $wisata->nama_bank) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nomor Rekening</label>
                            <input type="text" name="nomor_rekening" class="form-control" value="{{ old('nomor_rekening', $wisata->nomor_rekening) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Atas Nama</label>
                            <input type="text" name="atas_nama" class="form-control" value="{{ old('atas_nama', $wisata->atas_nama) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Kontak</label>
                            <input type="email" name="email_kontak" class="form-control" value="{{ old('email_kontak', $wisata->email_kontak) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor WhatsApp</label>
                            <input type="text" name="nomor_whatsapp" class="form-control" value="{{ old('nomor_whatsapp', $wisata->nomor_whatsapp) }}" placeholder="081234567890">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="aktif" class="form-check-input" id="aktif" value="1" {{ old('aktif', $wisata->aktif) ? 'checked' : '' }}>
                            <label class="form-check-label" for="aktif">Aktif (Tampilkan di landing page)</label>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('admin.wisata.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
