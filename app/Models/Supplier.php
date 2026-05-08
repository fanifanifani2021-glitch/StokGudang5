<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $fillable = ['nama_supplier', 'kategori_id', 'alamat', 'telepon'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'supplier_id');
    }

    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class, 'supplier_id');
    }
}
