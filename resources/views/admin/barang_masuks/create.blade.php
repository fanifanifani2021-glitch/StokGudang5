@extends('layouts.admin')

@section('title', 'Catat Barang Masuk')
@section('page-title', 'Catat Barang Masuk')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.barang-masuks.index') }}">Barang Masuk</a></li>
            <li class="breadcrumb-item active">Catat Baru</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="content-card">
            <div class="card-header-custom" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);border-bottom:1px solid #bbf7d0;">
                <div class="d-flex align-items-center gap-2">
                    <div style="width:36px;height:36px;background:#22c55e;border-radius:10px;display:flex;align-items:center;justify-content:center;color:white;">
                        <i class="bi bi-box-arrow-in-down-right"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-600">Form Barang Masuk</h6>
                        <small class="text-muted">Stok akan otomatis bertambah</small>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <form action="{{ route('admin.barang-masuks.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="barang_id" class="form-label fw-500">
                            Barang <span class="text-danger">*</span>
                        </label>
                        <select id="barang_id" name="barang_id"
                                class="form-select @error('barang_id') is-invalid @enderror">
                            <option value="">— Pilih Barang —</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->id }}"
                                    {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                    [{{ $barang->kode_barang }}] {{ $barang->nama_barang }}
                                    (Stok: {{ $barang->stok }} {{ $barang->satuan }})
                                </option>
                            @endforeach
                        </select>
                        @error('barang_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
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

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="jumlah" class="form-label fw-500">
                                Jumlah Masuk <span class="text-danger">*</span>
                            </label>
                            <input type="number" id="jumlah" name="jumlah" min="1"
                                   class="form-control @error('jumlah') is-invalid @enderror"
                                   value="{{ old('jumlah') }}"
                                   placeholder="Contoh: 50">
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="tanggal" class="form-label fw-500">
                                Tanggal Masuk <span class="text-danger">*</span>
                            </label>
                            <input type="date" id="tanggal" name="tanggal"
                                   class="form-control @error('tanggal') is-invalid @enderror"
                                   value="{{ old('tanggal', now()->toDateString()) }}">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4 mt-3">
                        <label for="keterangan" class="form-label fw-500">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" rows="3"
                                  class="form-control @error('keterangan') is-invalid @enderror"
                                  placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i>Simpan & Tambah Stok
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
