<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = BarangKeluar::with('barang.kategori');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->whereHas('barang', function ($builder) use ($q) {
                $builder->where('nama_barang', 'like', "%{$q}%")
                        ->orWhere('kode_barang', 'like', "%{$q}%");
            });
        }

        $barangKeluars = $query->latest()->paginate(15)->withQueryString();
        $barangs       = Barang::where('stok', '>', 0)->orderBy('nama_barang')->get();

        return view('admin.barang_keluars.index', compact('barangKeluars', 'barangs'));
    }

    public function create()
    {
        $barangs = Barang::where('stok', '>', 0)->orderBy('nama_barang')->get();

        return view('admin.barang_keluars.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id'  => 'required|exists:barangs,id',
            'jumlah'     => 'required|integer|min:1',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'barang_id.required' => 'Barang wajib dipilih.',
            'jumlah.required'    => 'Jumlah wajib diisi.',
            'jumlah.integer'     => 'Jumlah harus berupa angka.',
            'jumlah.min'         => 'Jumlah minimal 1.',
            'tanggal.required'   => 'Tanggal wajib diisi.',
            'tanggal.date'       => 'Format tanggal tidak valid.',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($barang->stok < $request->jumlah) {
            return back()->withErrors([
                'jumlah' => 'Stok tidak mencukupi. Stok tersedia: ' . $barang->stok . ' ' . $barang->satuan . '.',
            ])->withInput();
        }

        DB::transaction(function () use ($request, $barang) {
            BarangKeluar::create($request->only('barang_id', 'jumlah', 'tanggal', 'keterangan'));

            // Kurangi stok barang secara otomatis
            $barang->decrement('stok', $request->jumlah);
        });

        return redirect()->route('admin.barang-keluars.index')
            ->with('success', 'Barang keluar berhasil dicatat. Stok berkurang sebanyak ' . $request->jumlah . '.');
    }

    public function show(BarangKeluar $barangKeluar)
    {
        $barangKeluar->load('barang.kategori');

        return view('admin.barang_keluars.show', compact('barangKeluar'));
    }

    public function edit(BarangKeluar $barangKeluar)
    {
        $barangs = Barang::orderBy('nama_barang')->get();

        return view('admin.barang_keluars.edit', compact('barangKeluar', 'barangs'));
    }

    public function update(Request $request, BarangKeluar $barangKeluar)
    {
        $request->validate([
            'barang_id'  => 'required|exists:barangs,id',
            'jumlah'     => 'required|integer|min:1',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'barang_id.required' => 'Barang wajib dipilih.',
            'jumlah.required'    => 'Jumlah wajib diisi.',
            'jumlah.min'         => 'Jumlah minimal 1.',
            'tanggal.required'   => 'Tanggal wajib diisi.',
        ]);

        DB::transaction(function () use ($request, $barangKeluar) {
            $jumlahLama = $barangKeluar->jumlah;
            $jumlahBaru = $request->jumlah;
            $selisih    = $jumlahBaru - $jumlahLama;

            // Cek stok jika jumlah bertambah
            if ($selisih > 0 && $barangKeluar->barang->stok < $selisih) {
                throw new \Exception('Stok tidak mencukupi untuk perubahan ini.');
            }

            $barangKeluar->update($request->only('barang_id', 'jumlah', 'tanggal', 'keterangan'));

            if ($selisih !== 0) {
                $barangKeluar->barang->decrement('stok', $selisih);
            }
        });

        return redirect()->route('admin.barang-keluars.index')
            ->with('success', 'Data barang keluar berhasil diperbarui.');
    }

    public function destroy(BarangKeluar $barangKeluar)
    {
        DB::transaction(function () use ($barangKeluar) {
            // Kembalikan stok saat data dihapus
            $barangKeluar->barang->increment('stok', $barangKeluar->jumlah);
            $barangKeluar->delete();
        });

        return redirect()->route('admin.barang-keluars.index')
            ->with('success', 'Data barang keluar berhasil dihapus.');
    }
}
