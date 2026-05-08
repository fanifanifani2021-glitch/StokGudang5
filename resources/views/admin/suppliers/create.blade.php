@extends('layouts.admin')

@section('title', 'Tambah Supplier')
@section('page-title', 'Tambah Supplier')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.suppliers.index') }}">Supplier</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="content-card">
            <div class="card-header-custom">
                <h6 class="mb-0 fw-600"><i class="bi bi-plus-circle me-2 text-primary"></i>Form Tambah Supplier</h6>
            </div>
            <div class="p-4">
                <form action="{{ route('admin.suppliers.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_supplier" class="form-label fw-500">
                            Nama Supplier <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="nama_supplier" name="nama_supplier"
                               class="form-control @error('nama_supplier') is-invalid @enderror"
                               value="{{ old('nama_supplier') }}"
                               placeholder="Contoh: PT. Sumber Makmur"
                               autofocus>
                        @error('nama_supplier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-500">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="3"
                                  class="form-control @error('alamat') is-invalid @enderror"
                                  placeholder="Alamat lengkap supplier">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="telepon" class="form-label fw-500">Nomor Telepon</label>
                        <input type="tel" id="telepon" name="telepon"
                               class="form-control @error('telepon') is-invalid @enderror"
                               value="{{ old('telepon') }}"
                               placeholder="021-5551234">
                        @error('telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Simpan Supplier
                        </button>
                        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
