<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;

class DashboardController extends Controller
{
    public function index()
    {
        $barangs       = Barang::with('kategori')->orderBy('nama_barang')->paginate(15);
        $totalBarang   = Barang::count();
        $stokMenipis   = Barang::where('stok', '<', 10)->count();
        $stokHabis     = Barang::where('stok', 0)->count();
        $totalKategori = Kategori::count();

        return view('manajer.dashboard', compact(
            'barangs',
            'totalBarang',
            'stokMenipis',
            'stokHabis',
            'totalKategori'
        ));
    }
}
