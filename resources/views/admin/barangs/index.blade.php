@extends('layouts.admin')

@section('title', 'Data Barang')
@section('page-title', 'Data Barang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 gap-2 flex-wrap">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Barang</li>
        </ol>
    </nav>
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <form method="GET" action="{{ route('admin.barangs.index') }}" class="d-flex gap-2">
            <div class="input-group input-group-sm" style="min-width:220px;">
                <span class="input-group-text" style="background:#f9fafb;border-color:#e5e7eb;">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama / kode barang…"
                       value="{{ request('search') }}"
                       style="border-color:#e5e7eb;">
                @if(request('search'))
                    <a href="{{ route('admin.barangs.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
            <button type="submit" class="btn btn-outline-secondary btn-sm">Cari</button>
        </form>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle me-1"></i>Tambah Barang
        </button>
    </div>
</div>

<div class="content-card">
    <div class="card-header-custom">
        <h6 class="mb-0 fw-600"><i class="bi bi-box-seam-fill me-2 text-primary"></i>Daftar Barang</h6>
        <span class="badge bg-primary-subtle text-primary">{{ $barangs->total() }} barang</span>
    </div>
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>kategori</th>
                    <th>Nama Supplier</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center" style="width:110px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $barang)
                    <tr>
                        <td class="text-muted">{{ $barangs->firstItem() + $loop->index }}</td>
                        <td style="font-size:0.83rem;">{{ $barang->kode_barang }}</td>
                        <td class="fw-500">{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                        <td class="text-muted" style="font-size:0.83rem;">
                            {{ $barang->supplier->nama_supplier ?? '-' }}
                        </td>
                        <td class="text-center fw-600"
                            style="color:{{ $barang->stok == 0 ? '#ef4444' : ($barang->stok < 10 ? '#f59e0b' : '#111827') }};">
                            {{ $barang->stok }} {{ $barang->satuan }}
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('admin.barangs.show', $barang) }}"
                                   class="btn btn-sm btn-outline-secondary" title="Detail">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-primary btn-edit"
                                    data-id="{{ $barang->id }}"
                                    data-kode="{{ $barang->kode_barang }}"
                                    data-nama="{{ $barang->nama_barang }}"
                                    data-kategori="{{ $barang->kategori_id }}"
                                    data-supplier="{{ $barang->supplier_id }}"
                                    data-stok="{{ $barang->stok }}"
                                    data-satuan="{{ $barang->satuan }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit"
                                    title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus"
                                    data-id="{{ $barang->id }}"
                                    data-nama="{{ $barang->nama_barang }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalHapus"
                                    title="Hapus">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="bi bi-box-seam" style="font-size:2rem;opacity:0.3;"></i>
                            <p class="mt-2 mb-0">Belum ada data barang.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($barangs->hasPages())
        <div class="p-3 border-top">{{ $barangs->links() }}</div>
    @endif
</div>

{{-- ─── MODAL TAMBAH ───────────────────────────────────────────────────── --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0" style="padding:1.5rem 1.5rem 0.75rem;">
                <h5 class="modal-title fw-700">
                    <i class="bi bi-plus-circle-fill text-primary me-2"></i>Tambah Barang Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.barangs.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding:1rem 1.5rem;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-500">Kode Barang <span class="text-danger">*</span></label>
                            <input type="text" name="kode_barang"
                                   class="form-control @error('kode_barang') is-invalid @enderror"
                                   value="{{ old('kode_barang') }}"
                                   placeholder="Contoh: ELK-001" required>
                            @error('kode_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" name="nama_barang"
                                   class="form-control @error('nama_barang') is-invalid @enderror"
                                   value="{{ old('nama_barang') }}"
                                   placeholder="Nama lengkap barang" required>
                            @error('nama_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                                <option value="">— Pilih Kategori —</option>
                                @foreach($kategoris as $kat)
                                    <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">Supplier</label>
                            <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror">
                                <option value="">— Tidak Ada —</option>
                                @foreach($suppliers as $sup)
                                    <option value="{{ $sup->id }}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>
                                        {{ $sup->nama_supplier }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">Stok Awal <span class="text-danger">*</span></label>
                            <input type="number" name="stok" min="0"
                                   class="form-control @error('stok') is-invalid @enderror"
                                   value="{{ old('stok', 0) }}" required>
                            @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">Satuan <span class="text-danger">*</span></label>
                            <input type="text" name="satuan"
                                   class="form-control @error('satuan') is-invalid @enderror"
                                   value="{{ old('satuan') }}"
                                   placeholder="pcs, kg, rim, unit" required>
                            @error('satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0" style="padding:0.75rem 1.5rem 1.5rem;">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-check-circle me-1"></i>Simpan Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ─── MODAL EDIT ─────────────────────────────────────────────────────── --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0" style="padding:1.5rem 1.5rem 0.75rem;">
                <h5 class="modal-title fw-700">
                    <i class="bi bi-pencil-fill text-warning me-2"></i>Edit Barang
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEdit" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body" style="padding:1rem 1.5rem;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-500">Kode Barang <span class="text-danger">*</span></label>
                            <input type="text" id="edit_kode" name="kode_barang" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" id="edit_nama" name="nama_barang" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">Kategori <span class="text-danger">*</span></label>
                            <select id="edit_kategori" name="kategori_id" class="form-select" required>
                                <option value="">— Pilih Kategori —</option>
                                @foreach($kategoris as $kat)
                                    <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">Supplier</label>
                            <select id="edit_supplier" name="supplier_id" class="form-select">
                                <option value="">— Tidak Ada —</option>
                                @foreach($suppliers as $sup)
                                    <option value="{{ $sup->id }}">{{ $sup->nama_supplier }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">Stok <span class="text-danger">*</span></label>
                            <input type="number" id="edit_stok" name="stok" min="0" class="form-control" required>
                            <div class="form-text">Perubahan stok sebaiknya lewat Barang Masuk/Keluar.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">Satuan <span class="text-danger">*</span></label>
                            <input type="text" id="edit_satuan" name="satuan" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0" style="padding:0.75rem 1.5rem 1.5rem;">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-white btn-sm">
                        <i class="bi bi-check-circle me-1"></i>Perbarui Barang
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
                <h6 class="fw-700 mb-1">Hapus Barang?</h6>
                <p class="text-muted mb-0" style="font-size:0.85rem;">
                    <strong id="namaHapus"></strong> akan dihapus permanen.
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
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('edit_kode').value        = this.dataset.kode;
            document.getElementById('edit_nama').value        = this.dataset.nama;
            document.getElementById('edit_stok').value        = this.dataset.stok;
            document.getElementById('edit_satuan').value      = this.dataset.satuan;
            document.getElementById('edit_kategori').value    = this.dataset.kategori;
            document.getElementById('edit_supplier').value    = this.dataset.supplier || '';
            document.getElementById('formEdit').action        = `/admin/barangs/${this.dataset.id}`;
        });
    });

    document.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('namaHapus').textContent = this.dataset.nama;
            document.getElementById('formHapus').action      = `/admin/barangs/${this.dataset.id}`;
        });
    });

    @if($errors->any() && !old('_method'))
        const modalTambah = new bootstrap.Modal(document.getElementById('modalTambah'));
        modalTambah.show();
    @endif
</script>
@endpush
