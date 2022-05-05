<?php

namespace Sashalenz\Wireforms\FormFields;

use Sashalenz\Wireforms\Components\Fields\Textarea;
use Sashalenz\Wireforms\Contracts\FieldContract;

class TextareaField extends FormField
{
    private ?int $rows = 2;

    public function rows(int $rows): self
    {
        $this->rows = $rows;

        return $this;
    }

    public function render(): FieldContract
    {
        return Textarea::make(
            name: $this->getName(),
            value: $this->castValue($this->value),
            label: $this->label,
            rows: $this->rows,
            required: $this->required
        );
    }
}
