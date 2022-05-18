<x-wireforms::fields
    :name="$name"
    :id="$id"
    :required="$required"
    :label="$label"
    :show-label="$showLabel"
    :help="$help"
    {{ $attributes->whereDoesntStartWith(['data', 'x-', 'wire:model', 'wire:change']) }}
>
    <div class="flex items-center">
        <livewire:wireforms.livewire.nested-set-select
            :name="$id"
            :model="$model"
            :create-new-model="$createNewModel"
            :create-new-field="$createNewField"
            :required="$required"
            :placeholder="$placeholder"
            :readonly="$readonly"
            :searchable="$searchable"
            :nullable="$nullable"
            :order-dir="$orderDir"
            :value="$value"
            :emit-up="$emitUp"
            :key="'wireselect-'.$name"
        />
    </div>
</x-wireforms::fields>
