<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wisata extends Model
{
    protected $table = 'wisata';
    
    protected $fillable = [
        'deskripsi',
        'harga_tiket',
        'biaya_parkir_motor',
        'biaya_parkir_mobil',
        'nomor_rekening',
        'nama_bank',
        'atas_nama',
        'email_kontak',
        'nomor_whatsapp',
        'aktif',
    ];

    protected $casts = [
        'harga_tiket' => 'decimal:2',
        'biaya_parkir_motor' => 'decimal:2',
        'biaya_parkir_mobil' => 'decimal:2',
        'aktif' => 'boolean',
    ];

    public function galeri(): HasMany
    {
        return $this->hasMany(GaleriWisata::class, 'wisata_id');
    }
}
