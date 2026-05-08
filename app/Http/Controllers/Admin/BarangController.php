<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with(['kategori', 'supplier']);

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($builder) use ($q) {
                $builder->where('nama_barang', 'like', "%{$q}%")
                        ->orWhere('kode_barang', 'like', "%{$q}%");
            });
        }

        $barangs   = $query->latest()->paginate(10)->withQueryString();
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $suppliers = Supplier::orderBy('nama_supplier')->get();

        return view('admin.barangs.index', compact('barangs', 'kategoris', 'suppliers'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $suppliers = Supplier::orderBy('nama_supplier')->get();

        return view('admin.barangs.create', compact('kategoris', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang'  => 'required|string|max:50|unique:barangs,kode_barang',
            'nama_barang'  => 'required|string|max:200',
            'kategori_id'  => 'required|exists:kategoris,id',
            'supplier_id'  => 'nullable|exists:suppliers,id',
            'stok'         => 'required|integer|min:0',
            'satuan'       => 'required|string|max:50',
        ], [
            'kode_barang.required'  => 'Kode barang wajib diisi.',
            'kode_barang.unique'    => 'Kode barang sudah digunakan.',
            'nama_barang.required'  => 'Nama barang wajib diisi.',
            'kategori_id.required'  => 'Kategori wajib dipilih.',
            'kategori_id.exists'    => 'Kategori tidak valid.',
            'stok.required'         => 'Stok wajib diisi.',
            'stok.integer'          => 'Stok harus berupa angka.',
            'stok.min'              => 'Stok tidak boleh negatif.',
            'satuan.required'       => 'Satuan wajib diisi.',
        ]);

        Barang::create($request->only('kode_barang', 'nama_barang', 'kategori_id', 'supplier_id', 'stok', 'satuan'));

        return redirect()->route('admin.barangs.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        $barang->load(['kategori', 'supplier', 'barangMasuks.supplier', 'barangKeluars']);

        return view('admin.barangs.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $suppliers = Supplier::orderBy('nama_supplier')->get();

        return view('admin.barangs.edit', compact('barang', 'kategoris', 'suppliers'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'kode_barang'  => 'required|string|max:50|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang'  => 'required|string|max:200',
            'kategori_id'  => 'required|exists:kategoris,id',
            'supplier_id'  => 'nullable|exists:suppliers,id',
            'stok'         => 'required|integer|min:0',
            'satuan'       => 'required|string|max:50',
        ], [
            'kode_barang.required'  => 'Kode barang wajib diisi.',
            'kode_barang.unique'    => 'Kode barang sudah digunakan.',
            'nama_barang.required'  => 'Nama barang wajib diisi.',
            'kategori_id.required'  => 'Kategori wajib dipilih.',
            'stok.required'         => 'Stok wajib diisi.',
            'stok.integer'          => 'Stok harus berupa angka.',
            'stok.min'              => 'Stok tidak boleh negatif.',
            'satuan.required'       => 'Satuan wajib diisi.',
        ]);

        $barang->update($request->only('kode_barang', 'nama_barang', 'kategori_id', 'supplier_id', 'stok', 'satuan'));

        return redirect()->route('admin.barangs.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('admin.barangs.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}
