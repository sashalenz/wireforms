<?php

namespace Sashalenz\Wireforms;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use LivewireUI\Modal\ModalComponent;
use RuntimeException;
use Sashalenz\Wireforms\Contracts\FormFieldContract;
use Sashalenz\Wireforms\Traits\HasChild;

abstract class Form extends ModalComponent
{
    use HasChild;
    public array $fillFields = [];
    public bool $parentModal = false;

    abstract protected function fields(): Collection;

    abstract protected function title(): string;

    public function beforeSave(): void
    {
//
    }

    public function afterSave(): void
    {
//
    }

    public function rules(): array
    {
        return $this->fields
            ->filter(fn (FormFieldContract $field) => $field->hasRules())
            ->mapWithKeys(fn (FormFieldContract $field) => $field->getRules())
            ->toArray();
    }

    protected function defaults(): array
    {
        return $this->fields
            ->filter(fn (FormFieldContract $field) => ! is_null($field->getDefault()))
            ->mapWithKeys(fn (FormFieldContract $field) => [
                $field->getName() => $field->getDefault(),
            ])
            ->toArray();
    }

    public function updated(string $field): void
    {
        $rules = collect($this->rules())
            ->filter(fn ($value, $key) => $key === $field)
            ->mapWithKeys(fn ($rules, $key) => [
                $key => collect($rules)
                    ->reject(fn ($rule) => in_array($rule, ['required', 'confirmed']))
                    ->all(),
            ])
            ->toArray();

        if (empty($rules)) {
            return;
        }

        $this->validateOnly(
            $field,
            $rules
        );
    }

    public function getFieldsProperty(): Collection
    {
        if (count($this->fillFields)) {
            $this->model->fill($this->fillFields);
        }

        return $this->fields()
            ->filter(
                fn ($field) => $field instanceof FormFieldContract
            )
            ->each(
                fn (FormFieldContract $field) => $field->wireModel("model.{$field->getName()}")
            );
    }

    public function save(): void
    {
        try {
            $this->beforeSave();

            $this->validate();
            $this->model->save();

            $this->afterSave();

            $this->dispatchBrowserEvent('alert', [
                'status' => 'success',
                'message' => __('wireforms::form.successfully_saved'),
            ]);

            if ($this->parentModal) {
                $this->closeModalWithEvents([
                    $this->parentModal => [
                        'fillParent', [$this->model->getKey()],
                    ],
                ]);
            } else {
                $this->closeModalWithEvents([
                    '$refresh',
                ]);
            }
        } catch (RuntimeException $exception) {
            $this->dispatchBrowserEvent('alert', [
                'status' => 'error',
                'message' => __('wireforms::form.unable_to_save'),
                'description' => $exception->getMessage(),
            ]);
        }
    }

    public function render(): View
    {
        return view('wireforms::form', [
            'fields' => $this->fields
                ->map(fn ($field) => $field->renderIt($this->model))
                ->flatten(),
            'title' => collect([
                $this->title(),
                $this->model->getKey(),
            ])
                ->filter()
                ->implode(' №'),
        ]);
    }
}
