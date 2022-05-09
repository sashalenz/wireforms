<?php

namespace Sashalenz\Wireforms\FormFields;

use Illuminate\Validation\Rule;
use Sashalenz\Wireforms\Components\Fields\Phone;
use Sashalenz\Wireforms\Contracts\FieldContract;

class PhoneField extends FormField
{
    protected string $country;

    public function country(string $country): self
    {
        $this->country = $country;
        $this->rules[] = Rule::phone()->country($country);

        return $this;
    }

    protected function render(): FieldContract
    {
        return Phone::make(
            name: $this->getNameOrWireModel(),
            value: $this->value,
            label: $this->label,
            required: $this->required
        );
    }
}
