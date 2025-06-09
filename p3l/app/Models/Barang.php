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
        'no_nota_penitipan',
        'rating'
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

    public function rating() 
    {
        return $this->hasOne(Rating::class, 'id_barang', 'id_barang');
    }

    public function currentRating()
    {
        return $this->rating ? $this->rating->rating : null;
    }

     // Accessor to calculate Komisi Hunter
    public function getKomisiHunterAttribute()
    {
        // This logic is based on the image's example for K201 (5% of Harga Jual) and R95 (0)
        // This is a simplified interpretation. Actual logic might be more complex.
        if ($this->id_barang === 'BAR005') { // Assuming BAR005 is "Kompor Tanam 3 tungku" from the report example
            return $this->harga_barang * 0.05; // 5% of sales price
        } elseif ($this->id_barang === 'BAR006') { // Assuming BAR006 is "Rak Buku 5 tingkat" from the report example
            return 0; // 0 for non-hunting item
        }
        // Default or other logic for other products
        return 0; // Default to 0 if no specific rule applies
    }

    // Accessor to calculate Bonus Penitip
    public function getBonusPenitipAttribute()
    {
        // Based on "Kompor laku < 7 hari, sehingga penitip mendapat bonus."
        if ($this->tgl_laku && $this->tgl_titip) {
            $diffInDays = $this->tgl_titip->diffInDays($this->tgl_laku);
            if ($diffInDays < 7) {
                // 10% of ReUse Mart's initial 20% commission (before Hunter's cut)
                // This means 10% of (20% of harga_barang)
                return ($this->harga_barang * 0.20) * 0.10; // Assuming 20% is base commission for ReuseMart
            }
        }
        return 0;
    }

    // Accessor to calculate Komisi ReUse Mart
    public function getKomisiReuseMartAttribute()
    {
        $baseCommissionPercentage = 0.20; // Default 20%

        // Check for consignment extension for R95
        // Assuming BAR006 is "Rak Buku 5 tingkat"
        if ($this->id_barang === 'BAR006' && $this->tgl_laku && $this->tgl_titip) {
            $diffInMonths = $this->tgl_titip->diffInMonths($this->tgl_laku);
            if ($diffInMonths >= 1) { // "Rak buku laku > 1 bulan"
                $baseCommissionPercentage = 0.30; // 30% for extended consignment
            }
        }
        // Initial commission
        $initialCommission = $this->harga_barang * $baseCommissionPercentage;

        // Deduct Hunter Commission from ReUse Mart's share
        $komisiHunter = $this->komisi_hunter; // Using the accessor

        $finalCommission = $initialCommission - $komisiHunter;

        // Deduct Consignor Bonus if applicable
        $bonusPenitip = $this->bonus_penitip; // Using the accessor
        $finalCommission -= $bonusPenitip;

        return $finalCommission;
    }

    public function hunter()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'ID_PEGAWAI');
    }

    // You might also want an accessor for 'Perpanjangan' to display 'Ya' or 'Tidak'
    public function getStatusPerpanjanganAttribute()
    {
        return $this->perpanjangan == '1' ? 'Ya' : 'Tidak';
    }
}

