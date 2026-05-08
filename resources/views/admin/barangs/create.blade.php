@extends('layouts.admin')

@section('title', 'Tambah Barang')
@section('page-title', 'Tambah Barang Baru')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.barangs.index') }}">Barang</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="content-card">
            <div class="card-header-custom">
                <h6 class="mb-0 fw-600"><i class="bi bi-plus-circle me-2 text-primary"></i>Form Tambah Barang</h6>
            </div>
            <div class="p-4">
                <form action="{{ route('admin.barangs.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="kode_barang" class="form-label fw-500">
                                Kode Barang <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="kode_barang" name="kode_barang"
                                   class="form-control @error('kode_barang') is-invalid @enderror"
                                   value="{{ old('kode_barang') }}"
                                   placeholder="Contoh: ELK-001">
                            @error('kode_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="nama_barang" class="form-label fw-500">
                                Nama Barang <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="nama_barang" name="nama_barang"
                                   class="form-control @error('nama_barang') is-invalid @enderror"
                                   value="{{ old('nama_barang') }}"
                                   placeholder="Nama lengkap barang">
                            @error('nama_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="kategori_id" class="form-label fw-500">
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <select id="kategori_id" name="kategori_id"
                                    class="form-select @error('kategori_id') is-invalid @enderror">
                                <option value="">— Pilih Kategori —</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}"
                                        {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="supplier_id" class="form-label fw-500">Supplier</label>
                            <select id="supplier_id" name="supplier_id"
                                    class="form-select @error('supplier_id') is-invalid @enderror">
                                <option value="">— Tidak Ada / Pilih Supplier —</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama_supplier }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="stok" class="form-label fw-500">
                                Stok Awal <span class="text-danger">*</span>
                            </label>
                            <input type="number" id="stok" name="stok" min="0"
                                   class="form-control @error('stok') is-invalid @enderror"
                                   value="{{ old('stok', 0) }}"
                                   placeholder="0">
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="satuan" class="form-label fw-500">
                                Satuan <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="satuan" name="satuan"
                                   class="form-control @error('satuan') is-invalid @enderror"
                                   value="{{ old('satuan') }}"
                                   placeholder="Contoh: pcs, kg, rim, unit">
                            @error('satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mt-2">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i>Simpan Barang
                                </button>
                                <a href="{{ route('admin.barangs.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
