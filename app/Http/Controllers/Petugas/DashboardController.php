<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $tiketDiscan = Tiket::where('discan_oleh', Auth::id())
            ->with(['pemesanan'])
            ->orderBy('tanggal_scan', 'desc')
            ->limit(20)
            ->get();

        $totalScanHariIni = Tiket::where('discan_oleh', Auth::id())
            ->whereDate('tanggal_scan', today())
            ->count();

        return view('petugas.dashboard', compact('tiketDiscan', 'totalScanHariIni'));
    }
}
