<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RWS Admin Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
    <main class="grid min-h-screen place-items-center px-4 py-10">
        <div class="grid w-full max-w-5xl overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl shadow-slate-200/70 lg:grid-cols-[1fr_420px]">
            <section class="flex min-h-[520px] flex-col justify-between bg-gradient-to-br from-white to-emerald-50 p-8">
                <div class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-emerald-600 text-sm font-bold text-white shadow-lg shadow-emerald-600/20">R</span>
                    <span class="text-lg font-semibold tracking-tight text-slate-950">RWS Admin</span>
                </div>

                <div>
                    <h1 class="max-w-md text-4xl font-semibold tracking-tight text-slate-950 sm:text-5xl">Content operations for your mobile app.</h1>
                    <p class="mt-4 max-w-md text-sm leading-6 text-slate-500">Publish categories, wallpapers, audio, books and featured content from a clean admin workspace.</p>
                </div>

                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="rounded-2xl border border-slate-200 bg-white/80 p-4"><span class="text-xs font-medium text-slate-400">API</span><strong class="mt-1 block text-xl font-semibold text-slate-950">Live</strong></div>
                    <div class="rounded-2xl border border-slate-200 bg-white/80 p-4"><span class="text-xs font-medium text-slate-400">Media</span><strong class="mt-1 block text-xl font-semibold text-slate-950">HD</strong></div>
                    <div class="rounded-2xl border border-slate-200 bg-white/80 p-4"><span class="text-xs font-medium text-slate-400">Sync</span><strong class="mt-1 block text-xl font-semibold text-slate-950">Fast</strong></div>
                </div>
            </section>

            <form class="self-center p-7" method="post" action="{{ route('admin.login.submit') }}">
                @csrf
                <h2 class="text-2xl font-semibold tracking-tight text-slate-950">Sign in</h2>
                <p class="mt-2 text-sm leading-6 text-slate-500">Use your admin credentials to manage live app content.</p>

                @if ($errors->any())
                    <div class="mt-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">{{ $errors->first() }}</div>
                @endif

                <label class="mt-6 mb-2 block text-sm font-medium text-slate-700" for="email">Email</label>
                <input class="min-h-12 w-full rounded-xl border border-slate-200 px-3 text-sm outline-none ring-emerald-500/10 transition focus:border-emerald-500 focus:ring-4" id="email" name="email" type="email" value="{{ old('email', env('ADMIN_EMAIL', 'admin@example.com')) }}" required autofocus>

                <label class="mt-4 mb-2 block text-sm font-medium text-slate-700" for="password">Password</label>
                <input class="min-h-12 w-full rounded-xl border border-slate-200 px-3 text-sm outline-none ring-emerald-500/10 transition focus:border-emerald-500 focus:ring-4" id="password" name="password" type="password" required>

                <button class="mt-6 inline-flex min-h-12 w-full items-center justify-center rounded-xl bg-emerald-600 px-4 text-sm font-semibold text-white shadow-sm shadow-emerald-600/20" type="submit">Login</button>
                <div class="mt-4 text-xs leading-5 text-slate-500">Set ADMIN_EMAIL and ADMIN_PASSWORD in hosting environment variables.</div>
            </form>
        </div>
    </main>
</body>
</html>
