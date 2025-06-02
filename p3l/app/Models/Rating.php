<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'rating'; // Sesuai dengan penamaan Anda (singular)
    protected $primaryKey = 'id_rating';

    protected $fillable = [
        'id_barang',
        'id_penitip',
        'nama_barang', // Opsional, bisa dihilangkan jika selalu diambil dari relasi
        'rating',
    ];

    /**
     * Get the barang that owns the rating.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function barang()
    {
        // Relasi: Satu rating dimiliki oleh satu barang (Many-to-One)
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    /**
     * Get the penitip that owns the rating.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function penitip()
    {
        return $this->belongsTo(Penitip::class, 'id_penitip', 'ID_PENITIP'); // Sesuaikan ID_PENITIP jika berbeda
    }
}