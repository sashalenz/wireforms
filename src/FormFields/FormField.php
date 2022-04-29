<?php

namespace Sashalenz\Wireforms\FormFields;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;
use RuntimeException;
use Sashalenz\Wireforms\Contracts\FormFieldContract;

abstract class FormField extends Component implements FormFieldContract
{
    protected $value = null;
    protected ?string $default = null;

    protected ?bool $required = false;
    protected ?bool $isWireModel = false;
    protected ?string $placeholder = null;
    protected ?string $help = null;

    protected array $rules = [];
    protected array $classes = [];

    protected ?Closure $styleCallback = null;
    protected ?Closure $displayCondition = null;

    public function __construct(
        public string $name,
        public ?string $label = null
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

    public function isWireModel(): self
    {
        $this->isWireModel = true;

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

    public function rules(array $rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    public function addClass(...$classes): self
    {
        $this->classes = array_merge($this->classes, $classes);

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

    protected function getClass(?Model $model = null): ?string
    {
        $class = is_callable($this->styleCallback) && !is_null($model)
            ? call_user_func($this->styleCallback, $model)
            : null;

        if (!is_string($class) && !is_null($class)) {
            throw new RuntimeException('Return value must be a string');
        }

        $this->classes[] = $class;

        return collect($this->classes)
            ->filter()
            ->flatten()
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

    public function renderIt(?Model $model = null): ?View
    {
        $condition = is_callable($this->displayCondition)
            ? call_user_func($this->displayCondition, $model)
            : true;

        if ((bool) $condition === false) {
            return null;
        }

        return $this->render()
            ->withAttributes([
                'class' => $this->getClass($model)
            ]);
    }
}
