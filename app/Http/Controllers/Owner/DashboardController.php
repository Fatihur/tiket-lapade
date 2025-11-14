<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->get('periode', 'harian');

        $pendapatanHariIni = Pemesanan::where('status_pembayaran', 'valid')
            ->whereDate('tanggal_kunjungan', today())
            ->sum('total_harga');

        $pengunjungHariIni = Tiket::where('sudah_digunakan', true)
            ->whereDate('tanggal_scan', today())
            ->count();

        $pendapatanBulanIni = Pemesanan::where('status_pembayaran', 'valid')
            ->whereMonth('tanggal_kunjungan', now()->month)
            ->whereYear('tanggal_kunjungan', now()->year)
            ->sum('total_harga');

        $pengunjungBulanIni = Tiket::where('sudah_digunakan', true)
            ->whereMonth('tanggal_scan', now()->month)
            ->whereYear('tanggal_scan', now()->year)
            ->count();

        $grafikData = $this->getGrafikData($periode);

        return view('owner.dashboard', compact(
            'pendapatanHariIni',
            'pengunjungHariIni',
            'pendapatanBulanIni',
            'pengunjungBulanIni',
            'grafikData',
            'periode'
        ));
    }

    private function getGrafikData($periode)
    {
        if ($periode === 'harian') {
            return Pemesanan::where('status_pembayaran', 'valid')
                ->whereDate('tanggal_kunjungan', '>=', now()->subDays(7))
                ->select(
                    DB::raw('DATE(tanggal_kunjungan) as tanggal'),
                    DB::raw('SUM(total_harga) as pendapatan'),
                    DB::raw('SUM(jumlah_tiket) as pengunjung')
                )
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();
        } elseif ($periode === 'mingguan') {
            return Pemesanan::where('status_pembayaran', 'valid')
                ->whereDate('tanggal_kunjungan', '>=', now()->subWeeks(8))
                ->select(
                    DB::raw('YEARWEEK(tanggal_kunjungan) as minggu'),
                    DB::raw('SUM(total_harga) as pendapatan'),
                    DB::raw('SUM(jumlah_tiket) as pengunjung')
                )
                ->groupBy('minggu')
                ->orderBy('minggu')
                ->get();
        } else {
            return Pemesanan::where('status_pembayaran', 'valid')
                ->whereDate('tanggal_kunjungan', '>=', now()->subMonths(12))
                ->select(
                    DB::raw('DATE_FORMAT(tanggal_kunjungan, "%Y-%m") as bulan'),
                    DB::raw('SUM(total_harga) as pendapatan'),
                    DB::raw('SUM(jumlah_tiket) as pengunjung')
                )
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get();
        }
    }
}
