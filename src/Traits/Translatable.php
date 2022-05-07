<?php

namespace Sashalenz\Wireforms\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Sashalenz\Wireforms\Contracts\FormFieldContract;

trait Translatable
{
    public bool $translatable = false;
    public array $translatableLocales;

    public function translatable(?array $locales = null): self
    {
        $this->translatable = true;
        $this->translatableLocales = $locales ?? array_keys(config('app.locales'));

        return $this;
    }

    public function getRules(): array
    {
        if (!$this->translatable) {
            return [
                $this->getNameOrWireModel() => $this->formatRules()
            ];
        }

        return collect($this->translatableLocales)
            ->mapWithKeys(
                fn (string $locale) => [
                    sprintf('%s.%s', $this->getNameOrWireModel(), $locale) => $this->formatRules()
                ]
            )
            ->all();
    }

    public function renderField(?Model $model = null): Collection
    {
        if (!$this->translatable) {
            return collect([
                $this
                    ->when(
                        $model,
                        fn (FormFieldContract $field) => $field->value(
                            data_get($model?->toArray(), $field->getName())
                        )
                    )
                    ->render()
            ]);
        }

        return collect($this->translatableLocales)
            ->mapWithKeys(
                fn (string $locale) => [$locale => clone $this]
            )
            ->map(
                fn (FormFieldContract $field, string $locale) => $field
                    ->label(
                        sprintf('%s (%s)', $field->label, config('app.locales.'.$locale))
                    )
                    ->when(
                        $field->wireModel,
                        fn (FormFieldContract $field) => $field->wireModel(
                            sprintf('%s.%s', $field->wireModel, $locale)
                        )
                    )
                    ->when(
                        $model,
                        fn (FormFieldContract $field) => $field->value(
                            $model->getTranslation($field->getName(), $locale)
                        )
                    )
                    ->render()
            );
    }
}
