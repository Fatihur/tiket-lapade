<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Pemesanan;
use App\Mail\TiketEmail;
use Illuminate\Support\Facades\Mail;

try {
    // Ambil pemesanan pertama yang valid
    $pemesanan = Pemesanan::with(['wisata', 'tiket'])->where('status_pembayaran', 'valid')->first();
    
    if (!$pemesanan) {
        echo "❌ Tidak ada pemesanan valid. Silakan validasi transaksi terlebih dahulu.\n";
        exit;
    }
    
    if ($pemesanan->tiket->count() == 0) {
        echo "❌ Pemesanan tidak memiliki tiket. Silakan validasi ulang transaksi.\n";
        exit;
    }
    
    echo "📧 Mengirim email test ke: fatihur17@gmail.com\n";
    echo "Pemesanan: {$pemesanan->kode_pemesanan}\n";
    echo "Jumlah tiket: {$pemesanan->tiket->count()}\n\n";
    
    // Override email pemesan untuk test
    $pemesanan->email_pemesan = 'fatihur17@gmail.com';
    
    Mail::to('fatihur17@gmail.com')->send(new TiketEmail($pemesanan));
    
    echo "✅ Email berhasil dikirim!\n";
    echo "Silakan cek:\n";
    echo "- Inbox email fatihur17@gmail.com\n";
    echo "- Folder spam\n";
    echo "- File log: storage/logs/laravel.log\n";
    
} catch (Exception $e) {
    echo "❌ Gagal mengirim email!\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "\nStacktrace:\n";
    echo $e->getTraceAsString() . "\n";
}
