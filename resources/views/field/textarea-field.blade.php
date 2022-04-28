<x-wiretable-layout-field :name="$name"
                          :wire-model="$wireModel"
                          :title="$title"
                          :size="$size"
                          :help="$help"
                          :required="$required"
                          :required-icon="$requiredIcon"
                          class="{{ $attributes->whereStartsWith('class')->first() }}"
>
    <div class="relative rounded-md shadow-sm">
            <textarea id="{{ $name }}"
                      name="{{ $name }}"
                      placeholder="{{ $placeholder }}"
                      aria-describedby="{{ $name }}"
                      class="max-w-lg shadow-sm block w-full focus:ring-primary-500 focus:border-primary-500 sm:text-sm border-gray-300 rounded-md @if($errors->has($name)) border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @endif"
                      @if($required)required="required" @endif
                      @keyup="$dispatch('type', $event.target.value.length)"
                      @if(isset($attributes) && $attributes->whereStartsWith('wire:model')->first())
                      wire:model="{{ $attributes->whereStartsWith('wire:model')->first() }}"
                      @elseif(isset($attributes) && $attributes->whereStartsWith('wire:change')->first())
                      wire:change="{{ $attributes->whereStartsWith('wire:change')->first() }}('{{ $name }}', $event.target.value)"
                      @else
                      wire:model="{{ $wireModel ?? $name }}"
                      @endif
            ></textarea>
    </div>
</x-wiretable-layout-field>
