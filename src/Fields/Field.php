<?php

namespace Sashalenz\Wireforms\Fields;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use RuntimeException;

abstract class Field extends Component
{
    protected array $rules = [];
    protected Collection $classes;
    protected ?Closure $styleCallback = null;
    protected ?Closure $displayCondition = null;

    protected $except = [
        'renderIt',
        'make',
        'setValue',
        'setDefault',
        'setIcon',
        'setRules',
        'setType',
        'setSize',
        'isRequired',
        'setPlaceholder',
        'setHelp',
        'addClass',
        'getRules',
        'setOptions',
        'setCast',
        'getCast',
        'hasCast',
    ];

    public function __construct(
        private string $name,
        private ?string $title = null,
        private $value = null,
        private ?bool $required = false,
        private ?string $placeholder = null,
        private $default = null,
        private ?string $help = null,
        private ?string $wireModel = null,
        private ?int $size = 6
    ) {
    }

    public function size(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function placeholder(?string $placeholder = null): self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function value($value): self
    {
        $this->value = $this->castValue($value);

        return $this;
    }

    public function default(string $default): self
    {
        $this->default = $this->castValue($default);

        return $this;
    }

    public function wireModel(string $wireModel): self
    {
        $this->wireModel = $wireModel;

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

    public function required(): self
    {
        $this->required = true;

        return $this;
    }

    public function addClass(...$classes): self
    {
        $this->classes->push($classes);

        return $this;
    }

    private function getClass(Model $model): ?string
    {
        $class = is_callable($this->styleCallback) ? call_user_func($this->styleCallback, $model) : null;

        if (! is_string($class) && ! is_null($class)) {
            throw new RuntimeException('Return value must be a string');
        }

        $this->classes->push($class);

        return $this->classes
            ->filter()
            ->flatten()
            ->implode(' ');
    }

    public function hasRules(): bool
    {
        return count($this->rules);
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDefault(): string
    {
        return $this->default;
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

    public function getDataArray(): array
    {
        return collect($this->data())
            ->filter(fn ($value, $key) => ! in_array($key, ['getDataArray', 'attributes']))
            ->mapWithKeys(fn ($value, $key) => [$key => is_null($value) ? '' : $value])
            ->toArray();
    }

    private function castValue($value)
    {
        return $value;
    }

    public static function make(...$attributes): static
    {
        return new static(...$attributes);
    }

    public function renderIt(?Model $model = null): ?View
    {
        $condition = is_callable($this->displayCondition)
            ? call_user_func($this->displayCondition, $model)
            : true;

        if ((bool) $condition === false) {
            return null;
        }

        return $this->render()->with($this->data());
    }
}
