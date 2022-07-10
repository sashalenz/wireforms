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
use Sashalenz\Wireforms\Traits\HasDefaults;

abstract class Form extends ModalComponent
{
    use HasChild;
    use HasDefaults;

    public ?string $parentModal = null;
    private array $emitFields = [];

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

    public function validateField(string $field, $value = null)
    {
        $formField = $this->fields
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
                $formField->getNameOrWireModel(),
                Arr::except($formField->getRules(), 'current')
            );
    }

    public function getFieldsProperty(): Collection
    {
        return $this->fields()
            ->filter(
                fn ($field) => $field instanceof FormFieldContract
            )
            ->filter(
                fn (FormFieldContract $field) => ! method_exists($field, 'canSee') || $field->canRender
            );
    }

    public function freshFields(): void
    {
        $this->computedPropertyCache['fields'] = $this->getFieldsProperty();
    }

    protected function performSave(): void
    {
        if (! $this->model->isDirty()) {
            return;
        }

        $this->validate();
        $this->model->save();
    }

    public function save(): void
    {
        try {
            $this->beforeSave();

            $this->performSave();

            $this->afterSave();

            $this->dispatchBrowserEvent('alert', [
                'status' => 'success',
                'message' => __('wireforms::form.successfully_saved'),
            ]);

            if (! is_null($this->parentModal)) {
                $this->closeModalWithEvents([
                    [
                        'fillParent.' . $this->parentModal, [ $this->model->getKey() ],
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

    protected function renderTitle(): string
    {
        return collect([
            $this->title(),
            $this->model->getKey(),
        ])
            ->filter()
            ->implode(' №');
    }

    public function render(): View
    {
        return view('wireforms::form', [
            'fields' => $this->fields
                ->map(fn (FormFieldContract $field) => $field->renderIt($this->model))
                ->flatten(),
            'title' => $this->renderTitle(),
        ]);
    }
}
