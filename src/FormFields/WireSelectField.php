<?php

namespace Sashalenz\Wireforms\FormFields;

use Sashalenz\Wireforms\Components\Fields\NestedSetSelect;
use Sashalenz\Wireforms\Components\Fields\WireSelect;
use Sashalenz\Wireforms\Contracts\FieldContract;

class WireSelectField extends FormField
{
    protected bool $nullable = false;
    protected ?string $model = null;
    protected bool $searchable = false;
    protected string $orderDir = 'asc';
    protected bool $nestedSet = false;

    public function model(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function nullable(): self
    {
        $this->nullable = true;
        $this->rules[] = 'nullable';

        return $this;
    }

    public function searchable(): self
    {
        $this->searchable = true;

        return $this;
    }

    public function nestedSet(): self
    {
        $this->nestedSet = true;

        return $this;
    }

    public function orderDir(string $orderDir): self
    {
        $this->orderDir = $orderDir;

        return $this;
    }

    public function render(): FieldContract
    {
        if ($this->nestedSet) {
            return NestedSetSelect::make(
                name: $this->getNameOrWireModel(),
                value: $this->value,
                model: $this->model,
                nullable: $this->nullable,
                searchable: $this->searchable,
                orderDir: $this->orderDir,
                label: $this->label,
                required: $this->required
            );
        }

        return WireSelect::make(
            name: $this->getNameOrWireModel(),
            value: $this->value,
            model: $this->model,
            nullable: $this->nullable,
            searchable: $this->searchable,
            orderDir: $this->orderDir,
            label: $this->label,
            required: $this->required
        );
    }
}
