<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::with('kategori')->withCount('barangs');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($builder) use ($q) {
                $builder->where('nama_supplier', 'like', "%{$q}%")
                        ->orWhere('alamat', 'like', "%{$q}%")
                        ->orWhere('telepon', 'like', "%{$q}%");
            });
        }

        $suppliers = $query->latest()->paginate(10)->withQueryString();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.suppliers.index', compact('suppliers', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('admin.suppliers.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:150',
            'kategori_id'   => 'nullable|exists:kategoris,id',
            'alamat'        => 'nullable|string',
            'telepon'       => 'nullable|string|max:20',
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'nama_supplier.max'      => 'Nama supplier maksimal 150 karakter.',
            'telepon.max'            => 'Nomor telepon maksimal 20 karakter.',
        ]);

        Supplier::create($request->only('nama_supplier', 'kategori_id', 'alamat', 'telepon'));

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function show(Supplier $supplier)
    {
        return view('admin.suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('admin.suppliers.edit', compact('supplier', 'kategoris'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:150',
            'kategori_id'   => 'nullable|exists:kategoris,id',
            'alamat'        => 'nullable|string',
            'telepon'       => 'nullable|string|max:20',
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'nama_supplier.max'      => 'Nama supplier maksimal 150 karakter.',
            'telepon.max'            => 'Nomor telepon maksimal 20 karakter.',
        ]);

        $supplier->update($request->only('nama_supplier', 'kategori_id', 'alamat', 'telepon'));

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}
