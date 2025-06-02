<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Komisi extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'komisi';
    protected $primaryKey = 'id_komisi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_penjualan',
        'id_pegawai',
        'komisi_perusahaan',
        'komisi_hunter',
        'bonus',
    ];

    protected $casts = [
        'komisi_perusahaan' => 'double',
        'komisi_hunter' => 'double',
        'bonus' => 'double',
    ];

    public function penjualan(): BelongsTo
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan', 'id_penjualan');
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'ID_PEGAWAI');
    }
}

