<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Import the trait

class Penitip extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens; // Add HasApiTokens trait

    public $timestamps = false;
    protected $table = 'penitip';
    protected $primaryKey = 'ID_PENITIP';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID_PENITIP', // Include ID_PENITIP in fillable
        'NAMA_PENITIP',
        'ALAMAT_PENITIP',
        'EMAIL_PENITIP',
        'PASSWORD_PENITIP',
        'SALDO_PENITIP',
        'POIN_PENITIP',
    ];

    protected $hidden = [
        'PASSWORD_PENITIP',
        'remember_token', // If using Authenticatable
    ];

    protected $casts = [
        'SALDO_PENITIP' => 'double',
        'POIN_PENITIP' => 'double',
    ];

    public function getAuthPassword()
    {
        return $this->PASSWORD_PENITIP;
    }

    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class, 'id_penitip', 'ID_PENITIP');
    }

    // If ID_PENITIP is PK in 'diskusi' table, it would be a HasOne relationship.
    // Assuming a Penitip can have multiple discussions as per Diskusi model's PK logic:
    public function diskusi(): HasMany
    {
        return $this->hasMany(Diskusi::class, 'ID_PENITIP', 'ID_PENITIP');
    }

    public function rating()
    {
        return $this->hasMany(Rating::class, 'id_penitip', 'ID_PENITIP');
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    public function ratingsCount()
    {
        return $this->ratings()->count();
    }
}
