<?php

namespace Sashalenz\Wireforms;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
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
    }

    public function validateField(string $field, $value = null)
    {
        $formField = $this->fields
            ->first(
                fn (FormFieldContract $formField) => $formField->getNameOrWireModel() === $field
            );

        if (! $formField || !$formField->hasRules()) {
            return $value;
        }

        $data = $this->model->replicate();

        return $this
            ->withValidator(
                fn (Validator $validator) => $validator->setData([
                    'model' => $data
                        ->forceFill([
                            Str::of($field)->replaceFirst('model.', '')->toString() => $formField->beforeValidate($value)
                        ])
                        ->toArray()
                ])
            )
            ->validateOnly(
                $formField->getNameOrWireModel(),
                $formField->getRules()
            );
    }

    private function fillDefaults(): void
    {
        if (!$this->model?->getKey()) {
            $this->fields
                ->filter(
                    fn (FormFieldContract $field) => $field->hasDefault()
                )
                ->each(fn (FormFieldContract $field) => $this->fillWithHydrate(
                    $field->getNameOrWireModel(),
                    $field->getDefault()
                ));
        }

        if (count($this->fillFields)) {
            $this->fields
                ->filter(
                    fn (FormFieldContract $field) => isset($this->fillFields[$field->getName()])
                )
                ->each(fn (FormFieldContract $field) => $this->fillWithHydrate(
                    $field->getNameOrWireModel(),
                    $this->fillFields[$field->getName()]
                ));
        }
    }

    public function getFieldsProperty(): Collection
    {
        return $this->fields()
            ->filter(
                fn ($field) => $field instanceof FormFieldContract
            )
            ->filter(
                fn ($field) => !method_exists($field, 'canSee') || $field->canRender
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
        $this->fillDefaults();

        return view('wireforms::form', [
            'fields' => $this->fields
                ->map(fn (FormFieldContract $field) => $field->renderIt($this->model))
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
