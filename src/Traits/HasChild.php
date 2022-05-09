<?php

namespace Sashalenz\Wireforms\Traits;

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
        $this->validateField($key, $value);

        $this->fill([
            $key => $value,
        ]);
    }
}
