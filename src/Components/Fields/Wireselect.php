<?php

namespace Sashalenz\Wireforms\Components\Fields;

use Illuminate\Contracts\View\View;

class Wireselect extends Field
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

        public ?string $model = null,
        public bool $nullable = false,
        public bool $searchable = false,
        public string $orderDir = 'asc'
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

    public function render(): View
    {
        return view('wireforms::components.fields.wireselect')->with($this->data());
    }
}
