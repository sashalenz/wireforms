<?php

namespace Sashalenz\Wireforms\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

abstract class ModelSelect extends Component
{
    public string $search = '';
    public bool $required = false;
    public string $name;
    public ?string $placeholder = null;
    public ?string $value = null;
    public bool $isOpen = false;
    public bool $readonly = false;
    public bool $searchable = true;
    public int $limit = 20;
    public string $orderDir = 'asc';
    public ?int $minInputLength = null;

    abstract public function showResults(): bool;

    abstract public function getSelectedValueProperty(): ?string;

    abstract public function getSelectedTitleProperty(): ?string;

    abstract public function getResultsProperty(): ?Collection;

    abstract public function isCurrent(string $key): bool;

    public function render(): View
    {
        return view('wireforms::livewire.model-select');
    }
}
