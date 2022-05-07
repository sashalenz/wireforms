<?php

namespace Sashalenz\Wireforms\Components\Fields;

use Illuminate\Contracts\View\View;

class Select extends Field
{
    public function __construct(
        string $name,
        $value,
        bool $required = false,
        bool $disabled = false,
        bool $readonly = false,
        bool $showLabel = true,
        ?string $label = null,
        ?string $placeholder = null,
        ?string $help = null,
        public array $options = [],
        public bool $nullable = false,
        public bool $multiple = false
    ) {
        parent::__construct(
            $name,
            $value,
            $required,
            $disabled,
            $readonly,
            $showLabel,
            $label,
            $placeholder,
            $help
        );
    }

    public function isSelected(mixed $value): bool
    {
        return $this->value === $value;
    }

    public function render(): View
    {
        return view('wireforms::components.fields.select')->with($this->data());
    }
}
