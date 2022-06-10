<x-wireforms::fields
    :name="$name"
    :id="$id"
    :required="$required"
    type="tel"
    :label="$label"
    :placeholder="$placeholder"
    :show-label="$showLabel"
    :disabled="$disabled"
    :readonly="$readonly"
    :help="$help"
    :key="$key"
    {{ $attributes->whereDoesntStartWith('wire:') }}
>
    <div class="relative flex w-full"
         x-data="{
            value: '{{ $value }}',
            mask: '+38 (099) 999-99-99',
            init() {
                $watch('value', value => $wire.emit('updatedChild', '{{ $id }}', value.replace(/[^\d+]/g, '')))
            }
         }"
         x-init="init"
    >
        @isset($prepend)
            {{ $prepend }}
        @endisset
        <input
            type="tel"
            name="{{ $name }}"
            id="{{ $id }}"
            :value="value"
            @if($placeholder)
                placeholder="{{ $placeholder }}"
            @endif
            @class([
             'block w-full px-3 py-1.5 border duration-300 transition-all sm:text-sm focus:outline-none focus:shadow-full rounded-sm disabled:bg-gray-200',
             'border-gray-200 text-gray-700 placeholder-gray-400 focus:ring-primary-300 focus:border-primary-300 focus:shadow-primary-100/50' => !$errors->has($id),
             'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-300 focus:border-red-300 focus:shadow-red-100/75' => $errors->has($id)
            ])
            @if($required) required="required" @endif
            @disabled($disabled)
            x-mask:dynamic="mask"
            x-on:input="if ($el.value.length === mask.length) { value = $el.value }"
        >
        @isset($slot)
            {{ $slot }}
        @endisset
        @isset($append)
            {{ $append }}
        @endisset
    </div>
</x-wireforms::fields>
