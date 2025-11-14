<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('Test email dari aplikasi Tiket Wisata Online. Jika Anda menerima email ini, berarti konfigurasi email sudah berhasil!', function($message) {
        $message->to('fatihur17@gmail.com')
                ->subject('Test Email - Tiket Wisata Online');
    });
    
    echo "✅ Email berhasil dikirim ke fatihur17@gmail.com\n";
    echo "Silakan cek inbox atau folder spam.\n";
    
} catch (Exception $e) {
    echo "❌ Gagal mengirim email!\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "\nPastikan konfigurasi email di .env sudah benar.\n";
}
