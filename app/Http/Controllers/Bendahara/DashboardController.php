<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemesanan::with(['validator', 'verifikatorBendahara'])
            ->where('status_pembayaran', 'valid');

        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('tanggal_kunjungan', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('tanggal_kunjungan', '<=', $request->tanggal_sampai);
        }

        if ($request->has('status_verifikasi')) {
            if ($request->status_verifikasi === 'terverifikasi') {
                $query->where('diverifikasi_bendahara', true);
            } elseif ($request->status_verifikasi === 'belum_verifikasi') {
                $query->where('diverifikasi_bendahara', false);
            }
        }

        $pemesanan = $query->orderBy('tanggal_kunjungan', 'desc')->paginate(20);
        
        // Hitung total berdasarkan filter yang sama
        $totalQuery = clone $query;
        $totalPendapatan = $totalQuery->sum('total_harga');
        
        // Statistik
        $totalTerverifikasi = Pemesanan::where('status_pembayaran', 'valid')
            ->where('diverifikasi_bendahara', true)
            ->count();
        $totalBelumVerifikasi = Pemesanan::where('status_pembayaran', 'valid')
            ->where('diverifikasi_bendahara', false)
            ->count();

        return view('bendahara.dashboard', compact('pemesanan', 'totalPendapatan', 'totalTerverifikasi', 'totalBelumVerifikasi'));
    }

    public function verifikasi(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        $request->validate([
            'catatan_bendahara' => 'nullable|string',
        ]);

        $pemesanan->update([
            'diverifikasi_bendahara' => true,
            'diverifikasi_oleh_bendahara' => auth()->id(),
            'tanggal_verifikasi_bendahara' => now(),
            'catatan_bendahara' => $request->catatan_bendahara,
        ]);

        return redirect()->back()->with('success', 'Laporan transaksi berhasil diverifikasi.');
    }

    public function batalVerifikasi($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        $pemesanan->update([
            'diverifikasi_bendahara' => false,
            'diverifikasi_oleh_bendahara' => null,
            'tanggal_verifikasi_bendahara' => null,
            'catatan_bendahara' => null,
        ]);

        return redirect()->back()->with('success', 'Verifikasi laporan dibatalkan.');
    }
}
