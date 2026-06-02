@props(['tone' => 'muted'])

@php
    $classes = [
        'ok' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
        'muted' => 'bg-slate-100 text-slate-600 ring-slate-200',
        'brand' => 'bg-indigo-50 text-indigo-700 ring-indigo-100',
    ][$tone] ?? 'bg-slate-100 text-slate-600 ring-slate-200';
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex min-h-7 items-center rounded-full px-2.5 text-xs font-semibold ring-1 '.$classes]) }}>
    {{ $slot }}
</span>
