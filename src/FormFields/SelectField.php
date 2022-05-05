<?php

namespace Sashalenz\Wireforms\FormFields;

use Sashalenz\Wireforms\Components\Fields\Select;
use Sashalenz\Wireforms\Contracts\FieldContract;

class SelectField extends FormField
{
    protected array $options = [];
    protected bool $nullable = false;

    public function options(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function nullable(): self
    {
        $this->nullable = true;

        return $this;
    }

    public function render(): FieldContract
    {
        return Select::make(
            name: $this->getNameOrWireModel(),
            value: $this->value,
            options: $this->options,
            nullable: $this->nullable,
            label: $this->label,
            required: $this->required
        );
    }
}
