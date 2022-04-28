<div
        @if(isset($attributes) && $attributes->whereStartsWith('class')->first())
        {{ $attributes->whereStartsWith('class')->merge(['class' => "col-span-6 md:col-span-{$size}"]) }}
        @else
        class="col-span-6 md:col-span-{{ $size }} {{ $class ?? '' }}"
        @endif
>
    <div x-data="{ delayed : 0 }" x-init="requestAnimationFrame(() => delayed = 1)">
        <template x-if="delayed">
            <div class="flex items-center">
                <button type="button"
                        @click="on = !on"
                        :aria-pressed="on !== null ? on.toString() : 'false'"
                        aria-pressed="false"
                        aria-labelledby="toggleLabel"
                        x-data="{ on: @entangle($wireModel ?? $name) }"
                        :class="{ 'bg-gray-200': !on, 'bg-primary-600': on }"
                        class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 bg-gray-200"
                >
                    <span class="sr-only">{{ $title }}</span>
                    <span aria-hidden="true"
                          :class="{ 'translate-x-5': on, 'translate-x-0': !on }"
                          class="inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200 translate-x-0"
                    ></span>
                </button>
                <span class="ml-3" id="toggleLabel">
                    <span class="text-sm font-medium text-gray-900">{{ $title }}</span>
                    @isset($help)<span class="font-light text-sm text-gray-500">{{ $help }}</span>@endisset
                </span>
            </div>
            @error($name)
            <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
            @enderror
        </template>
    </div>
</div>
