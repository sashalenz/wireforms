<?php

namespace Sashalenz\Wireforms\Components\Fields;

use Illuminate\Contracts\View\View;

class Phone extends Field
{
    public function render(): View
    {
        return view('wireforms::components.fields.phone')
            ->with($this->data());
    }
}
