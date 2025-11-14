@extends('layouts.app')

@section('title', 'Scan QR Code Tiket')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Scan QR Code Tiket</h5>

                <div id="reader" style="width: 100%;"></div>

                <div class="mt-4">
                    <h6 class="fw-semibold">Atau Masukkan Kode Tiket Manual</h6>
                    <form id="formScanManual">
                        <div class="input-group">
                            <input type="text" id="kodeTiket" class="form-control" placeholder="Masukkan kode tiket">
                            <button type="submit" class="btn btn-primary">Validasi</button>
                        </div>
                    </form>
                </div>

                <div id="hasilScan" class="mt-4"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Informasi Tiket -->
<div class="modal fade" id="modalInfoTiket" tabindex="-1" aria-labelledby="modalInfoTiketLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" id="modalHeader">
                <h5 class="modal-title" id="modalInfoTiketLabel">
                    <i class="ti ti-ticket me-2"></i>
                    <span id="modalTitle">Informasi Tiket</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Content will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="resumeScan()">Scan Lagi</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    let html5QrCode;

    function onScanSuccess(decodedText, decodedResult) {
        validasiTiket(decodedText);
        html5QrCode.pause();
    }

    function validasiTiket(kodeTiket) {
        fetch('{{ route("petugas.scan.process") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ kode_tiket: kodeTiket })
        })
        .then(response => response.json())
        .then(data => {
            showModal(data);
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('hasilScan').innerHTML = `
                <div class="alert alert-danger">
                    <h5>Error!</h5>
                    <p>Terjadi kesalahan saat memvalidasi tiket.</p>
                </div>
            `;
        });
    }

    function showModal(data) {
        const modal = new bootstrap.Modal(document.getElementById('modalInfoTiket'));
        const modalHeader = document.getElementById('modalHeader');
        const modalTitle = document.getElementById('modalTitle');
        const modalBody = document.getElementById('modalBody');
        
        if (data.success) {
            // Success - Tiket Valid
            modalHeader.className = 'modal-header bg-success text-white';
            modalTitle.innerHTML = '<i class="ti ti-circle-check me-2"></i>Tiket Valid!';
            modalBody.innerHTML = `
                <div class="text-center mb-3">
                    <i class="ti ti-circle-check text-success" style="font-size: 64px;"></i>
                </div>
                <table class="table table-borderless">
                    <tr>
                        <td width="40%" class="fw-semibold">Kode Tiket</td>
                        <td>: ${data.data.kode_tiket}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Jenis Tiket</td>
                        <td>: <span class="badge bg-primary">${data.data.jenis_tiket.toUpperCase()}</span></td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Nama Pemesan</td>
                        <td>: ${data.data.nama_pemesan}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Wisata</td>
                        <td>: ${data.data.wisata}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Tanggal Kunjungan</td>
                        <td>: ${data.data.tanggal_kunjungan}</td>
                    </tr>
                </table>
                <div class="alert alert-success mt-3 mb-0">
                    <i class="ti ti-info-circle me-2"></i>
                    <strong>Tiket berhasil divalidasi!</strong> Pengunjung dapat masuk.
                </div>
            `;
        } else {
            // Error - Tiket Tidak Valid atau Sudah Digunakan
            if (data.status === 'sudah_digunakan') {
                modalHeader.className = 'modal-header bg-warning text-dark';
                modalTitle.innerHTML = '<i class="ti ti-alert-triangle me-2"></i>Tiket Sudah Digunakan';
                modalBody.innerHTML = `
                    <div class="text-center mb-3">
                        <i class="ti ti-alert-triangle text-warning" style="font-size: 64px;"></i>
                    </div>
                    <div class="alert alert-warning">
                        <h6 class="alert-heading">Perhatian!</h6>
                        <p class="mb-0">${data.message}</p>
                    </div>
                    ${data.data ? `
                    <table class="table table-borderless mt-3">
                        <tr>
                            <td width="40%" class="fw-semibold">Tanggal Scan</td>
                            <td>: ${data.data.tanggal_scan}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Petugas</td>
                            <td>: ${data.data.petugas}</td>
                        </tr>
                    </table>
                    ` : ''}
                `;
            } else {
                modalHeader.className = 'modal-header bg-danger text-white';
                modalTitle.innerHTML = '<i class="ti ti-x me-2"></i>Tiket Tidak Valid';
                modalBody.innerHTML = `
                    <div class="text-center mb-3">
                        <i class="ti ti-x text-danger" style="font-size: 64px;"></i>
                    </div>
                    <div class="alert alert-danger mb-0">
                        <h6 class="alert-heading">Error!</h6>
                        <p class="mb-0">${data.message}</p>
                    </div>
                `;
            }
        }
        
        modal.show();
    }

    function resumeScan() {
        if (html5QrCode) {
            html5QrCode.resume();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        html5QrCode = new Html5Qrcode("reader");
        
        html5QrCode.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: 250 },
            onScanSuccess
        ).catch(err => {
            console.error('Error starting camera:', err);
        });

        document.getElementById('formScanManual').addEventListener('submit', function(e) {
            e.preventDefault();
            const kodeTiket = document.getElementById('kodeTiket').value;
            if (kodeTiket) {
                validasiTiket(kodeTiket);
                document.getElementById('kodeTiket').value = '';
            }
        });
    });
</script>
@endpush
