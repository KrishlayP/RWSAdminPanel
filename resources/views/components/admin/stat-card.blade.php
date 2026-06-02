@props(['label', 'value', 'note' => null, 'delta' => null, 'icon' => '•'])

<div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-center gap-2 text-xs font-medium text-slate-400">
        <span>{{ $icon }}</span>
        <span>{{ $label }}</span>
    </div>
    <strong class="mt-3 flex items-baseline gap-2 text-2xl font-semibold tracking-tight text-slate-950">
        <span>{{ $value }}</span>
        @if ($delta)
            <span class="text-xs font-semibold text-emerald-600">{{ $delta }}</span>
        @endif
    </strong>
    @if ($note)
        <div class="mt-2 text-xs leading-5 text-slate-500">{{ $note }}</div>
    @endif
</div>
