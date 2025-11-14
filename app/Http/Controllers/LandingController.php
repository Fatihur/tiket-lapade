<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil data wisata utama (hanya 1 data)
        $wisata = Wisata::first();
        
        // Jika belum ada data, redirect ke halaman info
        if (!$wisata) {
            return view('landing.no-data');
        }
        
        return view('landing.index', compact('wisata'));
    }

    public function detail($id)
    {
        $wisata = Wisata::findOrFail($id);
        return view('landing.detail', compact('wisata'));
    }
}
