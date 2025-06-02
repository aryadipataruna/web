<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Diskusi extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'diskusi';
    // Assuming ID_DISKUSI is the intended unique key for a discussion entry,
    // despite the SQL dump setting ID_PENITIP as PK for the table.
    protected $primaryKey = 'ID_DISKUSI';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID_PENITIP',
        'ID_PEMBELI',
        'ID_BARANG'
        // 'ID_DISKUSI', // Not in fillable if it's the auto-generated PK and not manually set.
    ];

    public function penitip(): BelongsTo
    {
        return $this->belongsTo(Penitip::class, 'ID_PENITIP', 'ID_PENITIP');
    }

    public function pembeli(): BelongsTo
    {
        return $this->belongsTo(Pembeli::class, 'ID_PEMBELI', 'ID_PEMBELI');
    }

    public function barang(): HasMany // A discussion might be referenced by items.
    {
        return $this->hasMany(Barang::class, 'id_diskusi', 'ID_DISKUSI');
    }
}

