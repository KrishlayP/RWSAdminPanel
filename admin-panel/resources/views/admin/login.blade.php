<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RWS Admin Login</title>
    <style>
        body { margin:0; min-height:100vh; display:grid; place-items:center; font-family:Arial, Helvetica, sans-serif; background:#f6f7fb; color:#14213d; }
        .card { width:min(420px, calc(100vw - 32px)); background:#fff; border:1px solid #e4e7ec; border-radius:12px; padding:28px; box-shadow:0 16px 36px rgba(20,33,61,.08); }
        h1 { margin:0 0 20px; }
        label { display:block; font-weight:700; margin:14px 0 7px; }
        input { width:100%; box-sizing:border-box; border:1px solid #d0d5dd; border-radius:8px; padding:12px; font:inherit; }
        button { width:100%; min-height:44px; margin-top:20px; border:0; border-radius:8px; background:#c2410c; color:#fff; font-weight:700; cursor:pointer; }
        .error { margin:0 0 12px; padding:10px; border-radius:8px; background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }
        .hint { color:#667085; font-size:14px; margin-top:12px; }
    </style>
</head>
<body>
    <form class="card" method="post" action="{{ route('admin.login.submit') }}">
        @csrf
        <h1>RWS Admin</h1>
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
</body>
</html>
