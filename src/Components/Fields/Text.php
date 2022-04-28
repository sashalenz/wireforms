<?php

namespace Sashalenz\Wireforms\Components\Fields;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Text extends Component
{
    public function __construct(
        public string $name,
        public string $type = 'text',
        public ?string $value = null,
        public bool $required = false,
        public bool $disabled = false,
        public bool $showLabel = true,
        public ?string $label = null,
        public ?string $locale = null,
        public ?string $placeholder = null,
        public ?string $help = null,
        public ?string $prepend = null,
        public ?string $append = null
    ) { }

    private function getId(): string
    {
        if ($attribute = $this->attributes?->thatStartWith('wire:model')) {
            return $attribute->first();
        }

        return collect([$this->name, $this->locale])->filter()->implode('.');
    }

    public function render(): View
    {
        return view('wireforms::components.fields.text')->with('id', $this->getId());
    }
}
