@extends('layouts.admin')

@section('title', 'Catat Barang Keluar')
@section('page-title', 'Catat Barang Keluar')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.barang-keluars.index') }}">Barang Keluar</a></li>
            <li class="breadcrumb-item active">Catat Baru</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="content-card">
            <div class="card-header-custom" style="background:linear-gradient(135deg,#fff1f2,#ffe4e6);border-bottom:1px solid #fecdd3;">
                <div class="d-flex align-items-center gap-2">
                    <div style="width:36px;height:36px;background:#ef4444;border-radius:10px;display:flex;align-items:center;justify-content:center;color:white;">
                        <i class="bi bi-box-arrow-up-right"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-600">Form Barang Keluar</h6>
                        <small class="text-muted">Stok akan otomatis berkurang</small>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <form action="{{ route('admin.barang-keluars.store') }}" method="POST">
                    @csrf

                    @if($barangs->isEmpty())
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Tidak ada barang dengan stok tersedia. Tambahkan stok barang terlebih dahulu.
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="barang_id" class="form-label fw-500">
                            Barang <span class="text-danger">*</span>
                        </label>
                        <select id="barang_id" name="barang_id"
                                class="form-select @error('barang_id') is-invalid @enderror">
                            <option value="">— Pilih Barang —</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->id }}"
                                    data-stok="{{ $barang->stok }}"
                                    data-satuan="{{ $barang->satuan }}"
                                    {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                    [{{ $barang->kode_barang }}] {{ $barang->nama_barang }}
                                    (Stok: {{ $barang->stok }} {{ $barang->satuan }})
                                </option>
                            @endforeach
                        </select>
                        @error('barang_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="stok-info" class="form-text"></div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="jumlah" class="form-label fw-500">
                                Jumlah Keluar <span class="text-danger">*</span>
                            </label>
                            <input type="number" id="jumlah" name="jumlah" min="1"
                                   class="form-control @error('jumlah') is-invalid @enderror"
                                   value="{{ old('jumlah') }}"
                                   placeholder="Contoh: 5">
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="tanggal" class="form-label fw-500">
                                Tanggal Keluar <span class="text-danger">*</span>
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
                                  placeholder="Tujuan atau keterangan pengeluaran barang (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-check-circle me-1"></i>Simpan & Kurangi Stok
                        </button>
                        <a href="{{ route('admin.barang-keluars.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('barang_id').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const stok    = selected.dataset.stok;
        const satuan  = selected.dataset.satuan;
        const info    = document.getElementById('stok-info');

        if (stok !== undefined) {
            info.innerHTML = `<i class="bi bi-info-circle me-1"></i>Stok tersedia: <strong>${stok} ${satuan}</strong>`;
            document.getElementById('jumlah').max = stok;
        } else {
            info.innerHTML = '';
        }
    });
</script>
@endpush
