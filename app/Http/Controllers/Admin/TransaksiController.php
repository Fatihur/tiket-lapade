<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemesanan::with(['validator']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status_pembayaran', $request->status);
        }

        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('tanggal_kunjungan', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('tanggal_kunjungan', '<=', $request->tanggal_sampai);
        }

        $pemesanan = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.transaksi.index', compact('pemesanan'));
    }

    public function show($id)
    {
        $pemesanan = Pemesanan::with(['validator', 'tiket'])->findOrFail($id);
        return view('admin.transaksi.detail', compact('pemesanan'));
    }

    public function validasi(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        // Cek apakah sudah pernah divalidasi sebagai valid
        $sudahValid = $pemesanan->status_pembayaran === 'valid';

        $request->validate([
            'status_pembayaran' => 'required|in:valid,tidak_valid',
            'catatan_admin' => 'nullable|string',
        ]);

        $pemesanan->update([
            'status_pembayaran' => $request->status_pembayaran,
            'catatan_admin' => $request->catatan_admin,
            'divalidasi_oleh' => Auth::id(),
            'tanggal_validasi' => now(),
        ]);

        $message = 'Transaksi berhasil divalidasi.';

        // Hanya generate tiket dan kirim email jika:
        // 1. Status baru adalah 'valid'
        // 2. Belum pernah divalidasi sebagai valid sebelumnya (untuk menghindari duplikasi)
        if ($request->status_pembayaran === 'valid' && !$sudahValid) {
            $this->generateTiket($pemesanan);
            
            $emailTerkirim = $this->kirimEmailTiket($pemesanan);
            
            if ($emailTerkirim) {
                $message = 'Transaksi berhasil divalidasi dan email tiket telah dikirim ke ' . $pemesanan->email_pemesan;
            } else {
                $message = 'Transaksi berhasil divalidasi. Namun email gagal dikirim, silakan kirim manual atau cek konfigurasi email.';
            }
        } elseif ($request->status_pembayaran === 'tidak_valid') {
            $message = 'Transaksi ditolak. Email notifikasi tidak dikirim.';
        } elseif ($sudahValid) {
            $message = 'Status transaksi diperbarui. Email tidak dikirim ulang karena sudah pernah dikirim sebelumnya.';
        }

        return redirect()->route('admin.transaksi.show', $id)
            ->with('success', $message);
    }

    private function kirimEmailTiket($pemesanan)
    {
        try {
            // Reload pemesanan dengan relasi tiket untuk memastikan QR Code sudah ter-generate
            $pemesanan->load('tiket');
            
            \Mail::to($pemesanan->email_pemesan)->send(new \App\Mail\TiketEmail($pemesanan));
            
            \Log::info('Email tiket berhasil dikirim ke: ' . $pemesanan->email_pemesan . ' untuk pemesanan: ' . $pemesanan->kode_pemesanan);
            
            return true;
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email tiket ke: ' . $pemesanan->email_pemesan . ' - Error: ' . $e->getMessage());
            return false;
        }
    }

    private function generateTiket($pemesanan)
    {
        // Hapus tiket lama jika ada (untuk menghindari duplikasi)
        $pemesanan->tiket()->delete();
        
        // Generate hanya 1 tiket per pemesanan (untuk semua orang dalam pemesanan tersebut)
        $this->createTiket($pemesanan, 'umum');
    }

    private function createTiket($pemesanan, $jenis)
    {
        $kodeTiket = 'TKT-' . strtoupper(Str::random(15));

        $tiket = Tiket::create([
            'pemesanan_id' => $pemesanan->id,
            'kode_tiket' => $kodeTiket,
            'jenis_tiket' => $jenis,
            'sudah_digunakan' => false,
        ]);

        // QR Code akan di-generate on-the-fly saat dibutuhkan
        // Tidak perlu menyimpan file, lebih efisien
    }
}
