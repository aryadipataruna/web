<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Merchandise extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'merchandise';
    protected $primaryKey = 'ID_MERCHANDISE';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'NAMA_MERCHANDISE',
        'ID_PENUKARAN',
    ];

    public function penukaran(): BelongsTo
    {
        return $this->belongsTo(Penukaran::class, 'ID_PENUKARAN', 'ID_PENUKARAN');
    }
}

