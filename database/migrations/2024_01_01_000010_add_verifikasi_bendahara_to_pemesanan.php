<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->boolean('diverifikasi_bendahara')->default(false)->after('tanggal_validasi');
            $table->foreignId('diverifikasi_oleh_bendahara')->nullable()->constrained('users')->onDelete('set null')->after('diverifikasi_bendahara');
            $table->timestamp('tanggal_verifikasi_bendahara')->nullable()->after('diverifikasi_oleh_bendahara');
            $table->text('catatan_bendahara')->nullable()->after('tanggal_verifikasi_bendahara');
        });
    }

    public function down(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropForeign(['diverifikasi_oleh_bendahara']);
            $table->dropColumn([
                'diverifikasi_bendahara',
                'diverifikasi_oleh_bendahara',
                'tanggal_verifikasi_bendahara',
                'catatan_bendahara'
            ]);
        });
    }
};
