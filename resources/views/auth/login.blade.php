<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — UNGS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }

        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Background foto gudang blur */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=1600&q=80') center/cover no-repeat;
            filter: blur(3px);
            transform: scale(1.05);
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(30, 40, 30, 0.45);
            z-index: 1;
        }

        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            padding: 1.5rem;
        }

        .login-card {
            background: rgba(106, 125, 106, 0.82);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255,255,255,0.18);
            border-radius: 14px;
            padding: 2.5rem 2.25rem 2rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.35);
        }

        .login-title {
            color: #fff;
            font-size: 1.45rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1.75rem;
            letter-spacing: -0.01em;
        }

        .form-control {
            background: rgba(255,255,255,0.92);
            border: 1px solid rgba(255,255,255,0.6);
            border-radius: 7px;
            color: #1a1a1a;
            padding: 0.7rem 2.75rem 0.7rem 1rem;
            font-size: 0.9rem;
            transition: all 0.2s;
            height: 46px;
        }

        .form-control::placeholder { color: #888; }
        .form-control:focus {
            background: #fff;
            border-color: rgba(255,255,255,0.9);
            box-shadow: 0 0 0 3px rgba(255,255,255,0.25);
            color: #1a1a1a;
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #f87171;
        }

        .input-wrap {
            position: relative;
            margin-bottom: 0.85rem;
        }

        .input-icon {
            position: absolute;
            right: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 1.05rem;
            pointer-events: none;
        }

        .btn-login {
            background: #1a1a1a;
            border: none;
            border-radius: 7px;
            padding: 0.75rem;
            font-size: 0.95rem;
            font-weight: 600;
            color: white;
            width: 100%;
            margin-top: 0.5rem;
            transition: all 0.2s;
            letter-spacing: 0.01em;
        }

        .btn-login:hover {
            background: #2d2d2d;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.35);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .lost-password {
            text-align: center;
            margin-top: 1.25rem;
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
            text-decoration: none;
            display: block;
            transition: color 0.2s;
        }

        .lost-password:hover { color: white; }

        .invalid-feedback { color: #fca5a5; font-size: 0.8rem; }

        .alert-login-error {
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.4);
            color: #fca5a5;
            border-radius: 8px;
            padding: 0.6rem 0.85rem;
            font-size: 0.83rem;
            margin-bottom: 1rem;
        }

        /* Error state */
        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(248,113,113,0.25);
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-card">
        <h1 class="login-title">Log in to ungss</h1>

        {{-- Error Messages --}}
        @if($errors->has('email') || $errors->has('password'))
            <div class="alert-login-error">
                <i class="bi bi-exclamation-circle me-1"></i>
                {{ $errors->first('email') ?: $errors->first('password') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-login-error">
                <i class="bi bi-exclamation-circle me-1"></i>{{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" id="loginForm">
            @csrf

            {{-- Username / Email --}}
            <div class="input-wrap">
                <input type="email" id="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       placeholder="Username"
                       autocomplete="email"
                       required>
                <i class="bi bi-person-fill input-icon"></i>
            </div>

            {{-- Password --}}
            <div class="input-wrap">
                <input type="password" id="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Password"
                       autocomplete="current-password"
                       required>
                <i class="bi bi-lock-fill input-icon"></i>
            </div>

            <button type="submit" class="btn btn-login">
                Log in
            </button>
        </form>

        <a href="#" class="lost-password">Lost password?</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
