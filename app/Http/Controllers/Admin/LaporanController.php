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
        $query = Pemesanan::with(['validator'])
            ->where('status_pembayaran', 'valid');

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
}
