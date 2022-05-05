<x-wireforms::fields
    :name="$name"
    :id="$id"
    :required="$required"
    :label="$label"
    :locale="$locale"
    :show-label="$showLabel"
    :help="$help"
    {{ $attributes->whereDoesntStartWith(['data', 'x-', 'wire:model', 'wire:change']) }}
>
    <textarea
        @if($locale)
            name="{{ $name }}[{{ $locale }}]"
        @else
            name="{{ $name }}"
        @endif
        id="{{ $id }}"
        rows="{{ $rows }}"
        @if($placeholder)
            placeholder="{{ $placeholder }}"
        @endif
        @class([
         'block w-full px-3 py-1.5 border duration-300 transition-all sm:text-sm focus:outline-none focus:shadow-full rounded-sm',
         'border-gray-200 text-gray-700 placeholder-gray-300 focus:ring-primary-300 focus:border-primary-300 focus:shadow-primary-100/50' => !$errors->has($id),
         'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-300 focus:border-red-300 focus:shadow-red-100/75' => $errors->has($id)
        ])
        @if($required) required="required" @endif
        @disabled($disabled)
        {{ $attributes->whereStartsWith(['wire:model', 'wire:change', 'x-', 'data']) }}
	>{{ $value }}</textarea>
</x-wireforms::fields>
