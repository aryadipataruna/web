<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Import the trait

class Pegawai extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens; // Add HasApiTokens trait

    public $timestamps = false;
    protected $table = 'pegawai';
    protected $primaryKey = 'ID_PEGAWAI';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID_PEGAWAI', // Include ID_PEGAWAI in fillable
        'ID_JABATAN',
        'NAMA_PEGAWAI',
        'TGL_LAHIR_PEGAWAI',
        'NOTELP_PEGAWAI',
        'EMAIL_PEGAWAI',
        'PASSWORD_PEGAWAI',
        'ALAMAT_PEGAWAI',
    ];

    protected $hidden = [
        'PASSWORD_PEGAWAI',
        'remember_token',
    ];

    // TGL_LAHIR_PEGAWAI is varchar in DB. Cast if always in YYYY-MM-DD, or use accessor/mutator.
    // protected $casts = [
    //     'TGL_LAHIR_PEGAWAI' => 'date',
    // ];

    public function getAuthPassword()
    {
        return $this->PASSWORD_PEGAWAI;
    }

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'ID_JABATAN', 'ID_JABATAN');
    }

    public function barangDitangani(): HasMany
    {
        return $this->hasMany(Barang::class, 'id_pegawai', 'ID_PEGAWAI');
    }

    public function komisiDiterima(): HasMany
    {
        return $this->hasMany(Komisi::class, 'id_pegawai', 'ID_PEGAWAI');
    }

    public function penjualanDilakukan(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'id_pegawai', 'ID_PEGAWAI');
    }
}
