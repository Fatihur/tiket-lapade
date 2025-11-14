<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tiket extends Model
{
    protected $table = 'tiket';
    
    protected $fillable = [
        'pemesanan_id',
        'kode_tiket',
        'qr_code_path',
        'jenis_tiket',
        'sudah_digunakan',
        'tanggal_scan',
        'discan_oleh',
    ];

    protected $casts = [
        'sudah_digunakan' => 'boolean',
        'tanggal_scan' => 'datetime',
    ];

    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'discan_oleh');
    }
}
