<?php

namespace Sashalenz\Wireforms\FormFields;

use Sashalenz\Wireforms\Components\Fields\Hidden;
use Sashalenz\Wireforms\Contracts\FieldContract;

class HiddenField extends FormField
{
    protected function render(): FieldContract
    {
        return Hidden::make(
            name: $this->getNameOrWireModel(),
            value: $this->value,
            label: $this->label,
            key: $this->key,
        );
    }
}
