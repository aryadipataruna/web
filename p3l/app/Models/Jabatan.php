<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jabatan extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'jabatan';
    protected $primaryKey = 'ID_JABATAN';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'NAMA_JABATAN',
    ];

    public function pegawai(): HasMany
    {
        return $this->hasMany(Pegawai::class, 'ID_JABATAN', 'ID_JABATAN');
    }
}

