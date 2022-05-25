<?php

namespace Sashalenz\Wireforms\FormFields;

use Sashalenz\Wireforms\Components\Fields\Boolean;
use Sashalenz\Wireforms\Contracts\FieldContract;

class BooleanField extends FormField
{
    protected array $rules = [
        'boolean',
    ];

    public function castValue($value): bool
    {
        return (bool)$value;
    }

    public function render(): FieldContract
    {
        return Boolean::make(
            name: $this->getNameOrWireModel(),
            value: $this->value,
            label: $this->label,
            help: $this->help,
            placeholder: $this->placeholder
        );
    }
}
