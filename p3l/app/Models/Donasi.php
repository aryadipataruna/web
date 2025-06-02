<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donasi extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'donasi';
    protected $primaryKey = 'ID_DONASI';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID_ORGANISASI',
        'NAMA_BARANG_DONASI',
        'TGL_DONASI',
        'NAMA_PENERIMA',
    ];

    protected $casts = [
        'TGL_DONASI' => 'date',
    ];

    public function organisasi(): BelongsTo
    {
        return $this->belongsTo(Organisasi::class, 'ID_ORGANISASI', 'ID_ORGANISASI');
    }
}

