<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemesanan::with(['validator', 'verifikatorBendahara'])
            ->where('status_pembayaran', 'valid')
            ->where('diverifikasi_bendahara', true); // Hanya yang sudah diverifikasi bendahara

        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('tanggal_kunjungan', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('tanggal_kunjungan', '<=', $request->tanggal_sampai);
        }

        $pemesanan = $query->orderBy('tanggal_kunjungan', 'desc')->get();

        $totalPendapatan = $pemesanan->sum('total_harga');
        $totalTiket = $pemesanan->sum('jumlah_tiket');

        return view('admin.laporan.index', compact('pemesanan', 'totalPendapatan', 'totalTiket'));
    }

    public function cetakPdf(Request $request)
    {
        $query = Pemesanan::with(['validator', 'verifikatorBendahara'])
            ->where('status_pembayaran', 'valid')
            ->where('diverifikasi_bendahara', true);

        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('tanggal_kunjungan', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('tanggal_kunjungan', '<=', $request->tanggal_sampai);
        }

        $pemesanan = $query->orderBy('tanggal_kunjungan', 'desc')->get();
        $totalPendapatan = $pemesanan->sum('total_harga');
        $totalTiket = $pemesanan->sum('jumlah_tiket');

        $tanggalDari = $request->tanggal_dari ?? 'Awal';
        $tanggalSampai = $request->tanggal_sampai ?? 'Sekarang';

        $pdf = \PDF::loadView('pdf.laporan', compact('pemesanan', 'totalPendapatan', 'totalTiket', 'tanggalDari', 'tanggalSampai'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Penjualan-' . date('Y-m-d') . '.pdf');
    }
}
