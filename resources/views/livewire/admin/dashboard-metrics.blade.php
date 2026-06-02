<div>
    <div class="mb-4 flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
        <div>
            <p class="text-sm font-semibold text-slate-900">Dashboard metrics</p>
            <p class="text-xs text-slate-500">No auto reload. Use refresh only when you need latest counts.</p>
        </div>
        <button
            class="inline-flex min-h-9 items-center rounded-xl border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 disabled:opacity-60"
            type="button"
            wire:click="refreshMetrics"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove>Refresh metrics</span>
            <span wire:loading>Refreshing...</span>
        </button>
    </div>

    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <x-admin.stat-card label="Categories" icon="C" :value="number_format($categoryCount)" delta="Live" />
        <x-admin.stat-card label="Media items" icon="M" :value="number_format($mediaCount)" delta="Live" />
        <x-admin.stat-card label="Active media" icon="A" :value="number_format($activeMediaCount)" delta="Published" />
        <x-admin.stat-card label="Featured" icon="F" :value="number_format($featuredMediaCount)" delta="Home" />
    </section>

    <section class="mt-5 grid gap-5 xl:grid-cols-[minmax(0,1.6fr)_minmax(320px,.8fr)]">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-base font-semibold text-slate-950">Content activity</h2>
                <div class="flex gap-4 text-xs font-medium text-slate-500">
                    <span><i class="mr-1 inline-block h-2 w-2 rounded-full bg-indigo-500"></i>Active</span>
                    <span><i class="mr-1 inline-block h-2 w-2 rounded-full bg-amber-500"></i>Featured</span>
                </div>
            </div>

            <div class="grid min-h-72 grid-cols-[40px_repeat(8,minmax(28px,1fr))] items-end gap-3 border-t border-slate-100 pt-4">
                <div class="flex h-full flex-col justify-between text-xs text-slate-400">
                    <span>80</span><span>60</span><span>40</span><span>20</span><span>0</span>
                </div>
                @foreach ([34, 46, 29, 48, 66, 61, 24, 52] as $index => $height)
                    <div class="relative grid min-h-60 grid-cols-2 items-end justify-center gap-2">
                        <span class="mx-auto w-2.5 rounded-t-full bg-indigo-500" style="height: {{ $height }}%"></span>
                        <span class="mx-auto w-2.5 rounded-t-full bg-amber-400" style="height: {{ [46, 58, 68, 56, 44, 70, 40, 62][$index] }}%"></span>
                        <span class="absolute -bottom-6 left-1/2 -translate-x-1/2 whitespace-nowrap text-xs text-slate-400">{{ $index + 1 }} Jun</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-base font-semibold text-slate-950">Publishing checklist</h2>
            <div class="mt-5 grid gap-4">
                <div class="flex items-center justify-between text-sm"><span class="text-slate-500">Categories active</span><strong class="font-semibold text-slate-900">{{ $categoryCount ? 'Ready' : 'Add' }}</strong></div>
                <div class="flex items-center justify-between text-sm"><span class="text-slate-500">Media active</span><strong class="font-semibold text-slate-900">{{ $activeMediaCount }}</strong></div>
                <div class="flex items-center justify-between text-sm"><span class="text-slate-500">Home featured</span><strong class="font-semibold text-slate-900">{{ $featuredMediaCount }}</strong></div>
                <div class="flex items-center justify-between text-sm"><span class="text-slate-500">API endpoint</span><strong class="font-semibold text-emerald-700">Live</strong></div>
                <div class="flex items-center justify-between text-sm"><span class="text-slate-500">Refresh mode</span><strong class="font-semibold text-emerald-700">Manual</strong></div>
            </div>
        </div>
    </section>

    <section class="mt-5 grid gap-5 xl:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-base font-semibold text-slate-950">Content by type</h2>
            <div class="mt-5 grid gap-4">
                @foreach ([['Wallpapers', $imageCount], ['Bhajan / Audio', $audioCount], ['Other media', $otherCount]] as [$label, $count])
                    <div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-medium text-slate-600">{{ $label }}</span>
                            <strong class="font-semibold text-slate-900">{{ $count }}</strong>
                        </div>
                        <div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-emerald-500" style="width: {{ min(100, max(8, $count * 12)) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-base font-semibold text-slate-950">Live app sync</h2>
            <p class="mt-4 break-all text-sm font-medium text-emerald-700">{{ $apiUrl }}</p>
            <p class="mt-3 text-sm leading-6 text-slate-500">Keep category and media status Active. Enable Featured for home screen content.</p>
            <div class="mt-5 flex flex-wrap gap-3">
                <a class="inline-flex min-h-10 items-center rounded-xl bg-emerald-600 px-4 text-sm font-semibold text-white shadow-sm shadow-emerald-600/20" href="{{ $apiUrl }}" target="_blank" rel="noreferrer">Open API</a>
                <a wire:navigate.hover class="inline-flex min-h-10 items-center rounded-xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-700" href="{{ route('admin.media.index') }}">Review media</a>
            </div>
        </div>
    </section>
</div>
