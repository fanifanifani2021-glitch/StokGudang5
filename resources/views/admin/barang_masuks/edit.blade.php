@extends('layouts.admin')

@section('title', 'Edit Barang Masuk')
@section('page-title', 'Edit Barang Masuk')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.barang-masuks.index') }}">Barang Masuk</a></li>
            <li class="breadcrumb-item active">Edit #{{ $barangMasuk->id }}</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="content-card">
            <div class="card-header-custom">
                <h6 class="mb-0 fw-600"><i class="bi bi-pencil-fill me-2 text-warning"></i>Edit Data Barang Masuk</h6>
            </div>
            <div class="p-4">
                <form action="{{ route('admin.barang-masuks.update', $barangMasuk) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="barang_id" class="form-label fw-500">Barang <span class="text-danger">*</span></label>
                        <select id="barang_id" name="barang_id" class="form-select @error('barang_id') is-invalid @enderror">
                            <option value="">— Pilih Barang —</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->id }}"
                                    {{ old('barang_id', $barangMasuk->barang_id) == $barang->id ? 'selected' : '' }}>
                                    [{{ $barang->kode_barang }}] {{ $barang->nama_barang }}
                                </option>
                            @endforeach
                        </select>
                        @error('barang_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="supplier_id" class="form-label fw-500">Supplier</label>
                        <select id="supplier_id" name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror">
                            <option value="">— Tidak Ada —</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ old('supplier_id', $barangMasuk->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->nama_supplier }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="jumlah" class="form-label fw-500">Jumlah Masuk <span class="text-danger">*</span></label>
                            <input type="number" id="jumlah" name="jumlah" min="1"
                                   class="form-control @error('jumlah') is-invalid @enderror"
                                   value="{{ old('jumlah', $barangMasuk->jumlah) }}">
                            @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label fw-500">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" id="tanggal" name="tanggal"
                                   class="form-control @error('tanggal') is-invalid @enderror"
                                   value="{{ old('tanggal', $barangMasuk->tanggal->toDateString()) }}">
                            @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4 mt-3">
                        <label for="keterangan" class="form-label fw-500">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" rows="3"
                                  class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $barangMasuk->keterangan) }}</textarea>
                        @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning text-white">
                            <i class="bi bi-check-circle me-1"></i>Perbarui Data
                        </button>
                        <a href="{{ route('admin.barang-masuks.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
