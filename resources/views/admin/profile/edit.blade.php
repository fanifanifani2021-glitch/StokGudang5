@extends('layouts.admin')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.profile.show') }}">Profil</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="content-card">
            <div class="card-header-custom">
                <h6 class="mb-0 fw-600">
                    <i class="bi bi-pencil-fill me-2" style="color: var(--primary);"></i>
                    Edit Profil
                </h6>
            </div>

            <form action="{{ route('admin.profile.update') }}" method="POST" style="padding: 1.5rem;">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-500">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}"
                               placeholder="Nama lengkap Anda" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-500">Email / Gmail <span class="text-danger">*</span></label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}"
                               placeholder="contoh@gmail.com" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-500">No. HP</label>
                        <input type="tel" name="no_hp"
                               class="form-control @error('no_hp') is-invalid @enderror"
                               value="{{ old('no_hp', $user->no_hp) }}"
                               placeholder="08xx-xxxx-xxxx">
                        @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-500">Role</label>
                        <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled>
                        <div class="form-text">Role tidak dapat diubah sendiri.</div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-500">Alamat</label>
                        <textarea name="alamat" rows="3"
                                  class="form-control @error('alamat') is-invalid @enderror"
                                  placeholder="Alamat lengkap Anda">{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <hr style="border-color: #f3f4f6; margin: 0.5rem 0;">
                        <small class="text-muted fw-500">
                            <i class="bi bi-lock-fill me-1"></i>
                            Ubah Password (Kosongkan jika tidak ingin mengubah)
                        </small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-500">Password Baru</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Min. 6 karakter">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-500">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                               class="form-control"
                               placeholder="Ulangi password baru">
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="{{ route('admin.profile.show') }}" class="btn btn-outline-secondary btn-sm">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-check-circle me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
