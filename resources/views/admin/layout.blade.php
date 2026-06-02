<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'RWS Admin' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
    @php
        $navItems = [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'icon' => 'D'],
            ['label' => 'Categories', 'route' => 'admin.categories.index', 'match' => 'admin.categories.*', 'icon' => 'C'],
            ['label' => 'Media Items', 'route' => 'admin.media.index', 'match' => 'admin.media.*', 'icon' => 'M'],
        ];
        $currentTitle = $title ?? 'Dashboard';
    @endphp

    <div class="grid min-h-screen lg:grid-cols-[260px_minmax(0,1fr)]">
        @persist('admin-sidebar')
        <aside class="border-b border-slate-200 bg-white px-4 py-5 lg:sticky lg:top-0 lg:h-screen lg:border-b-0 lg:border-r">
            <a wire:navigate.hover class="mb-8 flex items-center gap-3 px-2" href="{{ route('admin.dashboard') }}">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-emerald-600 text-sm font-bold text-white shadow-lg shadow-emerald-600/20">R</span>
                <span class="text-lg font-semibold tracking-tight text-slate-950">RWS Admin</span>
            </a>

            <div class="mb-2 px-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Content</div>
            <nav class="grid gap-1" aria-label="Admin navigation">
                @foreach ($navItems as $item)
                    <a
                        wire:navigate.hover
                        data-admin-nav-link
                        class="flex min-h-11 items-center gap-3 rounded-xl px-3 text-sm font-medium transition {{ request()->routeIs($item['match']) ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }}"
                        href="{{ route($item['route']) }}"
                    >
                        <span class="grid h-7 w-7 place-items-center rounded-lg bg-white text-xs font-semibold ring-1 ring-slate-200">{{ $item['icon'] }}</span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
                <a class="flex min-h-11 items-center gap-3 rounded-xl px-3 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-950" href="{{ route('api.content') }}" target="_blank" rel="noreferrer">
                    <span class="grid h-7 w-7 place-items-center rounded-lg bg-white text-xs font-semibold ring-1 ring-slate-200">A</span>
                    <span>API Preview</span>
                </a>
            </nav>

            <div class="mt-8 mb-2 px-3 text-xs font-semibold uppercase tracking-wide text-slate-400">System</div>
            <form method="post" action="{{ route('admin.logout') }}">
                @csrf
                <button class="flex min-h-11 w-full items-center gap-3 rounded-xl px-3 text-left text-sm font-medium text-red-600 transition hover:bg-red-50" type="submit">
                    <span class="grid h-7 w-7 place-items-center rounded-lg bg-white text-xs font-semibold ring-1 ring-red-100">x</span>
                    <span>Logout</span>
                </button>
            </form>
        </aside>
        @endpersist

        <main class="min-w-0 px-5 py-6 sm:px-8 lg:px-10">
            <header class="mb-6 flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight text-slate-950 sm:text-3xl">{{ $currentTitle }}</h1>
                    @hasSection('subtitle')
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">@yield('subtitle')</p>
                    @endif
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <span class="inline-flex min-h-10 items-center rounded-xl border border-slate-200 bg-white px-3 text-sm font-medium text-slate-500 shadow-sm">Today</span>
                    @yield('actions')
                </div>
            </header>

            @if (session('status'))
                <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @livewireScripts
    <script data-navigate-once>
        (() => {
            function syncActiveNav() {
                const currentPath = window.location.pathname.replace(/\/$/, "");

                document.querySelectorAll("[data-admin-nav-link]").forEach((link) => {
                    const linkPath = new URL(link.href).pathname.replace(/\/$/, "");
                    const isActive = currentPath === linkPath || (linkPath !== "/admin" && currentPath.startsWith(linkPath));

                    link.classList.toggle("bg-emerald-50", isActive);
                    link.classList.toggle("text-emerald-700", isActive);
                    link.classList.toggle("ring-1", isActive);
                    link.classList.toggle("ring-emerald-100", isActive);
                    link.classList.toggle("text-slate-600", !isActive);
                    link.classList.toggle("hover:bg-slate-100", !isActive);
                    link.classList.toggle("hover:text-slate-950", !isActive);
                });
            }

            document.addEventListener("livewire:navigated", syncActiveNav);
            document.addEventListener("DOMContentLoaded", syncActiveNav);
        })();
    </script>
</body>
</html>
