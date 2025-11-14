<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pemesanan')->unique();
            $table->string('nama_pemesan');
            $table->string('email_pemesan');
            $table->string('nomor_whatsapp');
            $table->date('tanggal_kunjungan');
            $table->integer('jumlah_tiket')->default(0);
            $table->integer('jumlah_parkir_motor')->default(0);
            $table->integer('jumlah_parkir_mobil')->default(0);
            $table->decimal('total_harga', 12, 2);
            $table->string('bukti_transfer')->nullable();
            $table->enum('status_pembayaran', ['menunggu', 'valid', 'tidak_valid'])->default('menunggu');
            $table->text('catatan_admin')->nullable();
            $table->foreignId('divalidasi_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('tanggal_validasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
