@props(['padding' => true])

<section {{ $attributes->merge(['class' => 'rounded-2xl border border-slate-200 bg-white shadow-sm'.($padding ? ' p-5' : '')]) }}>
    {{ $slot }}
</section>
