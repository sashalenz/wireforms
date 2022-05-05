<?php

namespace Sashalenz\Wireforms\Components\Button;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Sashalenz\Wireforms\Contracts\ButtonContract;
use Sashalenz\Wireforms\Traits\Makeable;

class Primary extends Component implements ButtonContract
{
    use Makeable;

    public function __construct(
        public bool $outline = false,
        public ?string $icon = null,
        public ?string $title = null
    ) { }

    public function render(): View
    {
        return view('wireforms::components.button.primary')
            ->with($this->data());
    }
}
