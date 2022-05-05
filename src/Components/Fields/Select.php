<?php

namespace Sashalenz\Wireforms\Components\Fields;

use Illuminate\Contracts\View\View;

class Select extends Field
{
    public function __construct(
        string $name,
        ?string $value = null,
        bool $required = false,
        bool $disabled = false,
        bool $readonly = false,
        bool $showLabel = true,
        ?string $label = null,
        ?string $locale = null,
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
            $locale,
            $placeholder,
            $help
        );
    }

    public function isSelected(?string $value = null): bool
    {
        return $this->value === $value;
    }

    public function render(): View
    {
        return view('wireforms::components.fields.select')->with($this->data());
    }
}
