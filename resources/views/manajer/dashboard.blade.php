@extends('layouts.manajer')

@section('title', 'Laporan Stok')
@section('page-title', 'Laporan Stok Barang')

@section('content')
{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.8rem;font-weight:500;">Total Barang</p>
                    <h2 class="mb-0" style="font-size:2rem;font-weight:700;">{{ $totalBarang }}</h2>
                    <small class="text-muted">jenis barang</small>
                </div>
                <div style="width:48px;height:48px;background:#dbeafe;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;">
                    <i class="bi bi-box-seam-fill text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.8rem;font-weight:500;">Total Kategori</p>
                    <h2 class="mb-0" style="font-size:2rem;font-weight:700;">{{ $totalKategori }}</h2>
                    <small class="text-muted">kategori</small>
                </div>
                <div style="width:48px;height:48px;background:#f3e8ff;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;">
                    <i class="bi bi-tags-fill" style="color:#7c3aed;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="{{ $stokMenipis > 0 ? 'border-color:#fbbf24;' : '' }}">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.8rem;font-weight:500;">Stok Menipis</p>
                    <h2 class="mb-0" style="font-size:2rem;font-weight:700;color:{{ $stokMenipis > 0 ? '#f59e0b' : '#111827' }};">
                        {{ $stokMenipis }}
                    </h2>
                    <small class="text-muted">barang &lt; 10</small>
                </div>
                <div style="width:48px;height:48px;background:#fef3c7;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;">
                    <i class="bi bi-exclamation-triangle-fill" style="color:#f59e0b;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="{{ $stokHabis > 0 ? 'border-color:#ef4444;' : '' }}">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.8rem;font-weight:500;">Stok Habis</p>
                    <h2 class="mb-0" style="font-size:2rem;font-weight:700;color:{{ $stokHabis > 0 ? '#ef4444' : '#111827' }};">
                        {{ $stokHabis }}
                    </h2>
                    <small class="text-muted">barang kosong</small>
                </div>
                <div style="width:48px;height:48px;background:#fee2e2;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;">
                    <i class="bi bi-x-circle-fill" style="color:#ef4444;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Info hanya baca --}}
<div class="alert d-flex align-items-center gap-2 mb-4"
     style="background:#eff6ff;border:1px solid #bfdbfe;color:#1d4ed8;border-radius:10px;">
    <i class="bi bi-eye-fill flex-shrink-0"></i>
    <div><strong>Mode Hanya Baca:</strong> Anda login sebagai Manajer Gudang. Halaman ini hanya menampilkan laporan stok barang.</div>
</div>

{{-- Tabel Laporan Stok --}}
<div class="content-card">
    <div class="card-header-custom">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-bar-chart-fill" style="color:#0f4c75;"></i>
            <h6 class="mb-0 fw-600">Laporan Stok Semua Barang</h6>
        </div>
        <span class="text-muted" style="font-size:0.8rem;">
            <i class="bi bi-calendar3 me-1"></i>{{ now()->format('d F Y, H:i') }}
        </span>
    </div>
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th class="text-center">Stok</th>
                    <th>Satuan</th>
                    <th class="text-center">Status Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $barang)
                    <tr>
                        <td class="text-muted">{{ $barangs->firstItem() + $loop->index }}</td>
                        <td>
                            <code style="font-size:0.78rem;background:#f3f4f6;padding:2px 6px;border-radius:4px;">
                                {{ $barang->kode_barang }}
                            </code>
                        </td>
                        <td class="fw-500">{{ $barang->nama_barang }}</td>
                        <td>
                            <span class="badge" style="background:#ede9fe;color:#6d28d9;">
                                {{ $barang->kategori->nama_kategori ?? '-' }}
                            </span>
                        </td>
                        <td class="text-center fw-600"
                            style="font-size:1.05rem;color:{{ $barang->stok == 0 ? '#ef4444' : ($barang->stok < 10 ? '#f59e0b' : '#059669') }};">
                            {{ $barang->stok }}
                        </td>
                        <td class="text-muted">{{ $barang->satuan }}</td>
                        <td class="text-center">
                            @if($barang->stok == 0)
                                <span class="badge badge-stok-habis px-3 py-1 rounded-pill">
                                    <i class="bi bi-x-circle me-1"></i>Habis
                                </span>
                            @elseif($barang->stok < 10)
                                <span class="badge badge-stok-menipis px-3 py-1 rounded-pill">
                                    <i class="bi bi-exclamation-triangle me-1"></i>Menipis
                                </span>
                            @else
                                <span class="badge badge-stok-aman px-3 py-1 rounded-pill">
                                    <i class="bi bi-check-circle me-1"></i>Aman
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-box-seam" style="font-size:2rem;opacity:0.3;"></i>
                            <p class="mt-2 mb-0">Belum ada data barang.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($barangs->hasPages())
        <div class="p-3 border-top">{{ $barangs->links() }}</div>
    @endif
</div>
@endsection
