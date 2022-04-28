@props([
    'outline' => false
])

<x-wireforms::button
    {{ $attributes->class([$outline ? 'text-cyan-500 bg-transparent hover:bg-cyan-500 active:bg-cyan-500 border-cyan-500' : 'text-white bg-cyan-500 hover:bg-cyan-600 active:bg-cyan-600 border-cyan-500', 'border hover:text-white']) }}
>
    {{ $slot }}
</x-wireforms::button>
