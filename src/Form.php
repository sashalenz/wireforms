<?php

namespace Sashalenz\Wireforms;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use LivewireUI\Modal\ModalComponent;
use Sashalenz\Wireforms\Contracts\FormFieldContract;
use Sashalenz\Wireforms\Traits\HasChild;

abstract class Form extends ModalComponent
{
    use HasChild;

    public Model $model;
    public ?string $submitButton = 'save';
    protected string $title;

    abstract protected function title(): string;

    abstract protected function fields(): array;

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
            ->filter(fn (Field $field) => ! is_null($field->getDefault()))
            ->mapWithKeys(fn (Field $field) => [$field->getName() => $field->getDefault()])
            ->toArray();
    }

    public function updated(string $field): void
    {
        $rules = collect($this->rules())
            ->filter(fn ($value, $key) => $key === $field)
            ->mapWithKeys(fn ($rules, $key) => [
                $key => collect($rules)
                    ->reject(fn ($rule) => in_array($rule, ['required', 'confirmed']))
                    ->values()
                    ->toArray(),
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
            ->tap(fn (Field $field) => $field->wireModel("model.{$field->getName()}"))
            ->toArray();
    }

    public function getTitleProperty(): string
    {
        return $this->title() ?? $this->title;
    }

    public function save(): void
    {
        try {
            $this->validate();
            $this->model->save();

            $this->dispatchBrowserEvent('alert', [
                'status' => 'success',
                'message' => __('wireforms::successfully_saved'),
            ]);

            $this->forceClose()->closeModal();
            $this->dispatchBrowserEvent('$refresh');

            $this->dispatchBrowserEvent('close-modal');
        } catch (\RuntimeException $exception) {
            $this->dispatchBrowserEvent('alert', [
                'status' => 'error',
                'message' => __('wireforms::unable_to_save'),
                'description' => $exception->getMessage(),
            ]);
        }
    }

    public function render(): View
    {
        return view('wireforms::form');
    }
}
