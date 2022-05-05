<?php

namespace Sashalenz\Wireforms\FormFields;

use Sashalenz\Wireforms\Components\Fields\Wireselect;
use Sashalenz\Wireforms\Contracts\FieldContract;

class WireselectField extends FormField
{
    protected bool $nullable = false;
    protected ?string $model = null;
    protected bool $searchable = false;
    protected string $orderDir = 'asc';

    public function nullable(): self
    {
        $this->nullable = true;

        return $this;
    }

    public function model(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function searchable(bool $searchable): self
    {
        $this->searchable = $searchable;

        return $this;
    }

    public function orderDir(string $orderDir): self
    {
        $this->orderDir = $orderDir;

        return $this;
    }

    public function render(): FieldContract
    {
        return Wireselect::make(
            name: $this->getName(),
            value: $this->castValue($this->value),
            model: $this->model,
            nullable: $this->nullable,
            searchable: $this->searchable,
            orderDir: $this->orderDir,
            label: $this->label,
            required: $this->required
        );
    }
}
