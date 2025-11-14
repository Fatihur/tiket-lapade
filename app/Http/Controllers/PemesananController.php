<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PemesananController extends Controller
{
    public function create()
    {
        $wisata = Wisata::first();
        return view('landing.pemesanan', compact('wisata'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'email_pemesan' => 'required|email',
            'nomor_whatsapp' => 'required|string|max:20',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jumlah_tiket' => 'required|integer|min:1',
            'jumlah_parkir_motor' => 'required|integer|min:0',
            'jumlah_parkir_mobil' => 'required|integer|min:0',
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $wisata = Wisata::first();

        $totalHarga = ($validated['jumlah_tiket'] * $wisata->harga_tiket) +
                      ($validated['jumlah_parkir_motor'] * $wisata->biaya_parkir_motor) +
                      ($validated['jumlah_parkir_mobil'] * $wisata->biaya_parkir_mobil);

        $kodePemesanan = 'TKT-' . strtoupper(Str::random(10));

        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('bukti_transfer', $filename, 'public');
            $validated['bukti_transfer'] = $path;
        }

        $pemesanan = Pemesanan::create([
            'kode_pemesanan' => $kodePemesanan,
            'nama_pemesan' => $validated['nama_pemesan'],
            'email_pemesan' => $validated['email_pemesan'],
            'nomor_whatsapp' => $validated['nomor_whatsapp'],
            'tanggal_kunjungan' => $validated['tanggal_kunjungan'],
            'jumlah_tiket' => $validated['jumlah_tiket'],
            'jumlah_parkir_motor' => $validated['jumlah_parkir_motor'],
            'jumlah_parkir_mobil' => $validated['jumlah_parkir_mobil'],
            'total_harga' => $totalHarga,
            'bukti_transfer' => $validated['bukti_transfer'],
            'status_pembayaran' => 'menunggu',
        ]);

        return redirect()->route('pemesanan.sukses', $pemesanan->id)
            ->with('success', 'Pemesanan berhasil! Silakan tunggu validasi dari admin.');
    }

    public function sukses($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        return view('landing.sukses', compact('pemesanan'));
    }
}
