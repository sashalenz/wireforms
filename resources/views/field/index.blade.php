<div
        @if(isset($attributes) && $attributes->whereStartsWith('class')->first())
        {{ $attributes->whereStartsWith('class')->merge(['class' => "col-span-6 md:col-span-{$size}"]) }}
        @else
        class="col-span-6 md:col-span-{{ $size }} {{ $class ?? '' }}"
        @endif
>
    <div class="mb-1 flex justify-between items-end">
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $title }}</label>
        @if($required && $requiredIcon)
            <svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-3 h-3 text-gray-300">
                <path fill="currentColor" d="M446 366.05l-.09.15-15.47 26.8a15.42 15.42 0 0 1-21.06 5.72L256 310.2l-.2 185.8a16 16 0 0 1-16 16h-32a16 16 0 0 1-16-16l.1-185.7-153.25 88.5a15.51 15.51 0 0 1-21.1-5.7L2 366.3a15.51 15.51 0 0 1 5.7-21.1L162.16 256 7.87 166.8a15.43 15.43 0 0 1-5.73-21.06L17.67 119a15.41 15.41 0 0 1 21-5.72h.05L192 201.8V16a16 16 0 0 1 16-16h32a16 16 0 0 1 16 16v185.8l153.3-88.5a15.51 15.51 0 0 1 21.1 5.7l15.5 26.8a15.51 15.51 0 0 1-5.7 21.1L285.85 256l154.49 89.2a15.29 15.29 0 0 1 5.66 20.85z" class="fa-primary"></path>
            </svg>
        @endif
    </div>
    {{ $slot }}
    @isset($wireModel)
        @error($wireModel)
        <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
        @enderror
    @endisset
    @error($name)
    <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
    @enderror
    @isset($help)
        <div class="mt-2 text-sm text-gray-500">{{ $help }}</div>
    @endisset
</div>
