@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
{{-- Breadcrumb --}}
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
</nav>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.8rem;font-weight:500;">Total Barang</p>
                    <h2 class="fw-700 mb-0" style="font-size:2rem;font-weight:700;">{{ $totalBarang }}</h2>
                    <small class="text-muted">jenis barang tercatat</small>
                </div>
                <div class="stat-icon" style="background:#dbeafe;">
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
                    <h2 class="fw-700 mb-0" style="font-size:2rem;font-weight:700;">{{ $totalKategori }}</h2>
                    <small class="text-muted">kategori barang</small>
                </div>
                <div class="stat-icon" style="background:#f3e8ff;">
                    <i class="bi bi-tags-fill" style="color:#7c3aed;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.8rem;font-weight:500;">Total Supplier</p>
                    <h2 class="fw-700 mb-0" style="font-size:2rem;font-weight:700;">{{ $totalSupplier }}</h2>
                    <small class="text-muted">mitra supplier</small>
                </div>
                <div class="stat-icon" style="background:#d1fae5;">
                    <i class="bi bi-truck-front-fill" style="color:#059669;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="{{ $stokMenipis->count() > 0 ? 'border-color:#fbbf24;' : '' }}">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1" style="font-size:0.8rem;font-weight:500;">Stok Menipis</p>
                    <h2 class="fw-700 mb-0" style="font-size:2rem;font-weight:700;color:{{ $stokMenipis->count() > 0 ? '#f59e0b' : '#111827' }};">
                        {{ $stokMenipis->count() }}
                    </h2>
                    <small class="text-muted">barang stok &lt; 10</small>
                </div>
                <div class="stat-icon" style="background:#fef3c7;">
                    <i class="bi bi-exclamation-triangle-fill" style="color:#f59e0b;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Stok Menipis --}}
    <div class="col-lg-6">
        <div class="content-card h-100">
            <div class="card-header-custom">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                    <h6 class="mb-0 fw-600">Peringatan Stok Menipis</h6>
                </div>
                <a href="{{ route('admin.barangs.index') }}" class="btn btn-sm btn-outline-primary" style="font-size:0.78rem;">
                    Lihat Semua
                </a>
            </div>
            @if($stokMenipis->count() > 0)
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Stok</th>
                                <th>Satuan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stokMenipis as $item)
                                <tr>
                                    <td class="fw-500">{{ $item->nama_barang }}</td>
                                    <td>
                                        <span class="fw-600" style="color:{{ $item->stok == 0 ? '#ef4444' : '#f59e0b' }};">
                                            {{ $item->stok }}
                                        </span>
                                    </td>
                                    <td>{{ $item->satuan }}</td>
                                    <td>
                                        @if($item->stok == 0)
                                            <span class="badge badge-stok-habis px-2 py-1 rounded-pill">Habis</span>
                                        @else
                                            <span class="badge badge-stok-menipis px-2 py-1 rounded-pill">Menipis</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-4 text-center text-muted">
                    <i class="bi bi-check-circle-fill text-success" style="font-size:2rem;"></i>
                    <p class="mt-2 mb-0">Semua stok barang dalam kondisi aman.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Barang Terbaru --}}
    <div class="col-lg-6">
        <div class="content-card h-100">
            <div class="card-header-custom">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-clock-history text-primary"></i>
                    <h6 class="mb-0 fw-600">Barang Terbaru Ditambahkan</h6>
                </div>
            </div>
            @if($barangTerbaru->count() > 0)
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangTerbaru as $barang)
                                <tr>
                                    <td><code style="font-size:0.78rem;background:#f3f4f6;padding:2px 6px;border-radius:4px;">{{ $barang->kode_barang }}</code></td>
                                    <td class="fw-500">{{ $barang->nama_barang }}</td>
                                    <td><span class="badge" style="background:#ede9fe;color:#6d28d9;font-weight:500;">{{ $barang->kategori->nama_kategori ?? '-' }}</span></td>
                                    <td>{{ $barang->stok }} {{ $barang->satuan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-4 text-center text-muted">
                    <p class="mb-0">Belum ada data barang.</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="row g-3 mt-1">
    <div class="col-12">
        <div class="content-card">
            <div class="card-header-custom">
                <h6 class="mb-0 fw-600"><i class="bi bi-lightning-fill text-warning me-2"></i>Aksi Cepat</h6>
            </div>
            <div class="p-3 d-flex flex-wrap gap-2">
                <a href="{{ route('admin.barangs.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Barang
                </a>
                <a href="{{ route('admin.barang-masuks.create') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-box-arrow-in-down-right me-1"></i>Catat Barang Masuk
                </a>
                <a href="{{ route('admin.barang-keluars.create') }}" class="btn btn-danger btn-sm">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Catat Barang Keluar
                </a>
                <a href="{{ route('admin.suppliers.create') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-truck-front me-1"></i>Tambah Supplier
                </a>
                <a href="{{ route('admin.kategoris.create') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-tags me-1"></i>Tambah Kategori
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
