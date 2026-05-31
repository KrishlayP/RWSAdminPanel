<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'RWS Admin' }}</title>
    <style>
        :root {
            color-scheme: light;
            --bg: #eeeeec;
            --panel: #ffffff;
            --panel-soft: #f7f7f5;
            --ink: #111111;
            --muted: #6f6f6a;
            --line: #deded9;
            --brand: #f59e0b;
            --brand-ink: #7c2d12;
            --brand-soft: #fff7ed;
            --ok: #16a34a;
            --danger: #dc2626;
            --shadow: 0 20px 50px rgba(17, 17, 17, .08);
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            background: var(--bg);
            color: var(--ink);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        a { color: inherit; text-decoration: none; }
        button, input, select, textarea { font: inherit; }

        .app-shell {
            width: min(1220px, calc(100vw - 36px));
            min-height: calc(100vh - 36px);
            margin: 18px auto;
            padding: 26px;
            overflow: hidden;
            background: #f7f7f5;
            border: 1px solid rgba(255, 255, 255, .8);
            border-radius: 28px;
            box-shadow: var(--shadow);
        }

        .top-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 22px;
            margin-bottom: 34px;
        }
        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            min-width: 185px;
            font-size: 25px;
            font-weight: 850;
            letter-spacing: 0;
        }
        .brand-mark {
            display: grid;
            width: 32px;
            height: 32px;
            place-items: center;
            color: #fff;
            background: linear-gradient(135deg, #f97316, #fbbf24);
            border-radius: 9px;
            box-shadow: inset 0 0 0 2px rgba(255, 255, 255, .65);
        }
        .brand-mark::before {
            width: 13px;
            height: 13px;
            content: "";
            border: 2px solid #fff;
            border-radius: 3px;
            transform: rotate(45deg);
        }
        .nav-links {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex: 1;
        }
        .nav-pill, .logout {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 0 18px;
            color: #1f1f1c;
            background: transparent;
            border: 0;
            border-radius: 14px;
            font-weight: 750;
            cursor: pointer;
            white-space: nowrap;
        }
        .nav-pill:hover, .logout:hover { background: #ecece8; }
        .nav-pill.active {
            color: #fff;
            background: #222225;
            box-shadow: 0 10px 20px rgba(17, 17, 17, .18);
        }
        .logout { color: var(--danger); }

        .page-head {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 22px;
        }
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
        }
        h1 {
            margin: 6px 0 0;
            font-size: clamp(34px, 5vw, 58px);
            line-height: 1;
            font-weight: 850;
            letter-spacing: 0;
        }
        .lead {
            max-width: 620px;
            margin: 12px 0 0;
            color: var(--muted);
            font-size: 15px;
            line-height: 1.6;
        }
        .actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 0 15px;
            border: 1px solid #222225;
            border-radius: 13px;
            color: #fff;
            background: #222225;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 10px 18px rgba(17, 17, 17, .12);
        }
        .button.secondary {
            color: #222225;
            background: #fff;
            border-color: var(--line);
            box-shadow: none;
        }
        .button.danger {
            color: #fff;
            background: var(--danger);
            border-color: var(--danger);
        }

        .panel {
            background: rgba(255, 255, 255, .72);
            border: 1px solid var(--line);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 16px 32px rgba(17, 17, 17, .04);
        }
        .panel.pad { padding: 20px; }
        .grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }
        .stat-card {
            min-height: 150px;
            padding: 20px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 22px;
        }
        .stat-label {
            color: var(--muted);
            font-size: 14px;
            font-weight: 800;
        }
        .stat-value {
            display: block;
            margin-top: 14px;
            font-size: 44px;
            line-height: 1;
            font-weight: 850;
        }
        .stat-note {
            margin-top: 12px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.4;
        }

        .sync-card {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 18px;
            align-items: center;
            margin-top: 16px;
            padding: 16px;
            background: linear-gradient(135deg, #ffffff, #fff7ed);
            border: 1px solid #fed7aa;
            border-radius: 22px;
        }
        .sync-url {
            margin-top: 8px;
            color: var(--brand-ink);
            font-size: 13px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 780px; }
        th, td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid var(--line);
            vertical-align: middle;
        }
        th {
            color: var(--muted);
            background: #fbfbfa;
            font-size: 12px;
            font-weight: 850;
            text-transform: uppercase;
        }
        tr:last-child td { border-bottom: 0; }
        .title-cell { font-weight: 850; }
        .muted { color: var(--muted); }
        .small { font-size: 13px; line-height: 1.5; }
        form.inline { display: inline; }

        .badge {
            display: inline-flex;
            align-items: center;
            min-height: 28px;
            padding: 0 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 850;
        }
        .badge.ok { color: #166534; background: #dcfce7; }
        .badge.muted { color: #525252; background: #eeeeec; }
        .badge.brand { color: #9a3412; background: #ffedd5; min-width: auto; font-size: 12px; }

        label { display: block; margin: 0 0 8px; font-size: 13px; font-weight: 850; }
        input, select, textarea {
            width: 100%;
            min-height: 48px;
            padding: 12px 13px;
            color: var(--ink);
            background: #fff;
            border: 1px solid #d9d9d4;
            border-radius: 14px;
            outline: none;
        }
        input:focus, select:focus, textarea:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(245, 158, 11, .16);
        }
        textarea { min-height: 104px; resize: vertical; }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }
        .field.full { grid-column: 1 / -1; }
        .help {
            margin-top: 7px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }
        .check {
            display: flex;
            align-items: center;
            gap: 10px;
            min-height: 48px;
            padding: 0 13px;
            background: #fff;
            border: 1px solid #d9d9d4;
            border-radius: 14px;
        }
        .check input { width: auto; min-height: auto; }
        .errors, .flash {
            margin-bottom: 16px;
            padding: 13px 15px;
            border-radius: 16px;
            font-weight: 750;
        }
        .errors { color: #991b1b; background: #fef2f2; border: 1px solid #fecaca; }
        .flash { color: #166534; background: #dcfce7; border: 1px solid #86efac; }

        @media (max-width: 900px) {
            .app-shell { width: min(100vw - 20px, 1220px); margin: 10px auto; padding: 18px; border-radius: 22px; }
            .top-nav, .page-head, .sync-card { align-items: flex-start; flex-direction: column; }
            .nav-links { justify-content: flex-start; width: 100%; overflow-x: auto; padding-bottom: 4px; }
            .grid, .form-grid { grid-template-columns: 1fr; }
            h1 { font-size: 42px; }
        }
    </style>
</head>
<body>
    @php
        $navItems = [
            ['label' => 'Home', 'route' => 'admin.dashboard'],
            ['label' => 'Categories', 'route' => 'admin.categories.index'],
            ['label' => 'Media', 'route' => 'admin.media.index'],
        ];
    @endphp

    <div class="app-shell">
        <header class="top-nav">
            <a class="brand" href="{{ route('admin.dashboard') }}">
                <span class="brand-mark" aria-hidden="true"></span>
                <span>RWS Admin</span>
            </a>

            <nav class="nav-links" aria-label="Admin navigation">
                @foreach ($navItems as $item)
                    <a class="nav-pill {{ request()->routeIs($item['route']) ? 'active' : '' }}" href="{{ route($item['route']) }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
                <a class="nav-pill" href="{{ route('api.content') }}" target="_blank" rel="noreferrer">API Preview</a>
            </nav>

            <form method="post" action="{{ route('admin.logout') }}">
                @csrf
                <button class="logout" type="submit">Logout</button>
            </form>
        </header>

        @if (session('status'))
            <div class="flash">{{ session('status') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>
