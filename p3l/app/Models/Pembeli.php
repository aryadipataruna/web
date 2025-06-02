<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Import the trait

class Pembeli extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens; // Add HasApiTokens trait

    public $timestamps = false;
    protected $table = 'pembeli';
    protected $primaryKey = 'ID_PEMBELI';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID_PEMBELI', // Include ID_PEMBELI in fillable for the store method
        'NAMA_PEMBELI',
        'EMAIL_PEMBELI',
        'PASSWORD_PEMBELI',
        'NO_PEMBELI',
        'ALAMAT_PEMBELI',
        'POIN_PEMBELI',
    ];

    protected $hidden = [
        'PASSWORD_PEMBELI',
        'remember_token',
    ];

    protected $casts = [
        'POIN_PEMBELI' => 'double',
    ];

    public function getAuthPassword()
    {
        return $this->PASSWORD_PEMBELI;
    }

    public function alamat(): HasMany
    {
        return $this->hasMany(Alamat::class, 'ID_PEMBELI', 'ID_PEMBELI');
    }

    public function diskusi(): HasMany
    {
        return $this->hasMany(Diskusi::class, 'ID_PEMBELI', 'ID_PEMBELI');
    }

    public function penjualan(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'id_pembeli', 'ID_PEMBELI');
    }

    public function penukaran(): HasMany
    {
        return $this->hasMany(Penukaran::class, 'ID_PEMBELI', 'ID_PEMBELI');
    }
}
