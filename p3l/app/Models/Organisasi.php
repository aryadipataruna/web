<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable; // Assuming Organisasi can log in
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Import the trait

// If Organisasi can log in:
// use Illuminate\Foundation\Auth\User as Authenticatable;
// class Organisasi extends Authenticatable
class Organisasi extends Authenticatable // Changed to extend Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens; // Add HasApiTokens trait

    public $timestamps = false;
    protected $table = 'organisasi';
    protected $primaryKey = 'ID_ORGANISASI';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID_ORGANISASI', // Include ID_ORGANISASI in fillable
        'NAMA_ORGANISASI',
        'PASSWORD_ORGANISASI',
        'NOTELP_ORGANISASI',
        'ALAMAT_ORGANISASI',
        'EMAIL_ORGANISASI',
    ];

    protected $hidden = [
        'PASSWORD_ORGANISASI',
        'remember_token', // Add remember_token if extending Authenticatable
    ];

    // If Organisasi extends Authenticatable and PASSWORD_ORGANISASI is the password field:
    public function getAuthPassword()
    {
        return $this->PASSWORD_ORGANISASI;
    }

    public function alamat(): HasMany
    {
        return $this->hasMany(Alamat::class, 'ID_ORGANISASI', 'ID_ORGANISASI');
    }

    public function donasi(): HasMany
    {
        return $this->hasMany(Donasi::class, 'ID_ORGANISASI', 'ID_ORGANISASI');
    }

    public function reqDonasi(): HasMany
    {
        return $this->hasMany(ReqDonasi::class, 'ID_ORGANISASI', 'ID_ORGANISASI');
    }
}
