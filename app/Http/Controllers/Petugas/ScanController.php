<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScanController extends Controller
{
    public function index()
    {
        return view('petugas.scan');
    }

    public function scan(Request $request)
    {
        $request->validate([
            'kode_tiket' => 'required|string',
        ]);

        $tiket = Tiket::where('kode_tiket', $request->kode_tiket)
            ->with(['pemesanan'])
            ->first();

        if (!$tiket) {
            return response()->json([
                'success' => false,
                'status' => 'tidak_valid',
                'message' => 'Tiket tidak ditemukan!',
            ], 404);
        }

        if ($tiket->sudah_digunakan) {
            return response()->json([
                'success' => false,
                'status' => 'sudah_digunakan',
                'message' => 'Tiket sudah pernah digunakan!',
                'data' => [
                    'tanggal_scan' => $tiket->tanggal_scan,
                    'petugas' => $tiket->petugas->name ?? 'Unknown',
                ],
            ], 400);
        }

        $tiket->update([
            'sudah_digunakan' => true,
            'tanggal_scan' => now(),
            'discan_oleh' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'status' => 'valid',
            'message' => 'Tiket berhasil divalidasi!',
            'data' => [
                'kode_tiket' => $tiket->kode_tiket,
                'jenis_tiket' => $tiket->jenis_tiket,
                'nama_pemesan' => $tiket->pemesanan->nama_pemesan,
                'wisata' => 'Wisata Lapade',
                'tanggal_kunjungan' => $tiket->pemesanan->tanggal_kunjungan,
            ],
        ]);
    }

    public function riwayat()
    {
        $riwayat = Tiket::where('discan_oleh', Auth::id())
            ->with(['pemesanan', 'petugas'])
            ->orderBy('tanggal_scan', 'desc')
            ->paginate(20);

        // Statistik hari ini
        $totalScanHariIni = Tiket::where('discan_oleh', Auth::id())
            ->whereDate('tanggal_scan', today())
            ->count();

        // Semua yang di-scan dianggap valid karena sudah berhasil divalidasi
        $validHariIni = $totalScanHariIni;
        $sudahDigunakanHariIni = 0;

        return view('petugas.riwayat', compact('riwayat', 'totalScanHariIni', 'validHariIni', 'sudahDigunakanHariIni'));
    }
}
