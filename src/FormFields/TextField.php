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

    public function number(): self
    {
        $this->type = 'number';
        $this->rules[] = 'numeric';

        return $this;
    }

    protected function render(): FieldContract
    {
        return Text::make(
            name: $this->getNameOrWireModel(),
            value: $this->value,
            label: $this->label,
            type: $this->type,
            required: $this->required,
            disabled: $this->disabled
        );
    }
}
