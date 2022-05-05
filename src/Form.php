<?php

namespace Sashalenz\Wireforms;

use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;
use Sashalenz\Wireforms\Contracts\FormFieldContract;
use Sashalenz\Wireforms\Traits\HasChild;

abstract class Form extends ModalComponent
{
    use HasChild;

    abstract protected function fields(): array;

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
        return collect($this->fields())
            ->filter(fn (FormFieldContract $field) => $field->hasRules())
            ->mapWithKeys(fn (FormFieldContract $field) => ["model.{$field->getName()}" => $field->getRules()])
            ->toArray();
    }

    protected function defaults(): array
    {
        return collect($this->fields())
            ->filter(fn (FormFieldContract $field) => ! is_null($field->getDefault()))
            ->mapWithKeys(fn (FormFieldContract $field) => [$field->getName() => $field->getDefault()])
            ->toArray();
    }

    public function updated(string $field, string $value): void
    {
        $rules = collect($this->rules())
            ->filter(fn ($value, $key) => $key === $field)
            ->mapWithKeys(fn ($rules, $key) => [
                $key => collect($rules)
                    ->diff(['required', 'confirmed'])
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

    public function getFieldsProperty(): array
    {
        return collect($this->fields())
            ->each(fn (FormFieldContract $field) => $field->wireModel("model.{$field->getName()}"))
            ->toArray();
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
                'message' => __('wireforms::forms.successfully_saved'),
            ]);

            $this->forceClose()->closeModalWithEvents([
                '$refresh',
            ]);
        } catch (\RuntimeException $exception) {
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
            'title' => collect([
                $this->title(),
                $this->model->getKey(),
            ])
                ->filter()
                ->implode(' №'),
        ]);
    }
}
