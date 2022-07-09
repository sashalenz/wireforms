<?php

namespace Sashalenz\Wireforms\FormFields;

use Sashalenz\Wireforms\Components\Fields\CustomLivewire;
use Sashalenz\Wireforms\Contracts\FieldContract;

class CustomLivewireField extends FormField
{
    protected string $component;
    protected array $params = [];

    public function component(string $component): self
    {
        $this->component = $component;

        return $this;
    }

    public function params(array $params): self
    {
        $this->params = array_merge($this->params, $params);

        return $this;
    }

    public function getParams(): array
    {
        return array_merge(
            $this->params,
            [
                'name' => $this->name,
                'value' => $this->value,
                'required' => $this->required,
            ]
        );
    }

    protected function render(): FieldContract
    {
        return CustomLivewire::make(
            name: $this->getNameOrWireModel(),
            value: $this->value,
            label: $this->label,
            help: $this->help,
            placeholder: $this->placeholder,
            required: $this->required,
            readonly: $this->disabled,
            key: $this->key,
            livewireComponent: $this->component,
            params: $this->params
        );
    }
}
