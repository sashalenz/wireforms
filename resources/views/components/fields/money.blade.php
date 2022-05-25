<x-wireforms::fields
    :name="$name"
    :id="$id"
    :required="$required"
    :label="$label"
    :show-label="$showLabel"
    :help="$help"
    {{ $attributes->whereDoesntStartWith(['min', 'max', 'step', 'data', 'x-', 'wire:model', 'wire:change']) }}
>
    <div class="relative flex w-full"
         x-data="{
            amount: '',
            value: @entangle($attributes->wire('model')),
            currency: 'USD',
            update() {
                try {
                    parsedValue = JSON.parse(this.value);
                    this.amount = Number.parseInt(parsedValue.amount) / 100;
                    this.currency = parsedValue.currency;
                } catch (e) {};
            }
         }"
         x-init="
             update();
             $watch('amount', value => $wire.emit('updatedChild', '{{ $id }}', {
                amount: Number.parseFloat(value * 100).toFixed(0),
                currency: currency
             }))
         "
         @update-currency.window="update()"
    >
        <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <input type="number"
               name="{{ $name }}"
               id="{{ $id }}"
               x-model.debounce.1s="amount"
               @if($placeholder)
                   placeholder="{{ $placeholder }}"
               @endif
               @class([
                'block w-full pl-9 pr-12 py-1.5 border duration-300 transition-all sm:text-sm focus:outline-none focus:shadow-full rounded-sm no-spinners',
                'border-gray-200 text-gray-700 placeholder-gray-300 focus:ring-primary-300 focus:border-primary-300 focus:shadow-primary-100/50' => !$errors->has($id),
                'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-300 focus:border-red-300 focus:shadow-red-100/75' => $errors->has($id)
               ])
               @if($required) required="required" @endif
            @disabled($disabled)
            {{ $attributes->whereStartsWith(['min', 'max', 'step', 'data', 'x-']) }}
        >
        @isset($slot)
            {{ $slot }}
        @endisset
        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <span class="text-gray-500 sm:text-sm" x-text="currency"></span>
        </div>
    </div>
</x-wireforms::fields>
