@extends('layouts.admin')

@section('title', 'Barang Masuk')
@section('page-title', 'Barang Masuk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Barang Masuk</li>
        </ol>
    </nav>
    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle me-1"></i>Catat Barang Masuk
    </button>
</div>

<div class="content-card">
    <div class="card-header-custom">
        <h6 class="mb-0 fw-600"><i class="bi bi-box-arrow-in-down-right me-2 text-success"></i>Riwayat Barang Masuk</h6>
        <span class="badge bg-success-subtle text-success">{{ $barangMasuks->total() }} transaksi</span>
    </div>
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Supplier</th>
                    <th class="text-center">Jumlah Masuk</th>
                    <th>Keterangan</th>
                    <th class="text-center" style="width:80px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangMasuks as $item)
                    <tr>
                        <td class="text-muted">{{ $barangMasuks->firstItem() + $loop->index }}</td>
                        <td>{{ $item->tanggal->format('d M Y') }}</td>
                        <td>
                            <code style="font-size:0.78rem;background:#f3f4f6;padding:2px 6px;border-radius:4px;">
                                {{ $item->barang->kode_barang }}
                            </code>
                        </td>
                        <td class="fw-500">{{ $item->barang->nama_barang }}</td>
                        <td class="text-muted">{{ $item->supplier->nama_supplier ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge bg-success-subtle text-success fw-600" style="font-size:0.88rem;">
                                +{{ $item->jumlah }} {{ $item->barang->satuan }}
                            </span>
                        </td>
                        <td class="text-muted" style="font-size:0.83rem;">{{ $item->keterangan ?? '-' }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger btn-hapus"
                                data-id="{{ $item->id }}"
                                data-nama="{{ $item->barang->nama_barang }}"
                                data-jumlah="{{ $item->jumlah }}"
                                data-satuan="{{ $item->barang->satuan }}"
                                data-bs-toggle="modal"
                                data-bs-target="#modalHapus"
                                title="Hapus">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-box-arrow-in-down-right" style="font-size:2rem;opacity:0.3;"></i>
                            <p class="mt-2 mb-0">Belum ada data barang masuk.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($barangMasuks->hasPages())
        <div class="p-3 border-top">{{ $barangMasuks->links() }}</div>
    @endif
</div>

{{-- ─── MODAL CATAT BARANG MASUK ───────────────────────────────────────── --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0" style="padding:1.5rem 1.5rem 0.75rem;background:linear-gradient(135deg,#f0fdf4,#dcfce7);border-radius:16px 16px 0 0;">
                <div class="d-flex align-items-center gap-2">
                    <div style="width:36px;height:36px;background:#22c55e;border-radius:10px;display:flex;align-items:center;justify-content:center;color:white;">
                        <i class="bi bi-box-arrow-in-down-right"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-700 mb-0">Catat Barang Masuk</h5>
                        <small class="text-muted">Stok akan otomatis bertambah</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.barang-masuks.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding:1.25rem 1.5rem;">
                    <div class="mb-3">
                        <label class="form-label fw-500">Barang <span class="text-danger">*</span></label>
                        <select name="barang_id" class="form-select @error('barang_id') is-invalid @enderror" id="selectBarangMasuk" required>
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
                        @error('barang_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500">Supplier</label>
                        <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror">
                            <option value="">— Tidak Ada / Pilih Supplier —</option>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>
                                    {{ $sup->nama_supplier }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-500">Jumlah Masuk <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah" min="1"
                                   class="form-control @error('jumlah') is-invalid @enderror"
                                   value="{{ old('jumlah') }}"
                                   placeholder="Contoh: 50" required>
                            @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal"
                                   class="form-control @error('tanggal') is-invalid @enderror"
                                   value="{{ old('tanggal', now()->toDateString()) }}" required>
                            @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label fw-500">Keterangan</label>
                        <textarea name="keterangan" rows="2"
                                  class="form-control @error('keterangan') is-invalid @enderror"
                                  placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer border-0" style="padding:0.75rem 1.5rem 1.5rem;">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="bi bi-check-circle me-1"></i>Simpan & Tambah Stok
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ─── MODAL HAPUS ─────────────────────────────────────────────────────── --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-body text-center p-4">
                <div style="width:56px;height:56px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                    <i class="bi bi-trash-fill text-danger" style="font-size:1.4rem;"></i>
                </div>
                <h6 class="fw-700 mb-1">Hapus Data Ini?</h6>
                <p class="text-muted mb-0" style="font-size:0.85rem;">
                    Data masuk <strong id="namaHapus"></strong>
                    sebanyak <strong id="jumlahHapus"></strong>
                    akan dihapus dan stok akan dikurangi kembali.
                </p>
            </div>
            <div class="modal-footer border-0 pt-0 justify-content-center pb-4 gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <form id="formHapus" action="" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash-fill me-1"></i>Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('namaHapus').textContent  = this.dataset.nama;
            document.getElementById('jumlahHapus').textContent = this.dataset.jumlah + ' ' + this.dataset.satuan;
            document.getElementById('formHapus').action       = `/admin/barang-masuks/${this.dataset.id}`;
        });
    });

    @if($errors->any() && !old('_method'))
        const modalTambah = new bootstrap.Modal(document.getElementById('modalTambah'));
        modalTambah.show();
    @endif
</script>
@endpush
