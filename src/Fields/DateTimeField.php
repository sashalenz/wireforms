<?php

namespace Sashalenz\Wireforms\Fields;

use Illuminate\Contracts\View\View;

class DateTimeField extends Field
{
    public function render(): View
    {
        return view('wireforms::field.date-time-field');
    }
}
