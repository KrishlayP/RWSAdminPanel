@props(['label', 'value', 'note' => null])

<div class="stat-card">
    <div class="stat-label">{{ $label }}</div>
    <strong class="stat-value">{{ $value }}</strong>
    @if ($note)
        <div class="stat-note">{{ $note }}</div>
    @endif
</div>
