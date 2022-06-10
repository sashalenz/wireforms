<?php

namespace Sashalenz\Wireforms\Traits;

use Illuminate\Support\Str;

trait HasChild
{
    public function bootHasChild(): void
    {
        $this->listeners = array_merge($this->listeners, [
            'updatedChild',
        ]);
    }

    protected function fillWithHydrate($key, $value = null): void
    {
        $this->fill([
            $key => $value === '' ? null : $value,
        ]);

        $method = Str::of($key)
            ->replace('.', '_')
            ->prepend('updated_')
            ->camel()
            ->toString();

        if (method_exists($this, $method)) {
            $this->$method($value);
        }
    }

    public function updatedChild($key, $value = null): void
    {
        $this->validateField($key, $value);

        $this->fillWithHydrate($key, $value);
    }
}
