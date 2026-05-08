<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Akun Admin & Manajer ─────────────────────────────────────────────────
        User::create([
            'name'     => 'Admin Gudang',
            'email'    => 'admin@ungs.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Manajer Gudang',
            'email'    => 'manajer@ungs.com',
            'password' => Hash::make('password'),
            'role'     => 'manajer',
        ]);

        // ─── Kategori ─────────────────────────────────────────────────────────────
        $kategoriData = [
            'Elektronik',
            'Alat Tulis Kantor',
            'Peralatan Rumah Tangga',
            'Makanan & Minuman',
            'Obat-obatan',
            'Pakaian',
        ];

        $kategoris = collect($kategoriData)->map(function ($nama) {
            return Kategori::create(['nama_kategori' => $nama]);
        });

        // ─── Supplier ─────────────────────────────────────────────────────────────
        $supplierData = [
            ['nama_supplier' => 'PT. Sumber Makmur',    'alamat' => 'Jl. Raya No. 10, Jakarta',     'telepon' => '021-5551234'],
            ['nama_supplier' => 'CV. Maju Bersama',     'alamat' => 'Jl. Industri No. 5, Bandung',  'telepon' => '022-6667890'],
            ['nama_supplier' => 'UD. Sejahtera Jaya',   'alamat' => 'Jl. Pahlawan No. 20, Surabaya','telepon' => '031-4445678'],
            ['nama_supplier' => 'PT. Global Distribusi', 'alamat' => 'Jl. Merdeka No. 30, Yogyakarta', 'telepon' => '0274-3334567'],
        ];

        $suppliers = collect($supplierData)->map(function ($data) {
            return Supplier::create($data);
        });

        // ─── Barang ───────────────────────────────────────────────────────────────
        $barangData = [
            ['kode_barang' => 'ELK-001', 'nama_barang' => 'Laptop ASUS VivoBook',   'kategori_id' => $kategoris[0]->id, 'supplier_id' => $suppliers[0]->id, 'stok' => 15, 'satuan' => 'unit'],
            ['kode_barang' => 'ELK-002', 'nama_barang' => 'Monitor Samsung 24"',    'kategori_id' => $kategoris[0]->id, 'supplier_id' => $suppliers[0]->id, 'stok' => 8,  'satuan' => 'unit'],
            ['kode_barang' => 'ELK-003', 'nama_barang' => 'Keyboard Wireless',      'kategori_id' => $kategoris[0]->id, 'supplier_id' => $suppliers[1]->id, 'stok' => 25, 'satuan' => 'pcs'],
            ['kode_barang' => 'ATK-001', 'nama_barang' => 'Kertas A4 80gr',         'kategori_id' => $kategoris[1]->id, 'supplier_id' => $suppliers[1]->id, 'stok' => 100,'satuan' => 'rim'],
            ['kode_barang' => 'ATK-002', 'nama_barang' => 'Pulpen Pilot G2',        'kategori_id' => $kategoris[1]->id, 'supplier_id' => $suppliers[2]->id, 'stok' => 50, 'satuan' => 'box'],
            ['kode_barang' => 'ATK-003', 'nama_barang' => 'Stapler Kangaro',        'kategori_id' => $kategoris[1]->id, 'supplier_id' => $suppliers[2]->id, 'stok' => 3,  'satuan' => 'pcs'],
            ['kode_barang' => 'PRT-001', 'nama_barang' => 'Panci Stainless 28cm',   'kategori_id' => $kategoris[2]->id, 'supplier_id' => $suppliers[3]->id, 'stok' => 20, 'satuan' => 'pcs'],
            ['kode_barang' => 'PRT-002', 'nama_barang' => 'Ember Plastik 20L',      'kategori_id' => $kategoris[2]->id, 'supplier_id' => $suppliers[3]->id, 'stok' => 5,  'satuan' => 'pcs'],
            ['kode_barang' => 'MMN-001', 'nama_barang' => 'Gula Pasir 1kg',         'kategori_id' => $kategoris[3]->id, 'supplier_id' => $suppliers[0]->id, 'stok' => 200,'satuan' => 'kg'],
            ['kode_barang' => 'OBT-001', 'nama_barang' => 'Paracetamol 500mg',      'kategori_id' => $kategoris[4]->id, 'supplier_id' => $suppliers[1]->id, 'stok' => 0,  'satuan' => 'strip'],
        ];

        $barangs = collect($barangData)->map(function ($data) {
            return Barang::create($data);
        });

        // ─── Barang Masuk ─────────────────────────────────────────────────────────
        BarangMasuk::create([
            'barang_id'   => $barangs[0]->id,
            'supplier_id' => $suppliers[0]->id,
            'jumlah'      => 10,
            'tanggal'     => now()->subDays(10)->toDateString(),
            'keterangan'  => 'Pembelian awal stok laptop',
        ]);

        BarangMasuk::create([
            'barang_id'   => $barangs[3]->id,
            'supplier_id' => $suppliers[1]->id,
            'jumlah'      => 50,
            'tanggal'     => now()->subDays(5)->toDateString(),
            'keterangan'  => 'Restock kertas ATK',
        ]);

        BarangMasuk::create([
            'barang_id'   => $barangs[8]->id,
            'supplier_id' => $suppliers[0]->id,
            'jumlah'      => 100,
            'tanggal'     => now()->subDays(3)->toDateString(),
            'keterangan'  => 'Stok gula pasir bulanan',
        ]);

        // ─── Barang Keluar ────────────────────────────────────────────────────────
        BarangKeluar::create([
            'barang_id'  => $barangs[0]->id,
            'jumlah'     => 2,
            'tanggal'    => now()->subDays(7)->toDateString(),
            'keterangan' => 'Distribusi ke cabang Jakarta',
        ]);

        BarangKeluar::create([
            'barang_id'  => $barangs[4]->id,
            'jumlah'     => 10,
            'tanggal'    => now()->subDays(2)->toDateString(),
            'keterangan' => 'Kebutuhan kantor',
        ]);
    }
}
