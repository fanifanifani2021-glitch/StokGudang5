@extends('layouts.admin')

@section('title', 'Detail Barang Keluar')
@section('page-title', 'Detail Barang Keluar')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.barang-keluars.index') }}">Barang Keluar</a></li>
            <li class="breadcrumb-item active">Detail #{{ $barangKeluar->id }}</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="content-card">
            <div class="card-header-custom" style="background:linear-gradient(135deg,#fff1f2,#ffe4e6);border-bottom:1px solid #fecdd3;">
                <h6 class="mb-0 fw-600">
                    <i class="bi bi-box-arrow-up-right me-2 text-danger"></i>Detail Pengeluaran Barang
                </h6>
                <span class="badge bg-danger">Keluar</span>
            </div>
            <div class="p-4">
                <dl class="row mb-0">
                    <dt class="col-sm-4 text-muted fw-500">Tanggal</dt>
                    <dd class="col-sm-8 fw-500">{{ $barangKeluar->tanggal->format('d F Y') }}</dd>

                    <dt class="col-sm-4 text-muted fw-500">Kode Barang</dt>
                    <dd class="col-sm-8">
                        <code style="background:#f3f4f6;padding:2px 8px;border-radius:5px;">
                            {{ $barangKeluar->barang->kode_barang }}
                        </code>
                    </dd>

                    <dt class="col-sm-4 text-muted fw-500">Nama Barang</dt>
                    <dd class="col-sm-8 fw-600">{{ $barangKeluar->barang->nama_barang }}</dd>

                    <dt class="col-sm-4 text-muted fw-500">Kategori</dt>
                    <dd class="col-sm-8">
                        <span class="badge" style="background:#ede9fe;color:#6d28d9;">
                            {{ $barangKeluar->barang->kategori->nama_kategori ?? '-' }}
                        </span>
                    </dd>

                    <dt class="col-sm-4 text-muted fw-500">Jumlah Keluar</dt>
                    <dd class="col-sm-8">
                        <span class="text-danger fw-700" style="font-size:1.2rem;">
                            -{{ $barangKeluar->jumlah }} {{ $barangKeluar->barang->satuan }}
                        </span>
                    </dd>

                    <dt class="col-sm-4 text-muted fw-500">Keterangan</dt>
                    <dd class="col-sm-8">{{ $barangKeluar->keterangan ?? '-' }}</dd>

                    <dt class="col-sm-4 text-muted fw-500">Dicatat Pada</dt>
                    <dd class="col-sm-8 text-muted" style="font-size:0.83rem;">{{ $barangKeluar->created_at->format('d M Y, H:i') }}</dd>
                </dl>
            </div>
            <div class="p-3 border-top d-flex gap-2">
                <a href="{{ route('admin.barang-keluars.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
