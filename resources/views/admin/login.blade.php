<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RWS Admin Login</title>
    <style>
        :root { --bg:#eeeeec; --panel:#fff; --ink:#111; --muted:#6f6f6a; --line:#deded9; --brand:#f59e0b; --danger:#dc2626; }
        * { box-sizing: border-box; }
        body {
            display: grid;
            min-height: 100vh;
            margin: 0;
            place-items: center;
            color: var(--ink);
            background: var(--bg);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .login-shell {
            display: grid;
            grid-template-columns: 1fr 420px;
            width: min(980px, calc(100vw - 36px));
            min-height: 560px;
            overflow: hidden;
            background: #f7f7f5;
            border: 1px solid rgba(255, 255, 255, .85);
            border-radius: 30px;
            box-shadow: 0 24px 60px rgba(17, 17, 17, .1);
        }
        .preview {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 34px;
            background:
                linear-gradient(135deg, rgba(255, 255, 255, .95), rgba(255, 247, 237, .9)),
                radial-gradient(circle at 80% 20%, rgba(245, 158, 11, .22), transparent 34%);
        }
        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 25px;
            font-weight: 850;
        }
        .brand-mark {
            display: grid;
            width: 32px;
            height: 32px;
            place-items: center;
            background: linear-gradient(135deg, #f97316, #fbbf24);
            border-radius: 9px;
            box-shadow: inset 0 0 0 2px rgba(255,255,255,.65);
        }
        .brand-mark::before {
            width: 13px;
            height: 13px;
            content: "";
            border: 2px solid #fff;
            border-radius: 3px;
            transform: rotate(45deg);
        }
        h1 {
            max-width: 440px;
            margin: 0;
            font-size: clamp(42px, 6vw, 70px);
            line-height: .95;
            font-weight: 850;
            letter-spacing: 0;
        }
        .preview p {
            max-width: 430px;
            margin: 18px 0 0;
            color: var(--muted);
            line-height: 1.6;
        }
        .metric-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }
        .metric {
            padding: 16px;
            background: rgba(255,255,255,.78);
            border: 1px solid var(--line);
            border-radius: 18px;
        }
        .metric span {
            display: block;
            color: var(--muted);
            font-size: 12px;
            font-weight: 800;
        }
        .metric strong {
            display: block;
            margin-top: 8px;
            font-size: 26px;
        }
        .card {
            align-self: center;
            margin: 26px;
            padding: 26px;
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 24px;
            box-shadow: 0 18px 38px rgba(17,17,17,.07);
        }
        .card h2 {
            margin: 0 0 6px;
            font-size: 27px;
        }
        .hint, .subcopy {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.5;
        }
        label {
            display: block;
            margin: 18px 0 8px;
            font-size: 13px;
            font-weight: 850;
        }
        input {
            width: 100%;
            min-height: 50px;
            padding: 12px 13px;
            color: var(--ink);
            background: #fff;
            border: 1px solid #d9d9d4;
            border-radius: 14px;
            font: inherit;
            outline: none;
        }
        input:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(245, 158, 11, .16);
        }
        button {
            width: 100%;
            min-height: 48px;
            margin-top: 22px;
            color: #fff;
            background: #222225;
            border: 0;
            border-radius: 14px;
            font-weight: 850;
            cursor: pointer;
            box-shadow: 0 12px 22px rgba(17,17,17,.16);
        }
        .error {
            margin: 16px 0 0;
            padding: 12px 14px;
            color: #991b1b;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 14px;
            font-weight: 750;
        }
        @media (max-width: 860px) {
            .login-shell { grid-template-columns: 1fr; }
            .preview { min-height: 320px; }
            .metric-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <main class="login-shell">
        <section class="preview">
            <div class="brand">
                <span class="brand-mark" aria-hidden="true"></span>
                <span>RWS Admin</span>
            </div>
            <div>
                <h1>Content control room</h1>
                <p>Publish wallpapers, audio, books and categories to the live app from one clean dashboard.</p>
            </div>
            <div class="metric-row">
                <div class="metric"><span>API</span><strong>Live</strong></div>
                <div class="metric"><span>Media</span><strong>HD</strong></div>
                <div class="metric"><span>Sync</span><strong>Fast</strong></div>
            </div>
        </section>

        <form class="card" method="post" action="{{ route('admin.login.submit') }}">
            @csrf
            <h2>Sign in</h2>
            <div class="subcopy">Use your admin credentials to manage live app content.</div>
            @if ($errors->any())
                <div class="error">{{ $errors->first() }}</div>
            @endif
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', env('ADMIN_EMAIL', 'admin@example.com')) }}" required autofocus>
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
            <button type="submit">Login</button>
            <div class="hint">Set ADMIN_EMAIL and ADMIN_PASSWORD in hosting environment variables.</div>
        </form>
    </main>
</body>
</html>
