@extends('layouts.admin')

@section('title', 'Barang Keluar')
@section('page-title', 'Barang Keluar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 gap-2 flex-wrap">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Barang Keluar</li>
        </ol>
    </nav>
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <form method="GET" action="{{ route('admin.barang-keluars.index') }}" class="d-flex gap-2">
            <div class="input-group input-group-sm" style="min-width:220px;">
                <span class="input-group-text" style="background:#f9fafb;border-color:#e5e7eb;">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama / kode barang…"
                       value="{{ request('search') }}"
                       style="border-color:#e5e7eb;">
                @if(request('search'))
                    <a href="{{ route('admin.barang-keluars.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
            <button type="submit" class="btn btn-outline-secondary btn-sm">Cari</button>
        </form>
        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle me-1"></i>Catat Barang Keluar
        </button>
    </div>
</div>

<div class="content-card">
    <div class="card-header-custom">
        <h6 class="mb-0 fw-600"><i class="bi bi-box-arrow-up-right me-2 text-danger"></i>Riwayat Barang Keluar</h6>
        <span class="badge bg-danger-subtle text-danger">{{ $barangKeluars->total() }} transaksi</span>
    </div>
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>kategori</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-center" style="width:110px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangKeluars as $item)
                    <tr>
                        <td class="text-muted">{{ $barangKeluars->firstItem() + $loop->index }}</td>
                        <td style="font-size:0.83rem;">{{ $item->barang->kode_barang }}</td>
                        <td class="fw-500">{{ $item->barang->nama_barang }}</td>
                        <td>{{ $item->barang->kategori->nama_kategori ?? '-' }}</td>
                        <td class="text-center fw-600">{{ $item->jumlah }} {{ $item->barang->satuan }}</td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <button type="button" class="btn btn-sm btn-outline-primary btn-edit"
                                    data-id="{{ $item->id }}"
                                    data-barang="{{ $item->barang_id }}"
                                    data-jumlah="{{ $item->jumlah }}"
                                    data-tanggal="{{ $item->tanggal->format('Y-m-d') }}"
                                    data-keterangan="{{ $item->keterangan }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit"
                                    title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
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
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-box-arrow-up-right" style="font-size:2rem;opacity:0.3;"></i>
                            <p class="mt-2 mb-0">Belum ada data barang keluar.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($barangKeluars->hasPages())
        <div class="p-3 border-top">{{ $barangKeluars->links() }}</div>
    @endif
</div>

{{-- ─── MODAL CATAT BARANG KELUAR ──────────────────────────────────────── --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0" style="padding:1.5rem 1.5rem 0.75rem;background:linear-gradient(135deg,#fff1f2,#ffe4e6);border-radius:16px 16px 0 0;">
                <div class="d-flex align-items-center gap-2">
                    <div style="width:36px;height:36px;background:#ef4444;border-radius:10px;display:flex;align-items:center;justify-content:center;color:white;">
                        <i class="bi bi-box-arrow-up-right"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-700 mb-0">Catat Barang Keluar</h5>
                        <small class="text-muted">Stok akan otomatis berkurang</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.barang-keluars.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding:1.25rem 1.5rem;">

                    @if($barangs->isEmpty())
                        <div class="alert alert-warning py-2 mb-3" style="font-size:0.85rem;">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Tidak ada barang dengan stok tersedia.
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-500">Barang <span class="text-danger">*</span></label>
                        <select name="barang_id" id="selectBarangKeluar"
                                class="form-select @error('barang_id') is-invalid @enderror" required>
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
                        <div id="stokInfo" class="form-text mt-1"></div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-500">Jumlah Keluar <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah" id="inputJumlahKeluar" min="1"
                                   class="form-control @error('jumlah') is-invalid @enderror"
                                   value="{{ old('jumlah') }}"
                                   placeholder="Contoh: 5" required>
                            @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">Tanggal Keluar <span class="text-danger">*</span></label>
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
                                  placeholder="Tujuan atau keterangan pengeluaran (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer border-0" style="padding:0.75rem 1.5rem 1.5rem;">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="bi bi-check-circle me-1"></i>Simpan & Kurangi Stok
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ─── MODAL EDIT ─────────────────────────────────────────────────────── --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0" style="padding:1.5rem 1.5rem 0.75rem;">
                <h5 class="modal-title fw-700">
                    <i class="bi bi-pencil-fill text-warning me-2"></i>Edit Barang Keluar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEdit" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body" style="padding:1rem 1.5rem;">
                    <div class="mb-3">
                        <label class="form-label fw-500">Barang <span class="text-danger">*</span></label>
                        <select id="edit_barang" name="barang_id" class="form-select" required>
                            <option value="">— Pilih Barang —</option>
                            @foreach(\App\Models\Barang::orderBy('nama_barang')->get() as $b)
                                <option value="{{ $b->id }}">
                                    [{{ $b->kode_barang }}] {{ $b->nama_barang }} (Stok: {{ $b->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-500">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" id="edit_jumlah" name="jumlah" min="1" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-500">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" id="edit_tanggal" name="tanggal" class="form-control" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label fw-500">Keterangan</label>
                        <textarea id="edit_keterangan" name="keterangan" rows="2" class="form-control" placeholder="Keterangan (opsional)"></textarea>
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
                <h6 class="fw-700 mb-1">Hapus Data Ini?</h6>
                <p class="text-muted mb-0" style="font-size:0.85rem;">
                    Data keluar <strong id="namaHapus"></strong>
                    sebanyak <strong id="jumlahHapus"></strong>
                    akan dihapus dan stok akan dikembalikan.
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
    // Tampilkan info stok tersisa saat pilih barang
    document.getElementById('selectBarangKeluar').addEventListener('change', function () {
        const opt    = this.options[this.selectedIndex];
        const stok   = opt.dataset.stok;
        const satuan = opt.dataset.satuan;
        const info   = document.getElementById('stokInfo');
        const input  = document.getElementById('inputJumlahKeluar');

        if (stok !== undefined) {
            info.innerHTML = `<i class="bi bi-info-circle me-1"></i>Stok tersedia: <strong>${stok} ${satuan}</strong>`;
            input.max = stok;
        } else {
            info.innerHTML = '';
            input.removeAttribute('max');
        }
    });

    // Modal edit
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('edit_barang').value      = this.dataset.barang;
            document.getElementById('edit_jumlah').value      = this.dataset.jumlah;
            document.getElementById('edit_tanggal').value     = this.dataset.tanggal;
            document.getElementById('edit_keterangan').value  = this.dataset.keterangan || '';
            document.getElementById('formEdit').action        = `/admin/barang-keluars/${this.dataset.id}`;
        });
    });

    // Modal hapus
    document.querySelectorAll('.btn-hapus').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('namaHapus').textContent  = this.dataset.nama;
            document.getElementById('jumlahHapus').textContent = this.dataset.jumlah + ' ' + this.dataset.satuan;
            document.getElementById('formHapus').action       = `/admin/barang-keluars/${this.dataset.id}`;
        });
    });

    @if($errors->any() && !old('_method'))
        const modalTambah = new bootstrap.Modal(document.getElementById('modalTambah'));
        modalTambah.show();
    @endif
</script>
@endpush

