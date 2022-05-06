<?php

namespace Sashalenz\Wireforms\Components\Fields;

use Illuminate\Contracts\View\View;

class WireSelect extends Field
{
    public function __construct(
        string $name,
        $value,
        bool $required = false,
        bool $disabled = false,
        bool $readonly = false,
        bool $showLabel = true,
        ?string $label = null,
        ?string $locale = null,
        ?string $placeholder = null,
        ?string $help = null,

        public ?string $model = null,
        public ?string $createNewModel = null,
        public ?string $createNewField = null,
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
        return view('wireforms::components.fields.wire-select')
            ->with($this->data());
    }
}
