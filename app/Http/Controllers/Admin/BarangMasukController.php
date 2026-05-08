<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuks = BarangMasuk::with(['barang', 'supplier'])->latest()->paginate(15);
        $barangs      = Barang::orderBy('nama_barang')->get();
        $suppliers    = Supplier::orderBy('nama_supplier')->get();

        return view('admin.barang_masuks.index', compact('barangMasuks', 'barangs', 'suppliers'));
    }

    public function create()
    {
        $barangs   = Barang::orderBy('nama_barang')->get();
        $suppliers = Supplier::orderBy('nama_supplier')->get();

        return view('admin.barang_masuks.create', compact('barangs', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id'   => 'required|exists:barangs,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'jumlah'      => 'required|integer|min:1',
            'tanggal'     => 'required|date',
            'keterangan'  => 'nullable|string|max:500',
        ], [
            'barang_id.required' => 'Barang wajib dipilih.',
            'barang_id.exists'   => 'Barang tidak valid.',
            'jumlah.required'    => 'Jumlah wajib diisi.',
            'jumlah.integer'     => 'Jumlah harus berupa angka.',
            'jumlah.min'         => 'Jumlah minimal 1.',
            'tanggal.required'   => 'Tanggal wajib diisi.',
            'tanggal.date'       => 'Format tanggal tidak valid.',
        ]);

        DB::transaction(function () use ($request) {
            $masuk = BarangMasuk::create($request->only('barang_id', 'supplier_id', 'jumlah', 'tanggal', 'keterangan'));

            // Tambah stok barang secara otomatis
            $masuk->barang->increment('stok', $request->jumlah);
        });

        return redirect()->route('admin.barang-masuks.index')
            ->with('success', 'Barang masuk berhasil dicatat. Stok bertambah sebanyak ' . $request->jumlah . '.');
    }

    public function show(BarangMasuk $barangMasuk)
    {
        $barangMasuk->load(['barang.kategori', 'supplier']);

        return view('admin.barang_masuks.show', compact('barangMasuk'));
    }

    public function edit(BarangMasuk $barangMasuk)
    {
        $barangs   = Barang::orderBy('nama_barang')->get();
        $suppliers = Supplier::orderBy('nama_supplier')->get();

        return view('admin.barang_masuks.edit', compact('barangMasuk', 'barangs', 'suppliers'));
    }

    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        $request->validate([
            'barang_id'   => 'required|exists:barangs,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'jumlah'      => 'required|integer|min:1',
            'tanggal'     => 'required|date',
            'keterangan'  => 'nullable|string|max:500',
        ], [
            'barang_id.required' => 'Barang wajib dipilih.',
            'jumlah.required'    => 'Jumlah wajib diisi.',
            'jumlah.min'         => 'Jumlah minimal 1.',
            'tanggal.required'   => 'Tanggal wajib diisi.',
        ]);

        DB::transaction(function () use ($request, $barangMasuk) {
            $jumlahLama = $barangMasuk->jumlah;
            $jumlahBaru = $request->jumlah;
            $selisih    = $jumlahBaru - $jumlahLama;

            $barangMasuk->update($request->only('barang_id', 'supplier_id', 'jumlah', 'tanggal', 'keterangan'));

            // Sesuaikan stok berdasarkan selisih
            if ($selisih !== 0) {
                $barangMasuk->barang->increment('stok', $selisih);
            }
        });

        return redirect()->route('admin.barang-masuks.index')
            ->with('success', 'Data barang masuk berhasil diperbarui.');
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        DB::transaction(function () use ($barangMasuk) {
            // Kurangi stok kembali saat data dihapus
            $barangMasuk->barang->decrement('stok', $barangMasuk->jumlah);
            $barangMasuk->delete();
        });

        return redirect()->route('admin.barang-masuks.index')
            ->with('success', 'Data barang masuk berhasil dihapus.');
    }
}
