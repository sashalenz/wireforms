<x-wireforms::fields
    :name="$name"
    :id="$id"
    :required="$required"
    :label="$label"
    :locale="$locale"
    :show-label="$showLabel"
    :help="$help"
    {{ $attributes->whereDoesntStartWith(['data-', 'x-', 'wire:model', 'wire:change']) }}
>
    <div class="relative flex w-full" {{ $attributes->whereStartsWith('x-') }}>
        @isset($prepend)
            {{ $prepend }}
        @endisset
        <select name="{{ $name }}"
                id="{{ $name }}"
                @class([
                    'block w-full px-3 py-1.5 border duration-300 transition-all sm:text-sm focus:outline-none focus:shadow-full rounded-sm',
                    'border-gray-200 text-gray-700 placeholder-gray-300 focus:ring-primary-300 focus:border-primary-300 focus:shadow-primary-100/50' => !$errors->has($id),
                    'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-300 focus:border-red-300 focus:shadow-red-100/75' => $errors->has($id),
                    '-ml-px' => isset($slot, $append),
                    '-mr-px' => isset($prepend)
                ])
                @if($required) required="required" @endif
                @disabled($disabled)
                @if($multiple) multiple @endif
                @if($placeholder)
                    placeholder="{{ $placeholder }}"
                    data-placeholder="{{ $placeholder }}"
                @endif
                {{ $attributes->whereStartsWith(['data-', 'wire:model', 'wire:change']) }}
        >
            @if($nullable)
                <option value="">{{ $placeholder ?? __('wireforms::form.please_select') }}</option>
            @endif
            @foreach($options as $key => $option)
                <option value="{{ $key }}" @selected($isSelected($key))>{{ $option }}</option>
            @endforeach
        </select>
        @isset($slot)
            {{ $slot }}
        @endisset
        @isset($append)
            {{ $append }}
        @endisset
    </div>
</x-wireforms::fields>
