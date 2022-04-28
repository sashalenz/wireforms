<?php

namespace Sashalenz\Wireforms\FormFields;

use Illuminate\Contracts\View\View;

class BooleanField extends Field
{
    public function castValue($value): bool
    {
        return (bool) $value;
    }

    public function render(): View
    {
        return view('wireforms::field.boolean-field');
    }
}
