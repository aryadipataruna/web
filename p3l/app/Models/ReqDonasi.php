<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReqDonasi extends Model // Renamed from reqdonasi
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'reqdonasi';
    protected $primaryKey = 'ID_REQDONASI';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID_ORGANISASI',
        'NAMA_BARANG_REQDONASI',
        'TGL_REQ',
    ];

    protected $casts = [
        'TGL_REQ' => 'date',
    ];

    public function organisasi(): BelongsTo
    {
        return $this->belongsTo(Organisasi::class, 'ID_ORGANISASI', 'ID_ORGANISASI');
    }
}