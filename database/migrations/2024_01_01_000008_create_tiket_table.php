<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained('pemesanan')->onDelete('cascade');
            $table->string('kode_tiket')->unique();
            $table->string('qr_code_path')->nullable();
            $table->string('jenis_tiket')->default('umum');
            $table->boolean('sudah_digunakan')->default(false);
            $table->timestamp('tanggal_scan')->nullable();
            $table->foreignId('discan_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiket');
    }
};
