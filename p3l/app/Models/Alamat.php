<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alamat extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'alamat';
    protected $primaryKey = 'ID_ALAMAT';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID_PEMBELI',
        'ID_ORGANISASI',
        'DESKRIPSI_ALAMAT',
    ];

    public function pembeli(): BelongsTo
    {
        return $this->belongsTo(Pembeli::class, 'ID_PEMBELI', 'ID_PEMBELI');
    }

    public function organisasi(): BelongsTo
    {
        return $this->belongsTo(Organisasi::class, 'ID_ORGANISASI', 'ID_ORGANISASI');
    }
}


