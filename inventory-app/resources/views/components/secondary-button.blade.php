<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-outline-secondary py-2 px-3']) }}>
    {{ $slot }}
</button>
