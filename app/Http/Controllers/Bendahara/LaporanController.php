<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class LaporanController extends Controller
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

        // Get wisata untuk ditampilkan
        $wisata = \App\Models\Wisata::first();

        return view('bendahara.laporan', compact('pemesanan', 'totalPendapatan', 'totalTerverifikasi', 'totalBelumVerifikasi', 'wisata'));
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

    public function bulkVerifikasi(Request $request)
    {
        $request->validate([
            'pemesanan_ids' => 'required|array',
            'pemesanan_ids.*' => 'exists:pemesanan,id',
            'catatan_bendahara' => 'nullable|string',
        ]);

        $jumlah = 0;
        foreach ($request->pemesanan_ids as $id) {
            $pemesanan = Pemesanan::find($id);
            if ($pemesanan && !$pemesanan->diverifikasi_bendahara) {
                $pemesanan->update([
                    'diverifikasi_bendahara' => true,
                    'diverifikasi_oleh_bendahara' => auth()->id(),
                    'tanggal_verifikasi_bendahara' => now(),
                    'catatan_bendahara' => $request->catatan_bendahara,
                ]);
                $jumlah++;
            }
        }

        return redirect()->back()->with('success', "Berhasil memverifikasi {$jumlah} transaksi sekaligus.");
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
        
        $totalTransaksi = $pemesanan->count();
        $totalTiket = $pemesanan->sum('jumlah_tiket');
        $totalPendapatan = $pemesanan->sum('total_harga');

        $periode = 'Semua Periode';
        if ($request->tanggal_dari && $request->tanggal_sampai) {
            $periode = date('d/m/Y', strtotime($request->tanggal_dari)) . ' - ' . date('d/m/Y', strtotime($request->tanggal_sampai));
        } elseif ($request->tanggal_dari) {
            $periode = 'Sejak ' . date('d/m/Y', strtotime($request->tanggal_dari));
        } elseif ($request->tanggal_sampai) {
            $periode = 'Sampai ' . date('d/m/Y', strtotime($request->tanggal_sampai));
        }

        $pdf = \PDF::loadView('pdf.laporan', compact(
            'pemesanan',
            'totalTransaksi',
            'totalTiket',
            'totalPendapatan',
            'periode'
        ))->setPaper('a4', 'landscape');

        $filename = 'Laporan-Penjualan-' . date('Y-m-d') . '.pdf';
        return $pdf->stream($filename);
    }
}
