@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori Barang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Kategori</li>
        </ol>
    </nav>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle me-1"></i>Tambah Kategori
    </button>
</div>

<div class="content-card">
    <div class="card-header-custom">
        <h6 class="mb-0 fw-600"><i class="bi bi-tags-fill me-2 text-primary"></i>Daftar Kategori Barang</h6>
        <span class="badge bg-primary-subtle text-primary">{{ $kategoris->total() }} kategori</span>
    </div>
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Nama Kategori</th>
                    <th class="text-center">Jumlah Barang</th>
                    <th class="text-center">Dibuat</th>
                    <th class="text-center" style="width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $kategori)
                    <tr>
                        <td class="text-muted">{{ $kategoris->firstItem() + $loop->index }}</td>
                        <td class="fw-500">{{ $kategori->nama_kategori }}</td>
                        <td class="text-center">
                            <span class="badge" style="background:#ede9fe;color:#6d28d9;">
                                {{ $kategori->barangs_count }} barang
                            </span>
                        </td>
                        <td class="text-center text-muted" style="font-size:0.83rem;">
                            {{ $kategori->created_at->format('d M Y') }}
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                {{-- Tombol Edit → buka modal edit --}}
                                <button type="button" class="btn btn-sm btn-outline-primary btn-edit"
                                    data-id="{{ $kategori->id }}"
                                    data-nama="{{ $kategori->nama_kategori }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit"
                                    title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                {{-- Tombol Hapus → buka modal konfirmasi --}}
                                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus"
                                    data-id="{{ $kategori->id }}"
                                    data-nama="{{ $kategori->nama_kategori }}"
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
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-tags" style="font-size:2rem;opacity:0.3;"></i>
                            <p class="mt-2 mb-0">Belum ada data kategori.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($kategoris->hasPages())
        <div class="p-3 border-top">{{ $kategoris->links() }}</div>
    @endif
</div>

{{-- ─── MODAL TAMBAH ───────────────────────────────────────────────────── --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0" style="padding:1.5rem 1.5rem 0.75rem;">
                <h5 class="modal-title fw-700" id="modalTambahLabel">
                    <i class="bi bi-plus-circle-fill text-primary me-2"></i>Tambah Kategori
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.kategoris.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding:1rem 1.5rem;">
                    <div class="mb-1">
                        <label for="nama_kategori_add" class="form-label fw-500">
                            Nama Kategori <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="nama_kategori_add" name="nama_kategori"
                               class="form-control @error('nama_kategori') is-invalid @enderror"
                               value="{{ old('nama_kategori') }}"
                               placeholder="Contoh: Elektronik, Alat Tulis"
                               autofocus>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer border-0" style="padding:0.75rem 1.5rem 1.5rem;">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-check-circle me-1"></i>Simpan Kategori
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
                    <i class="bi bi-pencil-fill text-warning me-2"></i>Edit Kategori
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEdit" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body" style="padding:1rem 1.5rem;">
                    <div class="mb-1">
                        <label for="nama_kategori_edit" class="form-label fw-500">
                            Nama Kategori <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="nama_kategori_edit" name="nama_kategori"
                               class="form-control"
                               placeholder="Nama kategori"
                               required>
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
                <h6 class="fw-700 mb-1">Hapus Kategori?</h6>
                <p class="text-muted mb-0" style="font-size:0.85rem;">
                    Kategori <strong id="namaHapus"></strong> akan dihapus permanen.
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
    // Isi modal Edit dengan data dari tombol
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function () {
            const id   = this.dataset.id;
            const nama = this.dataset.nama;
            document.getElementById('nama_kategori_edit').value = nama;
            document.getElementById('formEdit').action = `/admin/kategoris/${id}`;
        });
    });

    // Isi modal Hapus
    document.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.addEventListener('click', function () {
            const id   = this.dataset.id;
            const nama = this.dataset.nama;
            document.getElementById('namaHapus').textContent = nama;
            document.getElementById('formHapus').action = `/admin/kategoris/${id}`;
        });
    });

    // Buka modal tambah otomatis jika ada error validasi (setelah submit gagal)
    @if($errors->any() && !old('_method'))
        const modalTambah = new bootstrap.Modal(document.getElementById('modalTambah'));
        modalTambah.show();
    @endif
</script>
@endpush
