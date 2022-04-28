<div class="border border-primary-300">
    <div class="bg-primary-500 text-white flex justify-between items-center px-4 py-3">
        <h4 class="text-base">{{ $this->title }}</h4>
        <button type="button" class="text-white text-xl font-bold" wire:click="$emit('closeModal')">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="relative p-3">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-6">
            @foreach($this->fields as $field)
                <x-dynamic-component :component="$field" :model="$this->modelClass" />
            @endforeach
        </div>
    </div>
    <div class="p-3 flex justify-end border-t border-gray-100">
        <div>
            <x-wireforms::button.secondary wire:click="$emit('closeModal')">
                {{ __('wireforms::close') }}
            </x-wireforms::button.secondary>

            @if($submitButton)
                <x-wireforms::button.primary wire:click="$emit('save')">
                    {{ $submitButton }}
                </x-wireforms::button.primary>
            @endif
        </div>
    </div>
</div>
