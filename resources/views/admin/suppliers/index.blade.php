@extends('layouts.admin')

@section('title', 'Data Supplier')
@section('page-title', 'Data Supplier')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 gap-2 flex-wrap">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Supplier</li>
        </ol>
    </nav>
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <form method="GET" action="{{ route('admin.suppliers.index') }}" class="d-flex gap-2">
            <div class="input-group input-group-sm" style="min-width:220px;">
                <span class="input-group-text" style="background:#f9fafb;border-color:#e5e7eb;">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama supplier…"
                       value="{{ request('search') }}"
                       style="border-color:#e5e7eb;">
                @if(request('search'))
                    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
            <button type="submit" class="btn btn-outline-secondary btn-sm">Cari</button>
        </form>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle me-1"></i>Tambah Supplier
        </button>
    </div>
</div>

<div class="content-card">
    <div class="card-header-custom">
        <h6 class="mb-0 fw-600"><i class="bi bi-truck-front-fill me-2 text-success"></i>Daftar Supplier</h6>
        <span class="badge bg-success-subtle text-success">{{ $suppliers->total() }} supplier</span>
    </div>
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Nama Supplier</th>
                    <th>No Hp</th>
                    <th>Alamat</th>
                    <th>Kategori</th>
                    <th class="text-center">Barang</th>
                    <th class="text-center" style="width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                    <tr>
                        <td class="text-muted">{{ $suppliers->firstItem() + $loop->index }}</td>
                        <td class="fw-500">{{ $supplier->nama_supplier }}</td>
                        <td>
                            @if($supplier->telepon)
                                <a href="tel:{{ $supplier->telepon }}" class="text-decoration-none">
                                    {{ $supplier->telepon }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-muted" style="max-width:180px;font-size:0.83rem;">
                            <span style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                {{ $supplier->alamat ?? '-' }}
                            </span>
                        </td>
                        <td>
                            @if($supplier->kategori)
                                {{ $supplier->kategori->nama_kategori }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge" style="background:#d1fae5;color:#065f46;">
                                {{ $supplier->barangs_count }} barang
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <button type="button" class="btn btn-sm btn-outline-primary btn-edit"
                                    data-id="{{ $supplier->id }}"
                                    data-nama="{{ $supplier->nama_supplier }}"
                                    data-kategori="{{ $supplier->kategori_id }}"
                                    data-alamat="{{ $supplier->alamat }}"
                                    data-telepon="{{ $supplier->telepon }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit"
                                    title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus"
                                    data-id="{{ $supplier->id }}"
                                    data-nama="{{ $supplier->nama_supplier }}"
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
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-truck-front" style="font-size:2rem;opacity:0.3;"></i>
                            <p class="mt-2 mb-0">Belum ada data supplier.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($suppliers->hasPages())
        <div class="p-3 border-top">{{ $suppliers->links() }}</div>
    @endif
</div>

{{-- ─── MODAL TAMBAH ───────────────────────────────────────────────────── --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0" style="padding:1.5rem 1.5rem 0.75rem;">
                <h5 class="modal-title fw-700" id="modalTambahLabel">
                    <i class="bi bi-plus-circle-fill text-primary me-2"></i>Tambah Supplier
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.suppliers.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding:1rem 1.5rem;">
                    <div class="mb-3">
                        <label class="form-label fw-500">Nama Supplier <span class="text-danger">*</span></label>
                        <input type="text" name="nama_supplier"
                               class="form-control @error('nama_supplier') is-invalid @enderror"
                               value="{{ old('nama_supplier') }}"
                               placeholder="Contoh: PT. Sumber Makmur" required>
                        @error('nama_supplier') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500">Kategori</label>
                        <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror">
                            <option value="">— Pilih Kategori —</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500">Alamat</label>
                        <textarea name="alamat" rows="2"
                                  class="form-control @error('alamat') is-invalid @enderror"
                                  placeholder="Alamat lengkap supplier">{{ old('alamat') }}</textarea>
                        @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-1">
                        <label class="form-label fw-500">Nomor Telepon</label>
                        <input type="tel" name="telepon"
                               class="form-control @error('telepon') is-invalid @enderror"
                               value="{{ old('telepon') }}"
                               placeholder="021-5551234">
                        @error('telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer border-0" style="padding:0.75rem 1.5rem 1.5rem;">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-check-circle me-1"></i>Simpan Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ─── MODAL EDIT ─────────────────────────────────────────────────────── --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0" style="padding:1.5rem 1.5rem 0.75rem;">
                <h5 class="modal-title fw-700" id="modalEditLabel">
                    <i class="bi bi-pencil-fill text-warning me-2"></i>Edit Supplier
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEdit" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body" style="padding:1rem 1.5rem;">
                    <div class="mb-3">
                        <label class="form-label fw-500">Nama Supplier <span class="text-danger">*</span></label>
                        <input type="text" id="edit_nama" name="nama_supplier" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500">Kategori</label>
                        <select id="edit_kategori" name="kategori_id" class="form-select">
                            <option value="">— Pilih Kategori —</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500">Alamat</label>
                        <textarea id="edit_alamat" name="alamat" rows="2" class="form-control"></textarea>
                    </div>
                    <div class="mb-1">
                        <label class="form-label fw-500">Nomor Telepon</label>
                        <input type="tel" id="edit_telepon" name="telepon" class="form-control">
                    </div>
                </div>
                <div class="modal-footer border-0" style="padding:0.75rem 1.5rem 1.5rem;">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-white btn-sm">
                        <i class="bi bi-check-circle me-1"></i>Perbarui
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
                <h6 class="fw-700 mb-1">Hapus Supplier?</h6>
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
            document.getElementById('edit_nama').value     = this.dataset.nama;
            document.getElementById('edit_kategori').value = this.dataset.kategori || '';
            document.getElementById('edit_alamat').value   = this.dataset.alamat || '';
            document.getElementById('edit_telepon').value  = this.dataset.telepon || '';
            document.getElementById('formEdit').action     = `/admin/suppliers/${this.dataset.id}`;
        });
    });

    document.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('namaHapus').textContent = this.dataset.nama;
            document.getElementById('formHapus').action      = `/admin/suppliers/${this.dataset.id}`;
        });
    });

    @if($errors->any() && !old('_method'))
        const modalTambah = new bootstrap.Modal(document.getElementById('modalTambah'));
        modalTambah.show();
    @endif
</script>
@endpush
