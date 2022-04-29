<?php

namespace Sashalenz\Wireforms\FormFields;

use Illuminate\Contracts\View\View;
use Sashalenz\Wireforms\Components\Fields\Select;

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

    public function render(): View
    {
        return Select::make(
            name: $this->name,
            value: $this->castValue($this->value),
            label: $this->label,
            required: $this->required,

        );
    }
}
