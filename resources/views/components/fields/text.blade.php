<x-wireforms::fields
    :name="$name"
    :id="$id"
    :required="$required"
    :label="$label"
    :show-label="$showLabel"
    :help="$help"
    {{ $attributes->whereDoesntStartWith(['min', 'max', 'step', 'data', 'x-', 'wire:model', 'wire:change']) }}
>
    <div class="relative flex w-full">
        @isset($prepend)
            {{ $prepend }}
        @endisset
        <input type="{{ $type }}"
               name="{{ $name }}"
               id="{{ $id }}"
               @isset($value)
                   value="{{ $value }}"
               @endisset
               @if($placeholder)
                   placeholder="{{ $placeholder }}"
               @endif
               @class([
                'block w-full px-3 py-1.5 border duration-300 transition-all sm:text-sm focus:outline-none focus:shadow-full rounded-sm',
                'border-gray-200 text-gray-700 placeholder-gray-300 focus:ring-primary-300 focus:border-primary-300 focus:shadow-primary-100/50' => !$errors->has($id),
                'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-300 focus:border-red-300 focus:shadow-red-100/75' => $errors->has($id),
                '-ml-px' => isset($slot, $append),
                '-mr-px' => isset($prepend)
               ])
               @if($required) required="required" @endif
            @disabled($disabled)
            {{ $attributes->whereStartsWith(['min', 'max', 'step', 'data', 'wire:model', 'wire:change', 'x-']) }}
        >
        @isset($slot)
            {{ $slot }}
        @endisset
        @isset($append)
            {{ $append }}
        @endisset
    </div>
</x-wireforms::fields>
