<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenitipanBarang extends Model
{
    use HasFactory;

    protected $table = 'penitipan_barang';
    protected $primaryKey = 'no_nota'; // Sesuaikan jika PK bukan 'id'
    public $incrementing = false; // Jika no_nota tidak auto-increment
    protected $keyType = 'string'; // Jika no_nota string

    protected $fillable = [
        'no_nota',
        'id_penitip',
        'nama_penitip',
        'alamat_penitip',
        'delivery_kurir',
        'qc_oleh',
        'tanggal_penitipan',
        'masa_penitipan_sampai',
    ];

    protected $casts = [
        'tanggal_penitipan' => 'datetime',
        'masa_penitipan_sampai' => 'datetime',
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'no_nota_penitipan', 'no_nota');
    }
}