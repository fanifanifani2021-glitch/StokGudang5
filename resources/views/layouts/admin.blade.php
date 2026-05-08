<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Stok Gudang - Panel Admin">
    <title>@yield('title', 'Dashboard') — UNGS Admin</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #3d5442;
            --sidebar-hover: #4a6450;
            --sidebar-active: #6a9c6e;
            --topbar-height: 60px;
            --primary: #6a9c6e;
            --primary-light: #7ab87e;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --body-bg: #f4f7f4;
            --card-bg: #ffffff;
            --text-muted: #6b7280;
        }

        * { font-family: 'Inter', sans-serif; }
        body { background-color: var(--body-bg); overflow-x: hidden; }

        /* ── Sidebar ─────────────────────────────── */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            z-index: 1040;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-brand .brand-icon {
            width: 52px; height: 52px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.4rem;
            border: 2px solid rgba(255,255,255,0.3);
        }

        .sidebar-brand .brand-text {
            color: white;
            font-weight: 700;
            font-size: 1.05rem;
            line-height: 1.2;
        }

        .sidebar-brand .brand-sub {
            color: rgba(255,255,255,0.45);
            font-size: 0.7rem;
            font-weight: 400;
        }

        .sidebar-menu {
            padding: 1rem 0;
            flex: 1;
            overflow-y: auto;
        }

        .sidebar-label {
            color: rgba(255,255,255,0.35);
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0.5rem 1.5rem 0.25rem;
            margin-top: 0.5rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 1.5rem;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0;
            transition: all 0.2s ease;
            margin: 0.1rem 0.75rem;
            border-radius: 8px;
        }

        .sidebar-link:hover {
            color: white;
            background: var(--sidebar-hover);
        }

        .sidebar-link.active {
            color: white;
            background: var(--sidebar-active);
        }

        .sidebar-link .nav-icon {
            width: 20px;
            font-size: 1rem;
            text-align: center;
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        /* ── Main Content ────────────────────────── */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Topbar ──────────────────────────────── */
        .topbar {
            height: var(--topbar-height);
            background: white;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .topbar-title {
            font-size: 1rem;
            font-weight: 600;
            color: #111827;
        }

        /* ── Cards ───────────────────────────────── */
        .stat-card {
            background: var(--card-bg);
            border-radius: 14px;
            padding: 1.25rem;
            border: 1px solid #e5e7eb;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.08); }

        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }

        .content-card {
            background: white;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .content-card .card-header-custom {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* ── Table ───────────────────────────────── */
        .table-custom thead th {
            background: #f9fafb;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.75rem 1rem;
        }

        .table-custom tbody td {
            padding: 0.85rem 1rem;
            vertical-align: middle;
            font-size: 0.875rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .table-custom tbody tr:last-child td { border-bottom: none; }
        .table-custom tbody tr:hover { background: #f9fafb; }

        /* ── Badges ──────────────────────────────── */
        .badge-stok-aman     { background: #d1fae5; color: #065f46; }
        .badge-stok-menipis  { background: #fef3c7; color: #92400e; }
        .badge-stok-habis    { background: #fee2e2; color: #991b1b; }

        /* ── Buttons ─────────────────────────────── */
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-light); border-color: var(--primary-light); }

        /* ── Page Content ────────────────────────── */
        .page-content { padding: 1.5rem; flex: 1; }

        /* ── Flash Messages ──────────────────────── */
        .alert { border-radius: 10px; font-size: 0.875rem; }

        /* ── Responsive ──────────────────────────── */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<nav id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="bi bi-boxes"></i></div>
        <div>
            <div class="brand-text">UNGS</div>
            <div class="brand-sub">Panel Admin</div>
        </div>
    </div>

    <div class="sidebar-menu">
        <div class="sidebar-label">Utama</div>
        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-grid-1x2-fill"></i></span>
            Dashboard
        </a>

        <div class="sidebar-label">Master Data</div>
        <a href="{{ route('admin.kategoris.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.kategoris.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-tags-fill"></i></span>
            Kategori Barang
        </a>
        <a href="{{ route('admin.barangs.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.barangs.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-box-seam-fill"></i></span>
            Data Barang
        </a>
        <a href="{{ route('admin.suppliers.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-truck-front-fill"></i></span>
            Data Supplier
        </a>

        <div class="sidebar-label">Transaksi</div>
        <a href="{{ route('admin.barang-masuks.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.barang-masuks.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-box-arrow-in-down-right"></i></span>
            Barang Masuk
        </a>
        <a href="{{ route('admin.barang-keluars.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.barang-keluars.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-box-arrow-up-right"></i></span>
            Barang Keluar
        </a>

        <div class="sidebar-label">Akun</div>
        <a href="{{ route('admin.profile.show') }}"
           class="sidebar-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="bi bi-person-circle"></i></span>
            Profil Saya
        </a>
    </div>

    <div class="sidebar-footer">
        <a href="{{ route('admin.profile.show') }}" class="d-flex align-items-center gap-2 mb-3 text-decoration-none" style="transition:opacity 0.2s;" onmouseover="this.style.opacity='0.75'" onmouseout="this.style.opacity='1'">
            <div style="width:32px;height:32px;background:var(--sidebar-active);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:0.8rem;font-weight:600;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <div style="color:white;font-size:0.8rem;font-weight:500;">{{ auth()->user()->name }}</div>
                <div style="color:rgba(255,255,255,0.4);font-size:0.7rem;">
                    <i class="bi bi-person-fill me-1"></i>Lihat Profil
                </div>
            </div>
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm w-100 text-start"
                    style="color:rgba(255,255,255,0.6);background:rgba(255,255,255,0.07);border:none;border-radius:8px;padding:0.5rem 0.75rem;">
                <i class="bi bi-box-arrow-left me-2"></i>Logout
            </button>
        </form>
    </div>
</nav>

{{-- Main Content --}}
<div id="main-content">
    {{-- Topbar --}}
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-outline-secondary d-md-none" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="dropdown">
            <button class="btn p-0 border-0 bg-transparent d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                <div style="width:34px;height:34px;background:var(--sidebar-active);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:0.85rem;font-weight:700;">
                    <i class="bi bi-person-fill" style="font-size:1.1rem;"></i>
                </div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="min-width:160px;border:1px solid #e5e7eb;border-radius:10px;">
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.profile.show') }}" style="font-size:0.875rem;">
                        <i class="bi bi-person-circle text-muted"></i> profil
                    </a>
                </li>
                <li><hr class="dropdown-divider my-1"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex align-items-center gap-2" style="font-size:0.875rem;color:#ef4444;">
                            <i class="bi bi-box-arrow-right"></i> logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    {{-- Page Content --}}
    <div class="page-content">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Terdapat kesalahan pada input:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sidebar toggle for mobile
    document.getElementById('sidebarToggle')?.addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('show');
    });
</script>
@stack('scripts')
</body>
</html>
