<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wisata;
use App\Models\GaleriWisata;
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
        
        $wisata->load('galeri');
        
        return view('admin.wisata.index', compact('wisata'));
    }

    public function edit($id)
    {
        $wisata = Wisata::with('galeri')->findOrFail($id);
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

    public function uploadGaleri(Request $request, $id)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan' => 'nullable|string',
            'utama' => 'boolean',
        ]);

        $wisata = Wisata::findOrFail($id);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('galeri_wisata', $filename, 'public');

            if ($request->utama) {
                GaleriWisata::where('wisata_id', $id)->update(['utama' => false]);
            }

            GaleriWisata::create([
                'wisata_id' => $id,
                'nama_file' => $filename,
                'path_file' => $path,
                'keterangan' => $request->keterangan,
                'utama' => $request->utama ?? false,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Gambar berhasil ditambahkan']);
    }

    public function deleteGaleri($id)
    {
        $galeri = GaleriWisata::findOrFail($id);
        
        if (file_exists(storage_path('app/public/' . $galeri->path_file))) {
            unlink(storage_path('app/public/' . $galeri->path_file));
        }
        
        $galeri->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}
