<x-wiretable-layout-field :name="$name"
                          :title="$title"
                          :size="$size"
                          :help="$help"
                          :required="$required"
                          :required-icon="$requiredIcon"
                          class="{{ $attributes->whereStartsWith('class')->first() }}"
>
    <livewire:single-image :name="$name" :value="$value" :key="'single-image-field-'.$name" />
</x-wiretable-layout-field>
