<?php

namespace Sashalenz\Wireforms\Components\Fields;

use Illuminate\Contracts\View\View;

class Money extends Field
{
    public function render(): View
    {
        return view('wireforms::components.fields.money')
            ->with($this->data());
    }
}
