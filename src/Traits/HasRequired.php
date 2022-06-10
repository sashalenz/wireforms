<?php

namespace Sashalenz\Wireforms\Traits;

use Closure;
use Illuminate\Database\Eloquent\Model;

trait HasRequired
{
    protected bool $required = false;
    protected ?Closure $requiredCondition = null;

    public function isRequired(callable $requiredCondition): self
    {
        $this->requiredCondition = $requiredCondition;

        return $this;
    }

    public function required(): self
    {
        $this->required = true;
        $this->rules[] = 'required';

        return $this;
    }

    private function determinateRequired(?Model $model = null): self
    {
        if (is_callable($this->requiredCondition)) {
            $this->required = (bool)call_user_func($this->requiredCondition, $model);
        }

        return $this;
    }
}
