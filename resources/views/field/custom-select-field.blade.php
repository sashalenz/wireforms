<x-wiretable-layout-field :name="$name"
                          :title="$title"
                          :size="$size"
                          :help="$help"
                          :required="$required"
                          :required-icon="$requiredIcon"
                          class="{{ $attributes->whereStartsWith('class')->first() }}"
>
    <livewire:model-search :name="$name" :model="$model" :required="$required" :placeholder="$placeholder" :readonly="$readonly" :value="$value ?? optional($model)->{$name}" :key="'custom-select-field-'.$name" />
</x-wiretable-layout-field>
