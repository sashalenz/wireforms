<?php

namespace Sashalenz\Wireforms\Components\Fields;

use Illuminate\Contracts\View\View;

class Boolean extends Field
{
    public function render(): View
    {
        return view('wireforms::components.fields.boolean')
            ->with($this->data());
    }
}
