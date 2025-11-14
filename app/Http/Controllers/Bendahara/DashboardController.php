<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik
        $totalPendapatan = Pemesanan::where('status_pembayaran', 'valid')->sum('total_harga');
        $totalTransaksi = Pemesanan::where('status_pembayaran', 'valid')->count();
        $totalTerverifikasi = Pemesanan::where('status_pembayaran', 'valid')
            ->where('diverifikasi_bendahara', true)
            ->count();
        $totalBelumVerifikasi = Pemesanan::where('status_pembayaran', 'valid')
            ->where('diverifikasi_bendahara', false)
            ->count();

        // Transaksi terbaru
        $transaksiTerbaru = Pemesanan::with(['validator'])
            ->where('status_pembayaran', 'valid')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('bendahara.dashboard', compact(
            'totalPendapatan',
            'totalTransaksi',
            'totalTerverifikasi',
            'totalBelumVerifikasi',
            'transaksiTerbaru'
        ));
    }
}
