<?php

namespace Sashalenz\Wireforms\Components\Fields;

use Illuminate\Contracts\View\View;

class Textarea extends Field
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
        public int $rows = 2
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

    public function render(): View
    {
        return view('wireforms::components.fields.textarea')
            ->with($this->data());
    }
}
