<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wisata;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    public function index()
    {
        // Ambil atau buat data wisata (hanya 1 data)
        $wisata = Wisata::firstOrCreate(
            ['id' => 1],
            [
                'deskripsi' => 'Deskripsi wisata Anda',
                'harga_tiket' => 0,
                'biaya_parkir_motor' => 0,
                'biaya_parkir_mobil' => 0,
                'aktif' => true,
            ]
        );
        
        return view('admin.wisata.index', compact('wisata'));
    }

    public function edit($id)
    {
        $wisata = Wisata::findOrFail($id);
        return view('admin.wisata.edit', compact('wisata'));
    }

    public function update(Request $request, $id)
    {
        $wisata = Wisata::findOrFail($id);

        $validated = $request->validate([
            'deskripsi' => 'nullable|string',
            'harga_tiket' => 'required|numeric|min:0',
            'biaya_parkir_motor' => 'required|numeric|min:0',
            'biaya_parkir_mobil' => 'required|numeric|min:0',
            'nomor_rekening' => 'nullable|string',
            'nama_bank' => 'nullable|string',
            'atas_nama' => 'nullable|string',
            'email_kontak' => 'nullable|email',
            'nomor_whatsapp' => 'nullable|string',
            'aktif' => 'boolean',
        ]);

        $wisata->update($validated);

        return redirect()->route('admin.wisata.index')
            ->with('success', 'Data wisata berhasil diperbarui.');
    }

    // Tidak ada method destroy karena data wisata tidak bisa dihapus
}
