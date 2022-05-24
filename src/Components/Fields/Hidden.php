<?php

namespace Sashalenz\Wireforms\Components\Fields;

use Illuminate\Contracts\View\View;

class Hidden extends Field
{
    public function render(): View
    {
        return view('wireforms::components.fields.hidden')
            ->with($this->data());
    }
}
