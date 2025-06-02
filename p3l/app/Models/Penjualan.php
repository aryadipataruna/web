<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Penjualan extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pembeli',
        'id_barang',
        'id_komisi',
        'id_pegawai',
        'tgl_pesan',
        'tgl_kirim',
        'tgl_ambil',
        'status',
        'jenis_pengantaran',
        'tgl_pembayaran',
        'total_ongkir',
        'harga_setelah_ongkir',
        'potongan_harga',
        'total_harga',
    ];

    protected $casts = [
        'tgl_pesan' => 'date',
        'tgl_kirim' => 'date',
        'tgl_ambil' => 'date',
        'tgl_pembayaran' => 'date',
        'total_ongkir' => 'double',
        'harga_setelah_ongkir' => 'double',
        'potongan_harga' => 'double',
        'total_harga' => 'double',
    ];

    public function pembeli(): BelongsTo
    {
        return $this->belongsTo(Pembeli::class, 'id_pembeli', 'ID_PEMBELI');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    // penjualan.id_komisi is FK to komisi.id_komisi (PK)
    public function komisi(): BelongsTo
    {
        return $this->belongsTo(Komisi::class, 'id_komisi', 'id_komisi');
    }
    // Alternatively, if a Penjualan 'has one' Komisi where komisi.id_penjualan = penjualan.id_penjualan
    // public function komisiEntry(): HasOne
    // {
    //     return $this->hasOne(Komisi::class, 'id_penjualan', 'id_penjualan');
    // }
    // Given your schema has `id_komisi` in `penjualan` table, `belongsTo` is more direct.

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'ID_PEGAWAI');
    }
}