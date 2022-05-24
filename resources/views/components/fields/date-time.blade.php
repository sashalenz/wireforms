<x-wireforms::fields
    :name="$name"
    :id="$id"
    :required="$required"
    :label="$label"
    :show-label="$showLabel"
    :help="$help"
    {{ $attributes->whereDoesntStartWith(['wire:model', 'wire:change']) }}
>
    <div class="input-group" x-data="{ value: @entangle($attributes->wire('model')) }" wire:ignore>
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            @isset($prepend)
                {{ $prepend }}
            @else
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            @endisset
        </div>
        <input type="text"
               name="{{ $name }}"
               id="{{ $id }}"
               :value="value"
               x-datetime
               x-model="value"
               x-ref="input"
               @if($placeholder)
                   placeholder="{{ $placeholder }}"
               @endif
               @class([
                'block w-full px-3 py-1.5 border duration-300 transition-all sm:text-sm focus:outline-none focus:shadow-full rounded-sm pl-10',
                'border-gray-200 text-gray-700 placeholder-gray-300 focus:ring-primary-300 focus:border-primary-300 focus:shadow-primary-100/50' => !$errors->has($id),
                'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-300 focus:border-red-300 focus:shadow-red-100/75' => $errors->has($id),
                'pr-10' => isset($slot, $append),
               ])
               data-time="{{ $time ? 'true' : 'false' }}"
               data-mode="{{ $mode }}"
               data-format="{{ $time ? $timeFormat : $format }}"
               @if($required) required="required" @endif
               @disabled($disabled)
        >
        @if($allowClear)
            <span class="absolute inset-y-0 right-0 flex items-center pr-2 cursor-pointer" x-show="$refs.input.value" x-on:click.prevent="value = null && $refs.input.flatpickr().clear()">
                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </span>
        @endif
    </div>
</x-wireforms::fields>
