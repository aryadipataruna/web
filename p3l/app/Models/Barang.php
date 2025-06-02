<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_penitip',
        'id_diskusi',
        'id_pegawai',
        'nama_barang',
        'deskripsi_barang',
        'kategori',
        'harga_barang',
        'tgl_titip',
        'tgl_laku',
        'tgl_akhir',
        'garansi',
        'perpanjangan',
        'count_perpanjangan',
        'status',
        'gambar_barang',
        'bukti_pembayaran',
    ];

    protected $casts = [
        'harga_barang' => 'double',
        'tgl_titip' => 'date',
        'tgl_laku' => 'date',
        'tgl_akhir' => 'date',
        'garansi' => 'boolean',
        'perpanjangan' => 'boolean',
        'count_perpanjangan' => 'integer',
    ];

    public function penitip(): BelongsTo
    {
        return $this->belongsTo(Penitip::class, 'id_penitip', 'ID_PENITIP');
    }

    public function diskusi(): BelongsTo
    {
        return $this->belongsTo(Diskusi::class, 'id_diskusi', 'ID_DISKUSI');
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'ID_PEGAWAI');
    }

    public function penjualan(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'id_barang', 'id_barang');
    }

    public function penitipan()
    {
        return $this->belongsTo(PenitipanBarang::class, 'no_nota_penitipan', 'no_nota');
    }
}

