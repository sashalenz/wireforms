@props([
    'outline' => false
])

<x-wireforms::button
    {{ $attributes->class([$outline ? 'text-gray-300 bg-transparent hover:bg-gray-300 active:bg-gray-400 border-gray-300' : 'text-white bg-gray-400 hover:bg-gray-500 active:bg-gray-500 border-gray-400', 'border hover:text-white']) }}
>
    {{ $slot }}
</x-wireforms::button>
