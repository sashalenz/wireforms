<x-wiretable-layout-field :name="$name"
                          :wire-model="$wireModel"
                          :title="$title"
                          :size="$size"
                          :help="$help"
                          :required="$required"
                          :required-icon="$requiredIcon"
                          class="{{ $attributes->whereStartsWith('class')->first() }}"
>
    <select id="{{ $name }}"
            name="{{ $name }}"
            aria-describedby="{{ $name }}"
            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none sm:text-sm rounded-md @if($errors->has($name) || $errors->has($wireModel)) pr-10 border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @else focus:ring-primary-500 focus:border-primary-500 @endif "
            {{ $required ? 'required="required"' : '' }}
            @if(isset($attributes) && $attributes->whereStartsWith('wire:model')->first())
            wire:model="{{ $attributes->whereStartsWith('wire:model')->first() }}"
            @elseif(isset($attributes) && $attributes->whereStartsWith('wire:change')->first())
            wire:change="{{ $attributes->whereStartsWith('wire:change')->first() }}('{{ $name }}', $event.target.value)"
            @else
            wire:model="{{ $wireModel ?? $name }}"
            @endif
    >
        @if($nullable)
            <option value>{{ $placeholder ?? __('wiretable::form.please_select') }}</option>
        @endif
        @foreach($options as $key => $option)
            <option value="{{ $key }}">{{ $option }}</option>
        @endforeach
    </select>
</x-wiretable-layout-field>
