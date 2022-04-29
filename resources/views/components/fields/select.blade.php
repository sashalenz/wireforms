<x-wireforms::fields
    :name="$name"
    :id="$id"
    :required="$required"
    :label="$label"
    :locale="$locale"
    :show-label="$showLabel"
    :help="$help"
    {{ $attributes->whereDoesntStartWith(['min', 'max', 'step', 'data', 'x-']) }}
>
    <div class="mt-1 relative flex w-full">
        @isset($prepend)
            {{ $prepend }}
        @endisset
        <select name="{{ $name }}"
                id="{{ $name }}"
                @class(['form-control', 'border-red-500' => $errors->has($name)])
                @if($required) required="required" @endif
                @disabled($disabled)
                @if($multiple) multiple @endif
                @if($placeholder)
                    placeholder="{{ $placeholder }}"
                data-placeholder="{{ $placeholder }}"
            @endif
            {{ $attributes->whereStartsWith('data-') }}
        >
            @if($nullable)
                <option value="">{{ $placeholder ?? __('admin.please_select') }}</option>
            @endif
            @foreach($options as $key => $option)
                <option value="{{ $key }}" @selected($key === $value)>{{ $option }}</option>
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
