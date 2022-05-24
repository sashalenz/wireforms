<?php

namespace Sashalenz\Wireforms;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Validation\Validator;
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

    public function updating(string $key, $value = null): void
    {
        $this->validateField($key, $value);

        info(print_r($this->model, 1));
    }

    public function validateField(string $field, $value = null)
    {
        $formField = $this->fields()
            ->first(
                fn (FormFieldContract $formField) => $formField->getNameOrWireModel() === $field
            );

        if (! $formField || ! $formField->hasRules()) {
            return $value;
        }

        return $this
            ->withValidator(
                fn (Validator $validator) => $validator->setData(
                    Arr::undot([$field => $formField->beforeValidate($value)])
                )
            )
            ->validateOnly(
                $field,
                $formField->getRules()
            );
    }

    public function getFieldsProperty(): Collection
    {
        foreach ($this->fillFields as $field => $value) {
            $this->updatedChild('model.'.$field, $value);
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
