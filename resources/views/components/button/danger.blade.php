@props([
    'outline' => false,
    'icon' => null,
    'title' => null
])

<x-wireforms::button
    {{ $attributes->class([
	    $outline
	    ? 'text-red-500 bg-transparent hover:bg-red-500 active:bg-red-500 border-red-500'
	    : 'text-white bg-red-500 hover:bg-red-600 active:bg-red-600 border-red-500',
	  'border hover:text-white']) }}
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
