<?php

namespace Sashalenz\Wireforms\Fields;

use Illuminate\Contracts\View\View;

class TextareaField extends Field
{
    private int $rows;

    public function __construct(string $name, ?string $title = null, $value = null, ?bool $required = false, ?string $placeholder = null, ?string $default = null, ?string $help = null, ?int $size = 6, ?int $rows = 3)
    {
        $this->rows = $rows;
        parent::__construct($name, $title, $value, $required, $placeholder, $default, $help, $size);
    }

    public function rows(int $rows): self
    {
        $this->rows = $rows;
        return $this;
    }

    public function getRows(): int
    {
        return $this->rows;
    }

    public function render(): View
    {
        return view('wireforms::field.textarea-field');
    }
}
