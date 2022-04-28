<?php

namespace Sashalenz\Wireforms\Fields;

use Illuminate\Contracts\View\View;

class CustomSelectField extends Field
{
    public ?string $model = null;
    public bool $readonly = false;

    public function __construct(string $name, ?string $title = null, $value = null, ?bool $required = false, ?string $placeholder = null, ?string $default = null, ?string $help = null, ?int $size = 6, $model = null)
    {
        $this->model = $model;

        if (request()->filled($name)) {
            $this->readonly = true;
            $this->setValue(request()->input($name));
        }

        parent::__construct($name, $title, $value, $required, $placeholder, $default, $help, $size);
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function render(): View
    {
        return view('wireforms::field.custom-select-field');
    }
}
