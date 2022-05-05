<?php

namespace Sashalenz\Wireforms\FormFields;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;
use Sashalenz\Wireforms\Contracts\FormFieldContract;
use Throwable;

abstract class FormField implements FormFieldContract
{
    protected $value = null;
    protected ?string $default = null;

    protected ?bool $required = false;
    protected ?string $placeholder = null;
    protected ?string $help = null;

    protected array $rules = [];
    protected array $classes = [];
    protected int $size = 6;

    protected ?Closure $styleCallback = null;
    protected ?Closure $displayCondition = null;

    private ?string $wireModel = null;

    public function __construct(
        protected string $name,
        protected ?string $label = null
    ) {
    }

    public static function make(string $name, ?string $label): static
    {
        return new static($name, $label);
    }

    public function value($value): self
    {
        $this->value = $this->castValue($value);

        return $this;
    }

    public function required(): self
    {
        $this->required = true;

        return $this;
    }

    public function wireModel(string $wireModel): self
    {
        $this->wireModel = $wireModel;

        return $this;
    }

    public function placeholder(?string $placeholder = null): self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function default(string $default): self
    {
        $this->default = $this->castValue($default);

        return $this;
    }

    public function help(string $help): self
    {
        $this->help = $help;

        return $this;
    }

    public function size(int $size): self
    {
        $this->size = ($size > 6 || $size < 1) ? 6 : $size;

        return $this;
    }

    public function rules(array $rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    public function class(string $classes): self
    {
        $this->classes = array_merge(
            $this->classes,
            explode(' ', $classes)
        );

        return $this;
    }

    public function styleUsing(callable $styleCallback): self
    {
        $this->styleCallback = $styleCallback;

        return $this;
    }

    public function displayIf(callable $displayCondition): self
    {
        $this->displayCondition = $displayCondition;

        return $this;
    }

    protected function getClass(?Model $model = null):? string
    {
        return collect($this->classes)
            ->when(
                is_callable($this->styleCallback) && !is_null($model),
                fn ($class) => $class->push((string)call_user_func($this->styleCallback, $model))
            )
            ->when(
                $this->size,
                fn ($class) => $class->push('col-span-'.$this->size)
            )
            ->filter()
            ->flatten()
            ->unique()
            ->implode(' ');
    }

    public function hasRules(): bool
    {
        return count($this->rules);
    }

    public function castValue($value)
    {
        return $value;
    }

    public function getName(): string
    {
        return $this->wireModel ?? $this->name;
    }

    public function getDefault(): string
    {
        return $this->default;
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function renderIt(?Model $model = null):? View
    {
        $condition = is_callable($this->displayCondition)
            ? call_user_func($this->displayCondition, $model)
            : true;

        if ((bool) $condition === false) {
            return null;
        }

        $attributes = [];

        if ($this->wireModel) {
            $attributes['wire:model.debounce.500ms'] = $this->wireModel;
        }

        if ($class = $this->getClass($model)) {
            $attributes['class'] = $class;
        }

        return $this->render()
            ->withAttributes($attributes)
            ->render();
    }
}
