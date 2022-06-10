<?php

namespace Sashalenz\Wireforms\FormFields;

use Sashalenz\Wireforms\Components\Fields\Text;
use Sashalenz\Wireforms\Contracts\FieldContract;

class PasswordField extends FormField
{
    public bool $exceptFromModel = true;

    protected function render(): FieldContract
    {
        return Text::make(
            name: $this->getNameOrWireModel(),
            value: $this->value,
            label: $this->label,
            type: 'password',
            key: $this->key,
            help: $this->help,
            placeholder: $this->placeholder,
            required: $this->required,
            disabled: $this->disabled
        );
    }
}
