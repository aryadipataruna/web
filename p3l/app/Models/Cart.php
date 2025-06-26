<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'name',
        'price',
        'quantity',
        'checked',
        'image',
        'store',
        'description',
        'notes',
    ];

    /**
     * Mendefinisikan cast tipe data untuk atribut.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price'    => 'decimal:2',
        'quantity' => 'integer',
        'checked'  => 'boolean',
    ];

    /**
     * Mendapatkan user (pengguna) yang memiliki item keranjang ini.
     */
    public function user(): BelongsTo
    {
        // Mendefinisikan relasi "belongsTo" ke model User
        return $this->belongsTo(User::class);
    }
}
