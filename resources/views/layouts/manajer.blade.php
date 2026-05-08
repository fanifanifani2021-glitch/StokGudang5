<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Stok Gudang - Panel Manajer">
    <title>@yield('title', 'Laporan Stok') — UNGS Manajer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 240px;
            --sidebar-bg: #3d5442;
            --sidebar-hover: #4a6450;
            --sidebar-active: #6a9c6e;
            --primary: #6a9c6e;
            --body-bg: #f4f7f4;
        }

        * { font-family: 'Inter', sans-serif; }
        body { background-color: var(--body-bg); overflow-x: hidden; }

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
            padding: 1.5rem 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 0.5rem;
        }

        .sidebar-brand .brand-icon {
            width: 52px; height: 52px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.4rem;
            border: 2px solid rgba(255,255,255,0.3);
        }

        .sidebar-brand .brand-text { color: white; font-weight: 700; font-size: 1.05rem; }
        .sidebar-brand .brand-sub  { color: rgba(255,255,255,0.45); font-size: 0.7rem; }

        .sidebar-menu { padding: 1rem 0; flex: 1; }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 1.5rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            margin: 0.1rem 0.75rem;
            border-radius: 8px;
        }

        .sidebar-link:hover  { color: white; background: var(--sidebar-hover); }
        .sidebar-link.active { color: white; background: var(--sidebar-active); }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            height: 60px;
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

        .topbar-title { font-size:1rem; font-weight:600; color:#111827; }

        .page-content { padding: 1.5rem; flex: 1; }

        .stat-card {
            background: white;
            border-radius: 14px;
            padding: 1.25rem;
            border: 1px solid #e5e7eb;
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); }

        .content-card { background: white; border-radius: 14px; border: 1px solid #e5e7eb; overflow: hidden; }
        .card-header-custom {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #f3f4f6;
            background: #fafafa;
        }

        .table-custom thead th {
            background: #f9fafb;
            font-size: 0.78rem;
            font-weight: 600;
            color: #6b7280;
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

        .badge-stok-aman    { background: #d1fae5; color: #065f46; }
        .badge-stok-menipis { background: #fef3c7; color: #92400e; }
        .badge-stok-habis   { background: #fee2e2; color: #991b1b; }

        .fw-500 { font-weight: 500; }
        .fw-600 { font-weight: 600; }

        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

<nav id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="bi bi-boxes"></i></div>
        <div>
            <div class="brand-text">UNGS</div>
            <div class="brand-sub">Panel Manajer</div>
        </div>
    </div>

    <div class="sidebar-menu">
        <a href="{{ route('manajer.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('manajer.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i>
            Dashboard
        </a>
        <a href="{{ route('manajer.profile.show') }}"
           class="sidebar-link {{ request()->routeIs('manajer.profile.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i>
            Profil Saya
        </a>
    </div>

    <div class="sidebar-footer">
        <a href="{{ route('manajer.profile.show') }}" class="d-flex align-items-center gap-2 mb-3 text-decoration-none"
           style="transition:opacity 0.2s;" onmouseover="this.style.opacity='0.75'" onmouseout="this.style.opacity='1'">
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

<div id="main-content">
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-outline-secondary d-md-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="bi bi-list"></i>
            </button>
            <span class="topbar-title">@yield('page-title', 'Laporan Stok')</span>
        </div>
        <div class="dropdown">
            <button class="btn p-0 border-0 bg-transparent d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                <div style="width:34px;height:34px;background:var(--sidebar-active);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:0.85rem;font-weight:700;">
                    <i class="bi bi-person-fill" style="font-size:1.1rem;"></i>
                </div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="min-width:160px;border:1px solid #e5e7eb;border-radius:10px;">
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('manajer.profile.show') }}" style="font-size:0.875rem;">
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

    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
