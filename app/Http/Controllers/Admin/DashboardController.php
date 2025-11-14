<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\User;
use App\Models\Wisata;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPemesanan = Pemesanan::count();
        $pemesananMenunggu = Pemesanan::where('status_pembayaran', 'menunggu')->count();
        $pemesananValid = Pemesanan::where('status_pembayaran', 'valid')->count();
        $totalPendapatan = Pemesanan::where('status_pembayaran', 'valid')->sum('total_harga');
        
        $pemesananTerbaru = Pemesanan::with(['validator'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalPemesanan',
            'pemesananMenunggu',
            'pemesananValid',
            'totalPendapatan',
            'pemesananTerbaru'
        ));
    }
}
