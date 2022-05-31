<x-wireforms::fields
    :name="$name"
    :id="$id"
    :required="$required"
    :label="$label"
    :show-label="$showLabel"
    :help="$help"
    {{ $attributes->whereDoesntStartWith(['data', 'x-', 'wire:model', 'wire:change']) }}
    :wire:key="$key"
>
    <div class="flex items-center"
        {{ $attributes->whereStartsWith(['x-']) }}
    >
        <livewire:wireforms.livewire.wire-select
            :name="$id"
            :model="$model"
            :create-new-model="$createNewModel"
            :create-new-field="$createNewField"
            :required="$required"
            :placeholder="$placeholder"
            :readonly="$readonly"
            :searchable="$searchable"
            :nullable="$nullable"
            :order-by="$orderBy"
            :order-dir="$orderDir"
            :value="$value"
            :emit-up="$emitUp"
            :key="$key ?? $id"
        />
    </div>
</x-wireforms::fields>
