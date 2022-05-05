<div class="border border-primary-300">
    <div class="bg-primary-500 text-white flex justify-between items-center px-4 py-3">
        <h4 class="text-base">{{ $title }}</h4>
        <button type="button" class="text-white hover:text-gray-200 text-xl font-bold" wire:click="$emit('closeModal')">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="relative p-3">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-6">
            @foreach($this->fields as $field)
                {!! $field->renderIt($model) !!}
            @endforeach
        </div>
    </div>
    <div class="p-3 flex justify-end border-t border-gray-100">
        <div>
            <x-wireforms::button.secondary wire:click="$emit('closeModal')">
                @lang('wireforms::form.close')
            </x-wireforms::button.secondary>

            <x-wireforms::button.primary wire:click="save">
                @lang('wireforms::form.save')
            </x-wireforms::button.primary>
        </div>
    </div>
</div>
