@props([
    'outline' => false,
    'icon' => null,
    'title' => null
])

<x-wireforms::button
    {{ $attributes->class([
        $outline
         ? 'text-primary-500 bg-transparent hover:bg-primary-500 active:bg-primary-500 border-primary-500'
         : 'text-white bg-primary-500 hover:bg-primary-600 active:bg-primary-600 border-primary-500',
        'border hover:text-white'
     ]) }}
>
    @if($icon)
        @svg($icon, 'w-4 h-4')
    @endif
    @if($title)
        {{ $title }}
    @endif
    @isset($slot)
        {{ $slot }}
    @endisset
</x-wireforms::button>
