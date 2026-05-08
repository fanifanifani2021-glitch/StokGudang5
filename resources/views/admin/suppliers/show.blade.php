@extends('layouts.admin')

@section('title', 'Detail Supplier')
@section('page-title', 'Detail Supplier')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.suppliers.index') }}">Supplier</a></li>
            <li class="breadcrumb-item active">{{ $supplier->nama_supplier }}</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="content-card">
            <div class="card-header-custom">
                <h6 class="mb-0 fw-600"><i class="bi bi-truck-front-fill me-2 text-success"></i>Detail Supplier</h6>
                <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-sm btn-outline-warning">
                    <i class="bi bi-pencil-fill"></i> Edit
                </a>
            </div>
            <div class="p-4">
                <dl class="row">
                    <dt class="col-sm-4 text-muted">Nama Supplier</dt>
                    <dd class="col-sm-8 fw-600">{{ $supplier->nama_supplier }}</dd>
                    <dt class="col-sm-4 text-muted">Alamat</dt>
                    <dd class="col-sm-8">{{ $supplier->alamat ?? '-' }}</dd>
                    <dt class="col-sm-4 text-muted">Telepon</dt>
                    <dd class="col-sm-8">{{ $supplier->telepon ?? '-' }}</dd>
                    <dt class="col-sm-4 text-muted">Jumlah Barang</dt>
                    <dd class="col-sm-8">{{ $supplier->barangs->count() }} barang</dd>
                </dl>
            </div>
            <div class="p-3 border-top">
                <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
