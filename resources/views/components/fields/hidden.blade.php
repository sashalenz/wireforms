<input type="hidden"
       name="{{ $name }}"
       id="{{ $id }}"
       @isset($value)
           value="{{ $value }}"
       @endisset
       {{ $attributes->whereStartsWith(['data', 'wire:model', 'wire:change', 'x-']) }}
>
