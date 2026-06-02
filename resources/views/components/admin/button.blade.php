@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
    'navigate' => true,
])

@php
    $classes = [
        'primary' => 'bg-emerald-600 text-white shadow-sm shadow-emerald-600/20 hover:bg-emerald-700',
        'secondary' => 'border border-slate-200 bg-white text-slate-700 shadow-sm hover:bg-slate-50',
        'danger' => 'bg-red-500 text-white hover:bg-red-600',
    ][$variant] ?? 'bg-emerald-600 text-white shadow-sm shadow-emerald-600/20 hover:bg-emerald-700';

    $base = 'inline-flex min-h-10 items-center justify-center rounded-xl px-4 text-sm font-semibold transition '.$classes;
@endphp

@if ($href)
    <a @if ($navigate) wire:navigate.hover @endif {{ $attributes->merge(['class' => $base, 'href' => $href]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $base, 'type' => $type]) }}>
        {{ $slot }}
    </button>
@endif
