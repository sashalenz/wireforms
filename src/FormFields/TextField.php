<?php

namespace Sashalenz\Wireforms\FormFields;

use Sashalenz\Wireforms\Components\Fields\Text;
use Sashalenz\Wireforms\Contracts\FieldContract;
use Sashalenz\Wireforms\Traits\Translatable;

class TextField extends FormField
{
    use Translatable;

    public ?string $type = 'text';

    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function render(): FieldContract
    {
        return Text::make(
            name: $this->getName(),
            value: $this->castValue($this->value),
            label: $this->label,
            type: $this->type,
            required: $this->required
        );
    }
}
