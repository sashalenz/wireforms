<?php

namespace Sashalenz\Wireforms\Traits;

trait Translatable
{
    public bool $translatable = true;
    public array $translatableLocales;

    public function translatable(?array $locales = null): self
    {
        $this->translatable = true;
        $this->translatableLocales = $locales ?? array_keys(config('app.locales'));

        return $this;
    }
}
