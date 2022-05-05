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
        <livewire:wireforms.livewire.wire-select
            :name="$attributes->thatStartWith('wire:model')->first() ?? $name"
            :model="$model"
            :required="$required"
            :placeholder="$placeholder"
            :readonly="$readonly"
            :searchable="$searchable"
            :nullable="$nullable"
            :order-dir="$orderDir"
            :value="$value"
            :key="'wireselect-'.$name"
        />
{{--        @isset($createNewRoute)--}}
{{--            <x-admin.button.primary--}}
{{--                data-action="{{ $createNewRoute }}"--}}
{{--                data-toggle="modal"--}}
{{--                data-target="#modal"--}}
{{--            >--}}
{{--                <i class="far fa-plus"></i>--}}
{{--            </x-admin.button.primary>--}}
{{--        @endisset--}}
    </div>
</x-wireforms::fields>
