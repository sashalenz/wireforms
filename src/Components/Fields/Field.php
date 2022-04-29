<?php

namespace Sashalenz\Wireforms\Components\Fields;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Sashalenz\Wireforms\Contracts\FieldContract;

abstract class Field extends Component implements FieldContract
{
    public string $id;

    public function __construct(
        public string $name,
        public ?string $value = null,
        public bool $required = false,
        public bool $disabled = false,
        public bool $readonly = false,
        public bool $showLabel = true,
        public ?string $label = null,
        public ?string $locale = null,
        public ?string $placeholder = null,
        public ?string $help = null
    ) {
        $this->id = $this->id();
    }

    private function id(): string
    {
        if ($attribute = $this->attributes?->thatStartWith('wire:model')) {
            return $attribute->first();
        }

        return collect([$this->name, $this->locale])->filter()->implode('.');
    }

    public static function make(...$attributes): static
    {
        return new static(...$attributes);
    }

    abstract public function render(): View;
}
