@extends('layouts.admin')

@section('title', 'Profil Saya')
@section('page-title', 'Profil')

@section('content')
<div class="d-flex justify-content-center">
    <div style="width: 100%; max-width: 700px;">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-check-circle-fill"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="content-card">
            {{-- Avatar + Nama --}}
            <div style="padding: 2.5rem 2rem 1.5rem; text-align: center;">
                <div style="width:72px;height:72px;background:#e5e7eb;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;border:2px solid #d1d5db;">
                    <i class="bi bi-person-fill" style="font-size:2.2rem;color:#6b7280;"></i>
                </div>
                <h5 style="font-weight:700;font-size:1.2rem;margin-bottom:0;">{{ $user->name }}</h5>
            </div>

            <hr style="margin:0;border-color:#e5e7eb;">

            {{-- Field rows sesuai UI client --}}
            <div style="padding:1.25rem 2rem;">

                <div class="profile-field">
                    <span class="profile-label">Nama:</span>
                    <span class="profile-value">{{ $user->name }}</span>
                </div>

                <div class="profile-field">
                    <span class="profile-label">Gmail:</span>
                    <span class="profile-value">{{ $user->email }}</span>
                </div>

                <div class="profile-field">
                    <span class="profile-label">NO.HP:</span>
                    <span class="profile-value">{{ $user->no_hp ?? '—' }}</span>
                </div>

                <div class="profile-field">
                    <span class="profile-label">Alamat:</span>
                    <span class="profile-value">{{ $user->alamat ?? '—' }}</span>
                </div>

                <div class="profile-field" style="margin-bottom:0;">
                    <span class="profile-label">Role:</span>
                    <span class="profile-value">{{ ucfirst($user->role) }}</span>
                </div>
            </div>

            {{-- Edit button --}}
            <div style="padding:1.25rem 2rem 2rem; text-align:center;">
                <a href="{{ route('admin.profile.edit') }}"
                   style="display:inline-block;background:#4a6450;color:white;padding:0.65rem 2.5rem;border-radius:6px;font-weight:600;font-size:0.9rem;text-decoration:none;transition:background 0.2s;"
                   onmouseover="this.style.background='#3d5442'"
                   onmouseout="this.style.background='#4a6450'">
                    Edit profil
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.profile-field {
    display: flex;
    align-items: flex-start;
    background: #f3f4f6;
    border-radius: 8px;
    padding: 0.85rem 1.25rem;
    margin-bottom: 0.75rem;
}
.profile-label {
    font-weight: 600;
    font-size: 0.9rem;
    color: #374151;
    min-width: 80px;
    flex-shrink: 0;
}
.profile-value {
    font-size: 0.9rem;
    color: #374151;
    margin-left: 0.5rem;
}
</style>
@endsection
