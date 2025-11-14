<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Pemesanan;
use PDF;

try {
    echo "Testing PDF generation...\n\n";
    
    // Ambil pemesanan valid
    $pemesanan = Pemesanan::with(['wisata', 'tiket'])->where('status_pembayaran', 'valid')->first();
    
    if (!$pemesanan) {
        echo "❌ Tidak ada pemesanan valid.\n";
        exit;
    }
    
    if ($pemesanan->tiket->count() == 0) {
        echo "❌ Pemesanan tidak memiliki tiket.\n";
        exit;
    }
    
    echo "Pemesanan: {$pemesanan->kode_pemesanan}\n";
    echo "Jumlah tiket: {$pemesanan->tiket->count()}\n\n";
    
    // Generate PDF dengan custom paper size (105mm width, auto height)
    echo "Generating PDF...\n";
    $pdf = PDF::loadView('pdf.tiket', ['pemesanan' => $pemesanan])
        ->setPaper([0, 0, 297.64, 841.89], 'portrait'); // 105mm x A4 height
    
    // Save PDF
    $filename = 'Tiket-' . $pemesanan->kode_pemesanan . '.pdf';
    $pdf->save($filename);
    
    echo "✅ PDF berhasil di-generate!\n";
    echo "File: {$filename}\n";
    echo "Size: " . filesize($filename) . " bytes\n\n";
    echo "Silakan buka file PDF untuk melihat tiket dengan QR Code!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
