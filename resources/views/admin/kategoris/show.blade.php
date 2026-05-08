@extends('layouts.admin')

@section('title', 'Detail Kategori')
@section('page-title', 'Detail Kategori')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.kategoris.index') }}">Kategori</a></li>
            <li class="breadcrumb-item active">{{ $kategori->nama_kategori }}</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="content-card">
            <div class="card-header-custom">
                <h6 class="mb-0 fw-600"><i class="bi bi-tags-fill me-2 text-primary"></i>Detail Kategori</h6>
                <a href="{{ route('admin.kategoris.edit', $kategori) }}" class="btn btn-sm btn-outline-warning">
                    <i class="bi bi-pencil-fill"></i> Edit
                </a>
            </div>
            <div class="p-4">
                <dl class="row">
                    <dt class="col-sm-4 text-muted">Nama Kategori</dt>
                    <dd class="col-sm-8 fw-600">{{ $kategori->nama_kategori }}</dd>
                    <dt class="col-sm-4 text-muted">Jumlah Barang</dt>
                    <dd class="col-sm-8">{{ $kategori->barangs->count() }} barang</dd>
                    <dt class="col-sm-4 text-muted">Dibuat</dt>
                    <dd class="col-sm-8">{{ $kategori->created_at->format('d M Y') }}</dd>
                </dl>
            </div>
            <div class="p-3 border-top">
                <a href="{{ route('admin.kategoris.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
