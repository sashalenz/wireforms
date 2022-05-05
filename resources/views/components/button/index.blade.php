<button
    {{ $attributes
    ->merge([
        'type' => 'button'
    ])->class([
        'py-1.5 px-3.5 leading-5 font-medium focus:outline-none transition duration-150 ease-in-out',
        'opacity-75 cursor-not-allowed' => $attributes->get('disabled')
    ]) }}
>
    {{ $slot }}
</button>
