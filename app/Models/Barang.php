<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
        'supplier_id',
        'stok',
        'satuan',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class, 'barang_id');
    }

    public function barangKeluars()
    {
        return $this->hasMany(BarangKeluar::class, 'barang_id');
    }

    public function isStokMenipis(): bool
    {
        return $this->stok < 10;
    }
}
