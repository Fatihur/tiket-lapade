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

                    <h6 class="fw-semibold mt-4 mb-3">Galeri Foto</h6>
                    
                    <div class="row mb-3">
                        @forelse($wisata->galeri as $galeri)
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <img src="{{ asset('storage/' . $galeri->path_file) }}" class="card-img-top" alt="{{ $galeri->keterangan }}">
                                    <div class="card-body p-2">
                                        <small>{{ $galeri->keterangan }}</small>
                                        @if($galeri->utama)
                                            <span class="badge bg-primary">Utama</span>
                                        @endif
                                        <form action="{{ route('admin.galeri.delete', $galeri->id) }}" method="POST" class="mt-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger w-100" onclick="return confirm('Hapus foto ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted">Belum ada foto. Upload foto di bawah.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Upload Foto Baru</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pilih Gambar</label>
                                    <input type="file" id="gambar" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <input type="text" id="keterangan" class="form-control" placeholder="Opsional">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="form-check">
                                        <input type="checkbox" id="utama" class="form-check-input">
                                        <label class="form-check-label" for="utama">Utama</label>
                                    </div>
                                </div>
                            </div>
                            <button type="button" onclick="uploadGambar()" class="btn btn-success">
                                <i class="ti ti-upload"></i> Upload Foto
                            </button>
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

@push('scripts')
<script>
function uploadGambar() {
    const gambar = document.getElementById('gambar').files[0];
    const keterangan = document.getElementById('keterangan').value;
    const utama = document.getElementById('utama').checked;
    
    if (!gambar) {
        alert('Pilih gambar terlebih dahulu!');
        return;
    }
    
    const formData = new FormData();
    formData.append('gambar', gambar);
    formData.append('keterangan', keterangan);
    formData.append('utama', utama ? '1' : '0');
    formData.append('_token', '{{ csrf_token() }}');
    
    fetch('{{ route("admin.wisata.galeri.upload", $wisata->id) }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Foto berhasil diupload!');
            location.reload();
        } else {
            alert('Gagal upload foto: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        alert('Error: ' + error);
    });
}
</script>
@endpush
