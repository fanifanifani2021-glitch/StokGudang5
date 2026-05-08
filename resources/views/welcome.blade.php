<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="UNGS – Unit Niaga Gudang Strategis">
    <title>UNGS – Unit Niaga Gudang Strategis</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body {
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* Background foto gudang dengan overlay blur */
        .hero-bg {
            position: fixed;
            inset: 0;
            background:
                linear-gradient(135deg, rgba(58,75,60,0.82) 0%, rgba(34,45,36,0.88) 100%),
                url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=1920&q=80') center/cover no-repeat;
            filter: blur(0px);
            z-index: 0;
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background: inherit;
            filter: blur(3px);
            z-index: -1;
        }

        /* Overlay gradient */
        .hero-overlay {
            position: fixed;
            inset: 0;
            background: linear-gradient(
                180deg,
                rgba(30, 42, 32, 0.6) 0%,
                rgba(22, 32, 24, 0.75) 50%,
                rgba(15, 22, 16, 0.9) 100%
            );
            z-index: 1;
        }

        /* Content wrapper */
        .hero-content {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Navbar ─────────────────────────────── */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 3rem;
        }

        .navbar-logo {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            text-decoration: none;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #7a9c7e, #5c7a60);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
            box-shadow: 0 4px 15px rgba(90,130,94,0.4);
        }

        .logo-text {
            color: white;
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 0.05em;
        }

        .logo-sub {
            color: rgba(255,255,255,0.55);
            font-size: 0.7rem;
            font-weight: 400;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            display: block;
            margin-top: -2px;
        }

        .btn-login {
            background: rgba(255,255,255,0.12);
            color: white;
            border: 1.5px solid rgba(255,255,255,0.3);
            padding: 0.6rem 1.75rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-login:hover {
            background: rgba(255,255,255,0.22);
            border-color: rgba(255,255,255,0.55);
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            color: white;
        }

        /* ── Hero Main ───────────────────────────── */
        .hero-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem 1.5rem;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(122,156,126,0.2);
            border: 1px solid rgba(122,156,126,0.4);
            color: #a8d4ac;
            padding: 0.4rem 1.1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            animation: fadeInUp 0.6s ease forwards;
        }

        .hero-title {
            font-size: clamp(2.2rem, 6vw, 4.5rem);
            font-weight: 900;
            color: white;
            line-height: 1.1;
            letter-spacing: -0.02em;
            margin-bottom: 1.5rem;
            animation: fadeInUp 0.7s 0.1s ease forwards;
            opacity: 0;
        }

        .hero-title .accent {
            background: linear-gradient(135deg, #a8d4ac, #7ab87e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.15rem;
            color: rgba(255,255,255,0.65);
            max-width: 560px;
            line-height: 1.7;
            margin-bottom: 3rem;
            font-weight: 400;
            animation: fadeInUp 0.7s 0.2s ease forwards;
            opacity: 0;
        }

        .hero-cta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            animation: fadeInUp 0.7s 0.3s ease forwards;
            opacity: 0;
        }

        .btn-cta-primary {
            background: linear-gradient(135deg, #6a9c6e, #4d7d51);
            color: white;
            padding: 0.85rem 2.5rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 30px rgba(74,125,78,0.4);
        }

        .btn-cta-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 40px rgba(74,125,78,0.55);
            color: white;
        }

        .btn-cta-secondary {
            background: rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.85);
            padding: 0.85rem 2rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 500;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            border: 1.5px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .btn-cta-secondary:hover {
            background: rgba(255,255,255,0.15);
            border-color: rgba(255,255,255,0.4);
            color: white;
            transform: translateY(-2px);
        }

        /* ── Stats Bar ───────────────────────────── */
        .stats-bar {
            display: flex;
            justify-content: center;
            gap: 3rem;
            padding: 2rem 3rem;
            border-top: 1px solid rgba(255,255,255,0.08);
            animation: fadeInUp 0.7s 0.4s ease forwards;
            opacity: 0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-num {
            color: white;
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            display: block;
        }

        .stat-label {
            color: rgba(255,255,255,0.45);
            font-size: 0.75rem;
            font-weight: 400;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        /* ── Feature Cards ───────────────────────── */
        .feature-strip {
            display: flex;
            justify-content: center;
            gap: 1rem;
            padding: 0 3rem 2rem;
            flex-wrap: wrap;
            animation: fadeInUp 0.7s 0.5s ease forwards;
            opacity: 0;
        }

        .feature-pill {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            color: rgba(255,255,255,0.7);
            padding: 0.5rem 1.1rem;
            border-radius: 50px;
            font-size: 0.82rem;
            backdrop-filter: blur(8px);
            transition: all 0.2s ease;
        }

        .feature-pill:hover {
            background: rgba(255,255,255,0.12);
            color: white;
        }

        .feature-pill i { color: #a8d4ac; font-size: 0.9rem; }

        /* ── Animations ──────────────────────────── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Floating particles */
        .particle {
            position: fixed;
            width: 4px; height: 4px;
            background: rgba(168,212,172,0.4);
            border-radius: 50%;
            animation: float linear infinite;
            z-index: 2;
        }

        @keyframes float {
            0%   { transform: translateY(100vh) translateX(0); opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 1; }
            100% { transform: translateY(-10vh) translateX(30px); opacity: 0; }
        }

        @media (max-width: 640px) {
            .navbar { padding: 1.25rem 1.5rem; }
            .stats-bar { gap: 1.5rem; flex-wrap: wrap; }
            .feature-strip { padding: 0 1.5rem 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>

    {{-- Floating particles --}}
    <div class="particle" style="left:10%;animation-duration:12s;animation-delay:0s;"></div>
    <div class="particle" style="left:25%;animation-duration:18s;animation-delay:3s;width:3px;height:3px;"></div>
    <div class="particle" style="left:50%;animation-duration:15s;animation-delay:6s;width:5px;height:5px;opacity:0.3;"></div>
    <div class="particle" style="left:75%;animation-duration:20s;animation-delay:1s;width:3px;height:3px;"></div>
    <div class="particle" style="left:90%;animation-duration:14s;animation-delay:8s;"></div>

    <div class="hero-content">
        {{-- Navbar --}}
        <nav class="navbar">
            <a href="#" class="navbar-logo">
                <div class="logo-icon">
                    <i class="bi bi-boxes"></i>
                </div>
                <div>
                    <span class="logo-text">UNGS</span>
                    <span class="logo-sub">Warehouse System</span>
                </div>
            </a>
            <a href="{{ route('login') }}" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i>
                Login
            </a>
        </nav>

        {{-- Hero --}}
        <div class="hero-main">
            <div class="hero-badge">
                <i class="bi bi-lightning-charge-fill"></i>
                Sistem Manajemen Gudang Modern
            </div>

            <h1 class="hero-title">
                Apk UNGS<br>
                <span class="accent">(Unit Niaga Gudang Strategis)</span>
            </h1>

            <p class="hero-subtitle">
                Kelola stok barang, supplier, dan transaksi gudang Anda secara real-time dengan sistem yang efisien, akurat, dan mudah digunakan.
            </p>

            <div class="hero-cta">
                <a href="{{ route('login') }}" class="btn-cta-primary">
                    <i class="bi bi-grid-fill"></i>
                    Mulai Sekarang
                </a>
                <a href="#" class="btn-cta-secondary">
                    <i class="bi bi-info-circle"></i>
                    Pelajari Lebih
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="stats-bar">
            <div class="stat-item">
                <span class="stat-num">100%</span>
                <span class="stat-label">Real-time</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">∞</span>
                <span class="stat-label">Data Barang</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">24/7</span>
                <span class="stat-label">Akses Sistem</span>
            </div>
        </div>

        {{-- Feature Pills --}}
        <div class="feature-strip">
            <div class="feature-pill"><i class="bi bi-box-seam-fill"></i> Manajemen Stok</div>
            <div class="feature-pill"><i class="bi bi-truck-front-fill"></i> Data Supplier</div>
            <div class="feature-pill"><i class="bi bi-arrow-left-right"></i> Barang Masuk/Keluar</div>
            <div class="feature-pill"><i class="bi bi-graph-up-arrow"></i> Laporan Stok</div>
            <div class="feature-pill"><i class="bi bi-shield-fill-check"></i> Multi-Role User</div>
        </div>
    </div>
</body>
</html>
