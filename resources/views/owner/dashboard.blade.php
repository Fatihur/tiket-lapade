@extends('layouts.app')

@section('title', 'Dashboard Owner')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Dashboard Owner</h5>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-light-primary">
                            <div class="card-body">
                                <h6 class="fw-semibold">Pendapatan Hari Ini</h6>
                                <h3 class="fw-bold">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light-success">
                            <div class="card-body">
                                <h6 class="fw-semibold">Pengunjung Hari Ini</h6>
                                <h3 class="fw-bold">{{ $pengunjungHariIni }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light-warning">
                            <div class="card-body">
                                <h6 class="fw-semibold">Pendapatan Bulan Ini</h6>
                                <h3 class="fw-bold">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light-info">
                            <div class="card-body">
                                <h6 class="fw-semibold">Pengunjung Bulan Ini</h6>
                                <h3 class="fw-bold">{{ $pengunjungBulanIni }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <form method="GET" class="d-inline">
                        <select name="periode" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                            <option value="harian" {{ $periode == 'harian' ? 'selected' : '' }}>Harian (7 Hari)</option>
                            <option value="mingguan" {{ $periode == 'mingguan' ? 'selected' : '' }}>Mingguan (8 Minggu)</option>
                            <option value="bulanan" {{ $periode == 'bulanan' ? 'selected' : '' }}>Bulanan (12 Bulan)</option>
                        </select>
                    </form>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="fw-semibold mb-3">Grafik Pendapatan</h6>
                                <canvas id="chartPendapatan"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="fw-semibold mb-3">Grafik Pengunjung</h6>
                                <canvas id="chartPengunjung"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const grafikData = @json($grafikData);
    
    // Chart Pendapatan
    new Chart(document.getElementById('chartPendapatan'), {
        type: 'line',
        data: {
            labels: grafikData.map(d => d.tanggal || d.minggu || d.bulan),
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: grafikData.map(d => d.pendapatan),
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        }
    });

    // Chart Pengunjung
    new Chart(document.getElementById('chartPengunjung'), {
        type: 'bar',
        data: {
            labels: grafikData.map(d => d.tanggal || d.minggu || d.bulan),
            datasets: [{
                label: 'Pengunjung',
                data: grafikData.map(d => d.pengunjung),
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
            }]
        }
    });
</script>
@endpush
