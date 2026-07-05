@props(['value'])

<label {{ $attributes->merge(['class' => 'form-label fw-bold text-secondary uppercase tracking-wider mb-1', 'style' => 'font-size: 10px;']) }}>
    {{ $value ?? $slot }}
</label>
