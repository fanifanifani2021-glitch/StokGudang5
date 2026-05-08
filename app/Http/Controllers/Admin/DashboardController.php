<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang    = Barang::count();
        $totalKategori  = Kategori::count();
        $totalSupplier  = Supplier::count();
        $stokMenipis    = Barang::where('stok', '<', 10)->get();
        $barangTerbaru  = Barang::with('kategori')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalBarang',
            'totalKategori',
            'totalSupplier',
            'stokMenipis',
            'barangTerbaru'
        ));
    }
}
