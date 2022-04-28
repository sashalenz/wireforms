<x-wiretable-layout-field :name="$name"
                          :wire-model="$wireModel"
                          :title="$title"
                          :size="$size"
                          :help="$help"
                          :required="$required"
                          :required-icon="$requiredIcon"
                          class="{{ $attributes->whereStartsWith('class')->first() }}"
>
    <div class="relative rounded-md shadow-sm"
         x-data="{ value: @entangle($attributes->wire('model')) }"
         x-init="new window.Pikaday({ field: $refs.input, format: 'YYYY-MM-DD' })"
         x-on:change="value = $event.target.value"
    >
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        <input type="text"
               id="{{ $name }}"
               name="{{ $name }}"
               placeholder="{{ $placeholder }}"
               aria-describedby="{{ $help }}"
               x-ref="input"
               x-bind:value="value"
               class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md pl-10 @if($errors->has($name) || $errors->has($wireModel)) pr-10 border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-2 focus:ring-red-300 @endif"
               @if($required)required="required" @endif
        >
        @error($wireModel ?? $name)
        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
        </div>
        @enderror
    </div>
</x-wiretable-layout-field>
