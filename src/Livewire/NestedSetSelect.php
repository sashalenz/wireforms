<?php

namespace Sashalenz\Wireforms\Livewire;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Sashalenz\Searchable\Filters\SearchFilter;

class NestedSetSelect extends ModelSelect
{
    public string $model;

    public function mount(
        string $name,
        string $model,
        string $placeholder = null,
        string $value = null,
        bool $required = false,
        bool $readonly = false,
        bool $optgroup = false,
        string $orderDir = 'asc',
        bool $searchable = true
    ): void {
        $this->name = $name;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->model = $model;
        $this->readonly = $readonly;
        $this->optgroup = $optgroup;
        $this->orderDir = $orderDir;
        $this->searchable = $searchable;
    }

    public function setSelected($value): void
    {
        $this->search = '';
        $this->isOpen = false;

        if ($this->value === $value) {
            return;
        }

        $this->value = $value;

        $this->emitUp('updatedChild', $this->name, $this->value);
    }

    public function showResults(): bool
    {
        return is_null($this->minInputLength) || $this->minInputLength < Str::length($this->search);
    }

    protected function selected()
    {
        if (is_null($this->value)) {
            return null;
        }

        return once(
            fn () => $this->searchQuery()
                ->with('ancestors')
                ->find($this->value)
        );
    }

    public function getSelectedValueProperty():? string
    {
        return $this->selected()?->getKey();
    }

    public function getSelectedTitleProperty():? string
    {
        if (is_null($this->selected())) {
            return null;
        }

        return $this->selected()
            ->ancestors
            ->push($this->selected())
            ->implode('name', ' > ');
    }

    public function getModelKeyNameProperty():? string
    {
        return (new $this->model)->getKeyName();
    }

    private function searchQuery(): Builder
    {
        if (method_exists($this->model, 'searchQuery')) {
            return $this->model::searchQuery();
        }

        return $this->model::query();
    }

    public function getResultsProperty(): Collection
    {
        if (!$this->isOpen || !$this->showResults()) {
            return collect();
        }

        return $this->searchQuery()
            ->when(
                $this->searchable,
                fn ($query) => $query
                    ->whereNull('parent_id')
                    ->where(
                        fn ($query) => $query
                            ->tap(new SearchFilter($this->search))
                            ->orWhereHas(
                                'sortedChildren',
                                fn ($query) => $query->tap(new SearchFilter($this->search))
                            )
                    )
                    ->with([
                        'sortedChildren' => fn ($query) => $query->tap(new SearchFilter($this->search))
                    ])
            )
            ->orderBy(
                $this->getModelKeyNameProperty(),
                $this->orderDir
            )
            ->take($this->limit)
            ->get()
            ->filter(fn ($item) => $item->sortedChildren->count());
    }

    public function isCurrent(string $key): bool
    {
        return $this->selected() && $key === $this->selectedValue;
    }
}
