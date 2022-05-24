<?php

namespace Sashalenz\Wireforms\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait HasChild
{
    public function bootHasChild(): void
    {
        $this->listeners = array_merge($this->listeners, [
            'updatedChild',
        ]);
    }

    public function updatedChild($key, $value): void
    {
        $validated = $this->validateField($key, $value);

        $this->fill([
            $key => $validated
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
}
