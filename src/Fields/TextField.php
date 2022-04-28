<?php

namespace Sashalenz\Wireforms\Fields;

use Illuminate\Contracts\View\View;

class TextField extends Field
{
    public ?string $icon = null;
    public ?string $type = 'text';

    public function __construct(string $name, ?string $title = null, $value = null, ?bool $required = false, ?string $placeholder = null, ?string $default = null, ?string $help = null, ?int $size = 6, ?string $type = 'text', ?string $icon = null)
    {
        $this->icon = $icon;
        $this->type = $type;
        parent::__construct($name, $title, $value, $required, $placeholder, $default, $help, $size);
    }

    public function icon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    public function type(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function render(): View
    {
        return view('wireforms::field.text-field');
    }
}
