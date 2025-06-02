<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Penukaran extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'penukaran';
    protected $primaryKey = 'ID_PENUKARAN';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID_PEMBELI',
        'NAMA_PENUKAR',
        'TANGGAL_TUKAR',
    ];

    protected $casts = [
        'TANGGAL_TUKAR' => 'date',
    ];

    public function pembeli(): BelongsTo
    {
        return $this->belongsTo(Pembeli::class, 'ID_PEMBELI', 'ID_PEMBELI');
    }

    // A Penukaran event has one specific Merchandise item linked to it via merchandise.ID_PENUKARAN
    public function merchandise(): HasOne
    {
        return $this->hasOne(Merchandise::class, 'ID_PENUKARAN', 'ID_PENUKARAN');
    }
}