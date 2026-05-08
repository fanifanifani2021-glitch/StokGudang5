<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Akses Ditolak | GudangKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            display: flex; align-items: center; justify-content: center;
            color: white;
        }
        .error-card {
            text-align: center;
            padding: 3rem 2rem;
            max-width: 480px;
        }
        .error-code {
            font-size: 6rem;
            font-weight: 700;
            background: linear-gradient(135deg, #ef4444, #f97316);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
        }
    </style>
</head>
<body>
<div class="error-card">
    <div class="error-code">403</div>
    <h2 class="mt-3 fw-600">Akses Ditolak</h2>
    <p class="text-white-50 mt-2">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>
    <div class="mt-4 d-flex gap-2 justify-content-center">
        <a href="{{ url()->previous() }}" class="btn btn-outline-light btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="bi bi-box-arrow-left me-1"></i>Logout
            </button>
        </form>
    </div>
</div>
</body>
</html>
