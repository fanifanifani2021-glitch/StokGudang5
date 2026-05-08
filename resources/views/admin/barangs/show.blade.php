@extends('layouts.admin')

@section('title', 'Detail Barang')
@section('page-title', 'Detail Barang')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.barangs.index') }}">Barang</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<div class="row g-4">
    <div class="col-md-5">
        <div class="content-card">
            <div class="card-header-custom">
                <h6 class="mb-0 fw-600"><i class="bi bi-info-circle me-2 text-primary"></i>Informasi Barang</h6>
                <a href="{{ route('admin.barangs.edit', $barang) }}" class="btn btn-sm btn-outline-warning">
                    <i class="bi bi-pencil-fill"></i> Edit
                </a>
            </div>
            <div class="p-4">
                <div class="mb-3 pb-3 border-bottom">
                    <div class="text-muted small mb-1">Kode Barang</div>
                    <code style="font-size:0.9rem;background:#f3f4f6;padding:4px 10px;border-radius:6px;">
                        {{ $barang->kode_barang }}
                    </code>
                </div>
                <div class="mb-3 pb-3 border-bottom">
                    <div class="text-muted small mb-1">Nama Barang</div>
                    <div class="fw-600">{{ $barang->nama_barang }}</div>
                </div>
                <div class="mb-3 pb-3 border-bottom">
                    <div class="text-muted small mb-1">Kategori</div>
                    <span class="badge" style="background:#ede9fe;color:#6d28d9;font-size:0.85rem;">
                        {{ $barang->kategori->nama_kategori ?? '-' }}
                    </span>
                </div>
                <div class="mb-3 pb-3 border-bottom">
                    <div class="text-muted small mb-1">Supplier</div>
                    <div>{{ $barang->supplier->nama_supplier ?? '-' }}</div>
                </div>
                <div class="mb-3 pb-3 border-bottom">
                    <div class="text-muted small mb-1">Stok Saat Ini</div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-700" style="font-size:1.5rem;color:{{ $barang->stok == 0 ? '#ef4444' : ($barang->stok < 10 ? '#f59e0b' : '#059669') }};">
                            {{ $barang->stok }}
                        </span>
                        <span class="text-muted">{{ $barang->satuan }}</span>
                        @if($barang->stok == 0)
                            <span class="badge badge-stok-habis rounded-pill">Habis</span>
                        @elseif($barang->stok < 10)
                            <span class="badge badge-stok-menipis rounded-pill">Menipis</span>
                        @else
                            <span class="badge badge-stok-aman rounded-pill">Aman</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        {{-- Riwayat Barang Masuk --}}
        <div class="content-card mb-4">
            <div class="card-header-custom">
                <h6 class="mb-0 fw-600"><i class="bi bi-box-arrow-in-down-right me-2 text-success"></i>Riwayat Masuk</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th class="text-center">Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang->barangMasuks->take(5) as $masuk)
                            <tr>
                                <td>{{ $masuk->tanggal->format('d M Y') }}</td>
                                <td>{{ $masuk->supplier->nama_supplier ?? '-' }}</td>
                                <td class="text-center fw-600 text-success">+{{ $masuk->jumlah }}</td>
                                <td class="text-muted">{{ $masuk->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">Belum ada riwayat masuk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Riwayat Barang Keluar --}}
        <div class="content-card">
            <div class="card-header-custom">
                <h6 class="mb-0 fw-600"><i class="bi bi-box-arrow-up-right me-2 text-danger"></i>Riwayat Keluar</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th class="text-center">Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang->barangKeluars->take(5) as $keluar)
                            <tr>
                                <td>{{ $keluar->tanggal->format('d M Y') }}</td>
                                <td class="text-center fw-600 text-danger">-{{ $keluar->jumlah }}</td>
                                <td class="text-muted">{{ $keluar->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">Belum ada riwayat keluar.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.barangs.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Barang
    </a>
</div>
@endsection
