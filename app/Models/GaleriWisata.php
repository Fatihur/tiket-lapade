<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GaleriWisata extends Model
{
    protected $table = 'galeri_wisata';
    
    protected $fillable = [
        'wisata_id',
        'nama_file',
        'path_file',
        'keterangan',
        'utama',
    ];

    protected $casts = [
        'utama' => 'boolean',
    ];

    public function wisata(): BelongsTo
    {
        return $this->belongsTo(Wisata::class, 'wisata_id');
    }
}
