<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-danger py-2 px-3']) }}>
    {{ $slot }}
</button>
