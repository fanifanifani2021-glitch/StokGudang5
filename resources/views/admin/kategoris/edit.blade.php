@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.kategoris.index') }}">Kategori</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="content-card">
            <div class="card-header-custom">
                <h6 class="mb-0 fw-600"><i class="bi bi-pencil-fill me-2 text-warning"></i>Edit Kategori</h6>
            </div>
            <div class="p-4">
                <form action="{{ route('admin.kategoris.update', $kategori) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="nama_kategori" class="form-label fw-500">
                            Nama Kategori <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               id="nama_kategori"
                               name="nama_kategori"
                               class="form-control @error('nama_kategori') is-invalid @enderror"
                               value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                               placeholder="Contoh: Elektronik, Alat Tulis"
                               autofocus>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning text-white">
                            <i class="bi bi-check-circle me-1"></i>Perbarui Kategori
                        </button>
                        <a href="{{ route('admin.kategoris.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
