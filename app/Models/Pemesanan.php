<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';
    
    protected $fillable = [
        'kode_pemesanan',
        'nama_pemesan',
        'email_pemesan',
        'nomor_whatsapp',
        'tanggal_kunjungan',
        'jumlah_tiket',
        'jumlah_parkir_motor',
        'jumlah_parkir_mobil',
        'total_harga',
        'bukti_transfer',
        'status_pembayaran',
        'catatan_admin',
        'divalidasi_oleh',
        'tanggal_validasi',
        'diverifikasi_bendahara',
        'diverifikasi_oleh_bendahara',
        'tanggal_verifikasi_bendahara',
        'catatan_bendahara',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'total_harga' => 'decimal:2',
        'tanggal_validasi' => 'datetime',
        'diverifikasi_bendahara' => 'boolean',
        'tanggal_verifikasi_bendahara' => 'datetime',
    ];

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'divalidasi_oleh');
    }

    public function verifikatorBendahara(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh_bendahara');
    }

    public function tiket(): HasMany
    {
        return $this->hasMany(Tiket::class, 'pemesanan_id');
    }
}
