<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'RWS Admin' }}</title>
    <style>
        :root { color-scheme: light; --bg:#f6f7fb; --panel:#fff; --ink:#14213d; --muted:#667085; --line:#e4e7ec; --brand:#c2410c; --brand-soft:#fff7ed; --ok:#15803d; }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, Helvetica, sans-serif; background: var(--bg); color: var(--ink); }
        a { color: var(--brand); text-decoration: none; }
        .shell { display: grid; grid-template-columns: 230px 1fr; min-height: 100vh; }
        .sidebar { background: #111827; color: #fff; padding: 24px; }
        .brand { font-size: 22px; font-weight: 700; margin-bottom: 28px; }
        .nav a, .logout { display: block; width: 100%; color: #e5e7eb; padding: 11px 12px; border-radius: 8px; margin-bottom: 6px; background: transparent; border: 0; text-align: left; font: inherit; cursor: pointer; }
        .nav a:hover, .logout:hover { background: rgba(255,255,255,.1); }
        .main { padding: 30px; }
        .topbar { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 22px; }
        h1 { margin: 0; font-size: 28px; }
        .panel { background: var(--panel); border: 1px solid var(--line); border-radius: 10px; padding: 20px; box-shadow: 0 10px 24px rgba(20,33,61,.06); }
        .grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }
        .stat { background: var(--brand-soft); border: 1px solid #fed7aa; border-radius: 10px; padding: 18px; }
        .stat strong { display: block; font-size: 26px; margin-top: 8px; }
        .actions { display: flex; gap: 10px; align-items: center; }
        .button { display: inline-flex; align-items: center; justify-content: center; min-height: 40px; padding: 0 14px; border-radius: 8px; border: 1px solid var(--brand); background: var(--brand); color: #fff; font-weight: 700; cursor: pointer; }
        .button.secondary { background: #fff; color: var(--brand); }
        .button.danger { background: #b42318; border-color: #b42318; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 12px; border-bottom: 1px solid var(--line); vertical-align: middle; }
        th { color: var(--muted); font-size: 13px; }
        .status { color: var(--ok); font-weight: 700; }
        .muted { color: var(--muted); }
        form.inline { display: inline; }
        label { display: block; font-weight: 700; margin: 0 0 7px; }
        input, select, textarea { width: 100%; border: 1px solid #d0d5dd; border-radius: 8px; padding: 11px 12px; font: inherit; background: #fff; }
        textarea { min-height: 96px; resize: vertical; }
        .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        .field.full { grid-column: 1 / -1; }
        .check { display: flex; gap: 8px; align-items: center; }
        .check input { width: auto; }
        .errors { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 16px; }
        .flash { background: #ecfdf3; border: 1px solid #abefc6; color: #067647; padding: 12px; border-radius: 8px; margin-bottom: 16px; }
        @media (max-width: 760px) { .shell { grid-template-columns: 1fr; } .sidebar { position: static; } .main { padding: 18px; } .grid, .form-grid { grid-template-columns: 1fr; } .topbar { align-items: flex-start; flex-direction: column; } }
    </style>
</head>
<body>
    <div class="shell">
        <aside class="sidebar">
            <div class="brand">RWS Admin</div>
            <nav class="nav">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('admin.categories.index') }}">Categories</a>
                <a href="{{ route('admin.media.index') }}">Media Items</a>
                <a href="{{ route('api.content') }}" target="_blank">API Preview</a>
                <form method="post" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="logout" type="submit">Logout</button>
                </form>
            </nav>
        </aside>
        <main class="main">
            @if (session('status'))
                <div class="flash">{{ session('status') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
