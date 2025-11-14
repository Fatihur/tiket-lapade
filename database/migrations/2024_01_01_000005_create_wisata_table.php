<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wisata', function (Blueprint $table) {
            $table->id();
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_tiket', 10, 2)->default(0);
            $table->decimal('biaya_parkir_motor', 10, 2)->default(0);
            $table->decimal('biaya_parkir_mobil', 10, 2)->default(0);
            $table->string('nomor_rekening')->nullable();
            $table->string('nama_bank')->nullable();
            $table->string('atas_nama')->nullable();
            $table->string('email_kontak')->nullable();
            $table->string('nomor_whatsapp')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wisata');
    }
};
