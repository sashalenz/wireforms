<?php

namespace Sashalenz\Wireforms\FormFields;

use Livewire\Component;
use Sashalenz\Wireforms\Components\Fields\NestedSetSelect;
use Sashalenz\Wireforms\Components\Fields\WireSelect;
use Sashalenz\Wireforms\Contracts\FieldContract;
use Sashalenz\Wireforms\Traits\Authorizable;

class WireSelectField extends FormField
{
    use Authorizable;

    protected bool $nullable = false;
    protected ?string $model = null;
    protected bool $searchable = false;
    protected string $orderDir = 'asc';
    protected bool $nestedSet = false;
    protected ?string $createNewModel = null;
    protected ?string $createNewField = null;

    public function model(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function createNewModel(string $modelComponent, ?string $field = null): self
    {
        $component = app($modelComponent);

        if ($component instanceof Component && $this->model && $this->authorizeModel('create', $this->model)) {
            $this->createNewModel = $component::getName();
            $this->createNewField = $field;
        }

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

    protected function render(): FieldContract
    {
        $class = ($this->nestedSet)
            ? NestedSetSelect::class
            : WireSelect::class;

        return $class::make(
            name: $this->getNameOrWireModel(),
            value: $this->value,
            model: $this->model,
            nullable: $this->nullable,
            searchable: $this->searchable,
            orderDir: $this->orderDir,
            label: $this->label,
            help: $this->help,
            placeholder: $this->placeholder,
            required: $this->required,
            readonly: $this->disabled,
            key: $this->key,
            createNewModel: $this->createNewModel,
            createNewField: $this->createNewField
        );
    }
}
