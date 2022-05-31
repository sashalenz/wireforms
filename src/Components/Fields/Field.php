<?php

namespace Sashalenz\Wireforms\Components\Fields;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Traits\Tappable;
use Illuminate\View\Component;
use Sashalenz\Wireforms\Contracts\FieldContract;

abstract class Field extends Component implements FieldContract
{
    use Tappable;

    public string $id;

    public function __construct(
        public string $name,
        public $value,
        public bool $required = false,
        public bool $disabled = false,
        public bool $readonly = false,
        public bool $showLabel = true,
        public ?string $label = null,
        public ?string $key = null,
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

        return $this->name;
    }

    public static function make(...$attributes): static
    {
        return new static(...$attributes);
    }

    abstract public function render(): View;
}
