<?php

namespace Sashalenz\Wireforms\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

abstract class ModelSelect extends Component
{
    public string $model;
    public string $search = '';
    public bool $required = false;
    public string $name;
    public ?string $placeholder = null;
    public ?string $value = null;
    public bool $isOpen = false;
    public bool $readonly = false;
    public bool $searchable = true;
    public int $limit = 20;
    public ?string $orderBy = 'id';
    public ?string $orderDir = 'asc';
    public ?int $minInputLength = null;
    public ?string $createNewModel = null;
    public ?string $createNewField = null;
    public ?string $emitUp = 'updatedChild';

    public function mount(
        string $name,
        string $model,
        string $placeholder = null,
        string $createNewModel = null,
        string $createNewField = null,
        string $value = null,
        bool $required = false,
        bool $readonly = false,
        ?string $orderBy = null,
        ?string $orderDir = null,
        bool $searchable = true
    ): void {
        $this->name = $name;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->model = $model;
        $this->createNewModel = $createNewModel;
        $this->createNewField = $createNewField;
        $this->readonly = $readonly;
        $this->orderBy = $orderBy;
        $this->orderDir = $orderDir;
        $this->searchable = $searchable;
    }

    protected $listeners = [
        'fillParent',
    ];

    public function fillParent(?string $value = null): void
    {
        if ($this->value === $value) {
            return;
        }

        $this->value = $value;
    }

    abstract public function showResults(): bool;

    abstract public function getSelectedValueProperty(): ?string;

    abstract public function getSelectedTitleProperty(): ?string;

    abstract public function getResultsProperty(): ?Collection;

    abstract public function isCurrent(string $key): bool;

    public function getCreateNewParamsProperty(): string
    {
        return collect()
            ->when(
                $this->createNewField && $this->search,
                fn ($collection) => $collection
                    ->put('fillFields', [$this->createNewField => $this->search])
                    ->put('parentModal', $this->id)
            )
            ->toJson();
    }

    public function render(): View
    {
        return view('wireforms::livewire.model-select');
    }
}
