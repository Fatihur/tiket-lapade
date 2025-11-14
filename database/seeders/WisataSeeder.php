<?php

namespace Database\Seeders;

use App\Models\Wisata;
use Illuminate\Database\Seeder;

class WisataSeeder extends Seeder
{
    public function run(): void
    {
        Wisata::updateOrCreate(
            ['id' => 1],
            [
                'deskripsi' => 'Selamat datang di tempat wisata kami. Nikmati keindahan alam dan berbagai fasilitas yang tersedia untuk kenyamanan Anda.',
                'harga_tiket' => 25000,
                'biaya_parkir_motor' => 5000,
                'biaya_parkir_mobil' => 10000,
                'nomor_rekening' => '1234567890',
                'nama_bank' => 'Bank BCA',
                'atas_nama' => 'Wisata Anda',
                'email_kontak' => 'info@wisata.com',
                'nomor_whatsapp' => '081234567890',
                'aktif' => true,
            ]
        );
    }
}
